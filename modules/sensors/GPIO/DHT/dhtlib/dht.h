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

  Changelog:
   18-10-2013: Initial version (porting from arduino-DHT)
   17-03-2014: Added function prototypes for sensor power switching
   
 ******************************************************************/

#ifndef dht_h
#define dht_h

typedef enum {
   AUTO_DETECT,
   DHT11,
   DHT22,
   AM2302,  // Packaged DHT22
   RHT03    // Equivalent to DHT22
}
DHT_MODEL_t;

typedef enum {
   ERROR_NONE = 0,
   ERROR_TIMEOUT,
   ERROR_CHECKSUM,
   ERROR_OTHER
}
DHT_ERROR_t;

typedef enum {
   INPUT,
   OUTPUT
}
DHT_IOMODE_t;

typedef enum {
   LOW,
   HIGH
}
PIN_STATE_t;


void dhtSetup(uint8_t pin, DHT_MODEL_t model);
void dhtCleanup();
void resetTimer();
void dhtPoweron(uint8_t pin);
void dhtPoweroff(uint8_t pin);
void dhtReset(uint8_t pin);

void readSensor();

float getTemperature();
float getHumidity();

DHT_ERROR_t getStatus();
const char* getStatusString();

#endif /*dht_h*/
