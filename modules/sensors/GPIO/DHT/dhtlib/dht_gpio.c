/************************************************************************

  This file is part of the libdht "DHT Temperature & Humidity Sensor"
  library.
  
  This is the implementation of the DHT sensor reading functions using
  GPIO pins as communication bus.

  Author: Ondrej Wisniewski
  
  Features:
  - Support for DHT11 and DHT22/AM2302/RHT03
  - Auto detect sensor model

  Based on code for Arduino from Mark Ruys, mark@paracas.nl
  http://www.github.com/markruys/arduino-DHT
  
  Changelog:
   18-10-2013: Initial version (porting from arduino-DHT)
   17-03-2014: Added functions for sensor power switching
   11-11-2014: Moved the GPIO specific functions into their own file
   24-11-2014: Changed handling of sysfs filenames to support different 
               namig schemes used by various micro processors and
               kernel versions
               
************************************************************************/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <errno.h>
#include <fcntl.h>
#include <time.h>
#include <stdint.h>

#include "dht.h"

// Debug mode: set to 1 to print debug information
#define DEBUG 0

// For systems not using the standard GPIO sysfs naming scheme
// /sys/class/gpio/gpio<N> 
// uncomment the line referring to your system
//#define AT91_SYSFS

#define GPIO_BASE_DIR  "/sys/class/gpio"
#define EXPORT_FILE    "/sys/class/gpio/export"
#define UNEXPORT_FILE  "/sys/class/gpio/unexport"

// timing parameters for serial bit detection
// (numbers are in microseconds)
#define MAX_PULSE_LENGTH_ZERO 50 // 26-28us
#define MAX_PULSE_LENGTH_ONE 120 // 70us
#define MAX_BIT_LENGTH MAX_PULSE_LENGTH_ONE
#define MAX_RESPONSE_BITS 40     // 5 bytes
#define MAX_RESPONSE_EDGES MAX_RESPONSE_BITS*2
#define INIT_DELAY 500000
#define DHT11_START_DELAY 20*1000  // min 18ms
#define DHT22_START_DELAY 1000     // min 800us

/* Imported variables */
extern float temperature;
extern float humidity;
extern uint8_t data_pin;
extern DHT_MODEL_t sensor_model;
extern DHT_ERROR_t error_code;
extern uint32_t last_read_time;

static int value_fd;
static int direction_fd;


/*********************************************************************
 * INTERNAL FUNCTIONS
 ********************************************************************/

/*********************************************************************
 * Function:    pinMode()
 * 
 * Description: Set the direction mode for the data pin
 * 
 * Parameters:  iomode - direction (IN|OUT)
 * 
 ********************************************************************/
static void pinMode(DHT_IOMODE_t iomode)
{
  int fd=direction_fd;
  int res;
    
  if (iomode == INPUT)
    res = pwrite(fd, "in", 3, 0);
  else
    res = pwrite(fd, "out", 4, 0);
  
  if (res < 0) {
    fprintf(stderr, "Unable to pwrite to gpio direction for pin %d: %s\n",
            data_pin, strerror(errno));
  }
}

/*********************************************************************
 * Function:    digitalWrite()
 * 
 * Description: Write to the data pin
 * 
 * Parameters:  value - outpur value (HIGF|LOW)
 * 
 ********************************************************************/
static void digitalWrite(PIN_STATE_t value)
{
  int fd=value_fd;
  char d[1];
  
  d[0] = (value == LOW ? '0' : '1');
  if (pwrite(fd, d, 1, 0) != 1) {
    fprintf(stderr, "Unable to pwrite %c to gpio value: %s\n",
                     d[0], strerror(errno));
  }
}

/*********************************************************************
 * Function:    digitalRead()
 * 
 * Description: Read from the data pin
 * 
 * Parameters:  none
 * 
 ********************************************************************/
static PIN_STATE_t digitalRead(void)
{
  int fd=value_fd;
  char d[1];

  if (pread(fd, d, 1, 0) != 1) {
    fprintf(stderr, "Unable to pread gpio value: %s\n",
                     strerror(errno));
  } 
  
  return (d[0] == '0' ? LOW : HIGH);
}

/*********************************************************************
 * Function:    micros()
 * 
 * Description: Reads the current time
 * 
 * Parameters:  none
 * 
 * Return:      The microsseconds part of the current time 
 * 
 ********************************************************************/
static long micros(void)
{
  static long first = -1;
  long nsec;
  struct timespec now_ts;
  

  /* clock_gettime() needs '-lrt' on the link line */
  if (clock_gettime(CLOCK_MONOTONIC, &now_ts) < 0) {
      fprintf(stderr, "clock_gettime(CLOCK_MONOTONIC) failed: %s\n",
              strerror(errno));
      return 0;
  }
  
  // store first reading
  if (first == -1) first=now_ts.tv_nsec;
  
  // check for zero crossing of nano seconds
  if (now_ts.tv_nsec < first) 
    nsec=now_ts.tv_nsec+1000000;
  else
    nsec=now_ts.tv_nsec;
  
  // convert to micro seconds
  return nsec/1000;
}

/*********************************************************************
 * Function:    check_clkres()
 * 
 * Description: Checks the available clock resolution and issues
 *              a warning when it is not good enough (>1ms).
 *              This happens with kernels that don't have
 *              CONFIG_HIGH_RES_TIMERS option enabled.
 * 
 * Parameters:  none
 * 
 * Return:      none
 * 
 ********************************************************************/
static void check_clkres(void)
{
  struct timespec res_ts;
  clock_getres(CLOCK_MONOTONIC, &res_ts);
  if (res_ts.tv_nsec > 1000) {
    fprintf(stderr, "WARNING: clock resolution (%uns) is not good enough on you system\n", 
                    (unsigned int)res_ts.tv_nsec);
  }
}

/*********************************************************************
 * Function:    sysfs_filename()
 * 
 * Description: Assembles the filename of the GPIO sysfs file
 *              associated to the pin number and function.
 *              
 *              The standard naming scheme according to kernel 
 *              documentation is the following:
 *              /sys/class/gpio/gpio<id>/<function>
 * 
 *              However this seems to differ depending on the 
 *              used micro processor and kernel version.
 * 
 * Parameters:  filename (out): complete name of sysfs file
 *              len (in)      : length of the filename buffer
 *              pin (in)      : GPIO Kernel Id of used IO pin
 *              function (in) : name of GPIO function
 * 
 * Return:      none
 * 
 ********************************************************************/
static void sysfs_filename(char *filename, int len, int pin, const char *function)
{
#ifdef AT91_SYSFS
  // Use the naming scheme for AT91 micro processor family
  snprintf(filename, len, "%s/pio%c%d/%s", GPIO_BASE_DIR, 'A'+pin/32, pin%32, function);
#else
  // Use the standard naming scheme
  snprintf(filename, len, "%s/gpio%d/%s", GPIO_BASE_DIR, pin, function);
#endif
  // Note: might need to add more naming schemes here
}
  

/*********************************************************************
 * PUBLIC FUNCTIONS
 ********************************************************************/

/*********************************************************************
 * Function: dhtSetup_gpio()
 * 
 * Description: Setup of globally used resources
 * 
 * Parameters: pin - GPIO Kernel Id of used IO pin
 *             model - sensors model
 * 
 ********************************************************************/
void dhtSetup_gpio(uint8_t pin, DHT_MODEL_t model)
{
  int fd;
  char b[64];

  // store globals
  data_pin = pin;
  sensor_model = model;
  resetTimer(); // Make sure we do read the sensor in the next readSensor()

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
  
  // Open gpio direction file for fast reading/writing when requested
  sysfs_filename(b, sizeof(b), pin, "direction");
  fd = open(b, O_RDWR);
  if (fd < 0) {
    fprintf(stderr, "Open %s: %s\n", b, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  direction_fd=fd;
  
  // Open gpio value file for fast reading/writing when requested
  sysfs_filename(b, sizeof(b), pin, "value");
  fd = open(b, O_RDWR);
  if (fd < 0) {
    fprintf(stderr, "Open %s: %s\n", b, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }
  value_fd=fd;
   
  // sensor model handling
  if ( model == AM2302 || model == RHT03) {
     sensor_model = DHT22;
  }   
  else if ( model == AUTO_DETECT) {
    sensor_model = DHT22;
    readSensor();
    if ( error_code == ERROR_TIMEOUT ) {
      sensor_model = DHT11;
      // Warning: in case we auto detect a DHT11, you should wait at least 1000 msec
      // before your first read request. Otherwise you will get a time out error.
    }
  }
  
  error_code = ERROR_NONE;
}

/*********************************************************************
 * Function:    dhtCleanup_gpio()
 * 
 * Description: Cleanup of globally used resources
 * 
 * Parameters:  none
 * 
 ********************************************************************/
void dhtCleanup_gpio(void)
{
  int fd;
  char b[8];

  // close gpio value file
  close(value_fd);

  // close gpio direction file
  close(direction_fd);
  
  // free GPIO pin connected to sensors data pin to be used with GPIO sysfs  
  fd = open(UNEXPORT_FILE, O_WRONLY);
  if (fd < 0) {
    perror(UNEXPORT_FILE);
    error_code = ERROR_OTHER;
    return;
  } 
  snprintf(b, sizeof(b), "%d", data_pin);
  if (pwrite(fd, b, strlen(b), 0) < 0) {
    fprintf(stderr, "Unable to unexport pin=%d: %s\n",
            data_pin, strerror(errno));
    error_code = ERROR_OTHER;
    return;
  }  
  close(fd);
  error_code = ERROR_NONE;
}


/*********************************************************************
 * Function:    readSensor_gpio()
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
void readSensor_gpio()
{
  long startTime = micros();
  int8_t   i; 
  uint32_t k;
  uint8_t  age;
  uint16_t rawHumidity=0;
  uint16_t rawTemperature=0;
  uint16_t data=0;
#if DEBUG
  long t1, t2, t3, t4; // debug info
#endif

  last_read_time = 0;

#if 0
  // Make sure we don't poll the sensor too often
  // - Max sample rate DHT11 is 1 Hz   (duty cicle 1000 ms)
  // - Max sample rate DHT22 is 0.5 Hz (duty cicle 2000 ms)
  unsigned long startTime = micros();
  if ( (unsigned long)(startTime - last_read_time) < (model == DHT11 ? 999L : 1999L) ) {
    return;
  }
  last_read_time = startTime;
#endif

  temperature = 0;
  humidity = 0;

  // Check clock resolution
  check_clkres();
  
  // Request sample
  pinMode(OUTPUT);  
  digitalWrite(HIGH); // Init
  usleep(INIT_DELAY);
  
  digitalWrite(LOW); // Send start signal
#if DEBUG
  t1 = micros(); 
#endif
  if ( sensor_model == DHT11 ) {
    usleep(DHT11_START_DELAY);
  }
  else {
    // This will fail for a DHT11 - that's how we can detect such a device
    usleep(DHT22_START_DELAY);
  }
  
  digitalWrite(HIGH); // Switch bus to receive data
#if DEBUG
  t2 = micros(); 
#endif
  pinMode(INPUT);
#if DEBUG
  t3 = micros(); 
#endif

  // We're going to read 83 edges:
  // - First a FALLING, RISING, and FALLING edge for the start bit
  // - Then 40 bits: RISING and then a FALLING edge per bit
  // To keep our code simple, we accept any HIGH or LOW reading if it's max 85 usecs long
  
  for ( i = -3 ; i < MAX_RESPONSE_EDGES; i++ ) {
    startTime = micros();

    // wait for edge change and measure pulse length
    k=0;
    do {
      k++;
      age = (uint8_t)(micros() - startTime);
      if ( age > MAX_BIT_LENGTH ) {
        // pulse length for single bit has timed out
#if DEBUG
        t4 = micros(); 
        printf("i=%d, k=%lu, age=%u, data_pin=%u, data=0x%08X\n", 
                i, (long unsigned int)k, age, digitalRead(), data);
        printf("dt2=%ld, dt3=%ld, dt4=%ld\n", t2-t1, t3-t2, t4-t3);
#endif
        error_code = ERROR_TIMEOUT;
        return;
      }
      // sleep 10us
      //usleep(10);
    }
    while ( digitalRead() == (i & 1) ? HIGH : LOW );
    
    if ( i >= 0 && (i & 1) ) {
      // Now we are being fed our 40 bits
      data <<= 1;

      // A zero lasts max 30 usecs, a one at least 68 usecs.
      if ( age > MAX_PULSE_LENGTH_ZERO ) {
        data |= 1; // we got a one
      }
    }

    switch ( i ) {
      case 31:
        rawHumidity = data;
        data = 0;
        break;
      case 63:
        rawTemperature = data;
        data = 0;
        break;
    }
  }
  
  // Verify checksum
  if ( (uint8_t)(((uint8_t)rawHumidity) + (rawHumidity >> 8) + ((uint8_t)rawTemperature) + (rawTemperature >> 8)) != data ) {
#if DEBUG
    printf("data_pin=%d, data=0x%04X%04X%02X\n", 
            digitalRead(), rawHumidity, rawTemperature, data);
#endif
    error_code = ERROR_CHECKSUM;
    return;
  }

  // Convert raw readings and store in global variables
  if ( sensor_model == DHT11 ) {
    humidity = rawHumidity >> 8;
    temperature = rawTemperature >> 8;
  }
  else {
    humidity = rawHumidity * 0.1;

    if ( rawTemperature & 0x8000 ) {
      rawTemperature = -(int16_t)(rawTemperature & 0x7FFF);
    }
    temperature = ((int16_t)rawTemperature) * 0.1;
  }

  error_code = ERROR_NONE;
}
