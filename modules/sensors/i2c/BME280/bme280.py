#!/usr/bin/python

from Adafruit_BME280 import *

import sys

try:
    if sys.argv[2]:
        addr = int('0x'+sys.argv[2], 16)
except:
    addr = 0x76

sensor = BME280(mode=BME280_OSAMPLE_16, address=addr)

degrees = sensor.read_temperature()
pascals = sensor.read_pressure()
hectopascals = pascals / 100
humidity = sensor.read_humidity()

#print 'Timestamp = {0:0.3f}'.format(sensor.t_fine)
#print 'Temp      = {0:0.3f} deg C'.format(degrees)
#print 'Pressure  = {0:0.2f} hPa'.format(hectopascals)
#print 'Humidity  = {0:0.2f} %'.format(humidity)
print '{0:0.3f}'.format(degrees)   #Temp C
print '{0:0.2f}'.format(hectopascals)   #Pressure
print '{0:0.2f}'.format(humidity)   #Humid
