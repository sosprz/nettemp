/************************************************************************
  DHT Temperature & Humidity Sensor library for use on Single Board
  Computers (e.g. FoxG20, AriettaG25, RaspberryPi).

  Author: Ondrej Wisniewski
  
  Features:
  - Support for DHT11 and DHT22/AM2302/RHT03
  - Auto detect sensor model

  Datasheets:
  - http://www.micro4you.com/files/sensor/DHT11.pdf
  - http://www.adafruit.com/datasheets/DHT22.pdf
  - http://dlnmh9ip6v2uc.cloudfront.net/datasheets/Sensors/Weather/RHT03.pdf
  - http://meteobox.tk/files/AM2302.pdf

  Build command:
  gcc -o dht dht_gpio.c dht_spi.c dht.c 
  
  Changelog:
   18-10-2013: Initial version (porting from arduino-DHT)
   17-03-2014: Added functions for sensor power switching
   11-11-2014: Added sensor reading via SPI interface

 ******************************************************************
   
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software Foundation,
  Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
   
 ******************************************************************/

#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <string.h>
#include <unistd.h>
#include <errno.h>
#include <fcntl.h>

#include "dht.h"

#define EXPORT_FILE    "/sys/class/gpio/export"
#define UNEXPORT_FILE  "/sys/class/gpio/unexport"
#define GPIO_BASE_FILE "/sys/class/gpio/gpio"

/* Global variables */
float temperature;
float humidity;
uint8_t data_pin;
DHT_MODEL_t sensor_model;
DHT_ERROR_t error_code;
uint32_t last_read_time;

/* Imported functions */
extern void dhtSetup_gpio(uint8_t pin, DHT_MODEL_t model);
extern void dhtCleanup_gpio(void);
extern void readSensor_gpio();
extern void dhtSetup_spi(DHT_MODEL_t model);
extern void dhtCleanup_spi(void);
extern void readSensor_spi();


/*********************************************************************
 * PUBLIC FUNCTIONS
 ********************************************************************/

/*********************************************************************
 * Function: dhtSetup()
 * 
 * Description: Setup of globally used resources
 * 
 * Parameters: pin - GPIO Kernel Id of used IO pin
 *             model - sensors model
 * 
 ********************************************************************/
void dhtSetup(uint8_t pin, DHT_MODEL_t model)
{
  if (pin)  
     dhtSetup_gpio(pin, model);
  else
     dhtSetup_spi(model);
}

/*********************************************************************
 * Function:    dhtCleanup()
 * 
 * Description: Cleanup of globally used resources
 * 
 * Parameters:  none
 * 
 ********************************************************************/
void dhtCleanup(void)
{
  if (data_pin)
     dhtCleanup_gpio();
  else
     dhtCleanup_spi();
}

/*********************************************************************
 * Function: dhtPoweron()
 * 
 * Description: Power on the sensor via a dedicated GPIO pin
 * 
 * Parameters: pin - Kernel Id of GPIO pin used for sensor power
 * 
 ********************************************************************/
void dhtPoweron(uint8_t pin)
{
  int fd;
  char b[64];
  
  // Prepare GPIO pin connected to sensors data pin to be used with GPIO sysfs
  // (export to user space)
  fd = open(EXPORT_FILE, O_WRONLY);
  if (fd < 0) {
    perror(EXPORT_FILE);
    error_code = ERROR_OTHER;
    return;
  }  
  snprintf(b, sizeof(b), "%d", pin);
  if (pwrite(fd, b, strlen(b), 0) < 0) {
    fprintf(stderr, "Unable to export pin=%d (already in use?): %s\n",
            pin, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }  
  close(fd);
  
  // Define gpio direction to "out"
  snprintf(b, sizeof(b), "%s%d/direction", GPIO_BASE_FILE, pin);
  fd = open(b, O_RDWR);
  if (fd < 0) {
    fprintf(stderr, "Open %s: %s\n", b, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  if (pwrite(fd, "out", 4, 0) < 0) {
    fprintf(stderr, "Unable to pwrite to gpio direction for pin %d: %s\n",
            pin, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  close(fd);
  
  // Set gpio value to "1"
  snprintf(b, sizeof(b), "%s%d/value", GPIO_BASE_FILE, pin);
  fd = open(b, O_RDWR);
  if (fd < 0) {
    fprintf(stderr, "Open %s: %s\n", b, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  if (pwrite(fd, "1", 1, 0) != 1) {
    fprintf(stderr, "Unable to pwrite 1 to gpio value: %s\n",
                     strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  close(fd);
  sleep(1);
  error_code = ERROR_NONE;
}

/*********************************************************************
 * Function: dhtPoweroff()
 * 
 * Description: Power off the sensor via a dedicated GPIO pin
 * 
 * Parameters: pin - Kernel Id of GPIO pin used for sensor power
 * 
 ********************************************************************/
void dhtPoweroff(uint8_t pin)
{
  int fd;
  char b[64];
  
  // Set gpio value to "0"
  snprintf(b, sizeof(b), "%s%d/value", GPIO_BASE_FILE, pin);
  fd = open(b, O_RDWR);
  if (fd < 0) {
    fprintf(stderr, "Open %s: %s\n", b, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  if (pwrite(fd, "0", 1, 0) != 1) {
    fprintf(stderr, "Unable to pwrite 0 to gpio value: %s\n",
                     strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  close(fd);    
  
  // free GPIO pin connected to sensors power pin to be used with GPIO sysfs  
  fd = open(UNEXPORT_FILE, O_WRONLY);
  if (fd < 0) {
    perror(UNEXPORT_FILE);
    error_code = ERROR_OTHER;
    return;
  } 
  snprintf(b, sizeof(b), "%d", pin);
  if (pwrite(fd, b, strlen(b), 0) < 0) {
    fprintf(stderr, "Unable to unexport pin=%d: %s\n",
            pin, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  close(fd);
  error_code = ERROR_NONE;
}

/*********************************************************************
 * Function: dhtReset()
 * 
 * Description: Reset the sensor by powering it off for 1s
 * 
 * Parameters: pin - Kernel Id of GPIO pin used for sensor power
 * 
 ********************************************************************/
void dhtReset(uint8_t pin)
{
  int fd;
  char b[64];
  
  snprintf(b, sizeof(b), "%s%d/value", GPIO_BASE_FILE, pin);
  fd = open(b, O_RDWR);
  if (fd < 0) {
    fprintf(stderr, "Open %s: %s\n", b, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  // Set gpio value to "0"
  if (pwrite(fd, "0", 1, 0) != 1) {
    fprintf(stderr, "Unable to pwrite 0 to gpio value: %s\n",
                     strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  
  // wait 1 sec
  sleep(1);
  
  // Set gpio value to "1"
  if (pwrite(fd, "1", 1, 0) != 1) {
    fprintf(stderr, "Unable to pwrite 0 to gpio value: %s\n",
                     strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  
  close(fd);
  error_code = ERROR_NONE;
}

/*********************************************************************
 * Function:    resetTimer()
 * 
 * Description: 
 * 
 * Parameters:  none
 * 
 * Return:
 * 
 ********************************************************************/
void resetTimer()
{
  last_read_time = 0; // TODO micros()*1000 - 3000;
}

/*********************************************************************
 * Function:    getHumidity()
 * 
 * Description: get humidity value read with latest readSensor()
 * 
 * Parameters:  none
 * 
 * Return:      relative humidity in %
 * 
 ********************************************************************/
float getHumidity()
{
  return humidity;
}

/*********************************************************************
 * Function:    getTemperature()
 * 
 * Description: get temperature value read with latest readSensor()
 * 
 * Parameters:  none
 * 
 * Return:      temperature in °C
 * 
 ********************************************************************/
float getTemperature()
{
  return temperature;
}

/*********************************************************************
 * Function:    getStatus()
 * 
 * Description: get latest error code
 * 
 * Parameters:  none
 * 
 * Return:      error_code
 * 
 ********************************************************************/
DHT_ERROR_t getStatus() 
{ 
   return error_code; 
}

/*********************************************************************
 * Function:    getStatusString()
 * 
 * Description: get latest error string
 * 
 * Parameters:  none
 * 
 * Return:      error desciption
 * 
 ********************************************************************/
const char* getStatusString()
{
  switch ( error_code ) 
  {
    case ERROR_TIMEOUT:
      return "TIMEOUT";

    case ERROR_CHECKSUM:
      return "CHECKSUM";
      
    case ERROR_OTHER:
      return "OTHER";

    default:
      return "OK";
  }
}

/*********************************************************************
 * Function:    readSensor()
 * 
 * Description: handles the communication with the sensor and reads
 *              the current sensor data
 * 
 * Parameters:  none
 * 
 * Return:      sets the following global variables:
 *              - error_code
 *              - temperature
 *              - humidity
 ********************************************************************/
void readSensor()
{
  if (data_pin) 
     readSensor_gpio();
  else
     readSensor_spi();
}
