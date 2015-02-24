# DHTlib
#### C library for reading the family of DHT sensors

### About

DHTlib is a C library that can be used to read the DHT temperature and humidity sensors on Single Board Computers running Linux 
(e.g. FoxG20, AriettaG25, RaspberryPi).  

### Features

- Support for DHT11 and DHT22/AM2302/RHT03 sensors
- Auto detect sensor model
- Two communication modes: GPIO and SPI
- Provided as C library to be included in your own project
- Example code for library usage provided  

### Credits

The implementation of the GPIO communication mode is based on code for Arduino from Mark Ruys, mark@paracas.nl  
http://www.github.com/markruys/arduino-DHT

The implementation of the SPI communication mode is based on the work from Daniel Perron posted on the RaspberryPi Forum.  
http://www.raspberrypi.org/forums/viewtopic.php?p=506650#p506650

### Installation
  
* Get source code from Github:
<pre>
  git clone https://github.com/ondrej1024/foxg20
</pre>

* Build library:
<pre>
  cd dhtlib
  make
</pre>

* Install library:
<pre>
  make install
</pre>

### Usage

You find an example application using the library in example/dhtsensor.c

* Build example program (library needs to be built and installed first):
<pre>
  cd dhtlib/example
  make
</pre>

* Run example program:
<pre>
  ./dhtsensor DHT22 [pin]
</pre>

The pin number is only needed for GPIO mode and defines the kernel id of the used GPIO pin.

### Wiring schemes

The wiring of the DHT sensor to the IO lines changes according to the operating mode used for the communication with the sensor. These are the wiring schemes that need to be used.

#### GPIO method

The GPIO method allows to use any available GPIO pin to be connected to the sensor data line. Multiple sensors can be connected via different GPIO pins. However this method has some drawbacks (see "Known issues" below).  
![GPIO wiring scheme](https://raw.githubusercontent.com/ondrej1024/foxg20/master/dhtlib/dht-gpio.png)  
<br>

#### SPI method

In order to use the SPI method, the MOSI and MISO lines of the SPI interface are used. Therefore only one sensor can be connected in this mode but it is the most reliable.  
![GPIO wiring scheme](https://raw.githubusercontent.com/ondrej1024/foxg20/master/dhtlib/dht-spi.png)  


### Known issues

This library runs in user space and when using GPIO as communication bus with the DHT sensor, the time critical detection of the sensors response pulses (with length of around 50us) is not very reliable. In some occasions the sensor reading will fail (timeout or checksum error). As a solution the reading needs to be repeated until it succeeds.  

When using the GPIO method another issue has to be taken care of. On later kernels, the GPIO sysfs filenames have changed on some platforms (e.g. AriettaG25). To use the correct names uncomment the following line in dht_gpio.c before building:
<pre>
#define AT91_SYSFS
</pre>

The above issues don't apply when using SPI as communication bus. The SPI mode is very robust and should be the preferred solution if only one sensor is needed.
