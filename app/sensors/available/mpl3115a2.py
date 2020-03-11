# Distributed with a free-will license.
# Use it any way you want, profit or free, provided it fits in the licenses of its associated works.
# MPL3115A2
# This code is designed to work with the MPL3115A2_I2CS I2C Mini Module available from ControlEverything.com.
# https://www.controleverything.com/products

import smbus
import time
import os, sys
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
sys.path.append(dir)
from local_nettemp import insert


# Get I2C bus
bus = smbus.SMBus(1)

# MPL3115A2 address, 0x60(96)
# Select control register, 0x26(38)
#		0xB9(185)	Active mode, OSR = 128, Altimeter mode
bus.write_byte_data(0x60, 0x26, 0xB9)
# MPL3115A2 address, 0x60(96)
# Select data configuration register, 0x13(19)
#		0x07(07)	Data ready event enabled for altitude, pressure, temperature
bus.write_byte_data(0x60, 0x13, 0x07)
# MPL3115A2 address, 0x60(96)
# Select control register, 0x26(38)
#		0xB9(185)	Active mode, OSR = 128, Altimeter mode
bus.write_byte_data(0x60, 0x26, 0xB9)

time.sleep(1)

# MPL3115A2 address, 0x60(96)
# Read data back from 0x00(00), 6 bytes
# status, tHeight MSB1, tHeight MSB, tHeight LSB, temp MSB, temp LSB
data = bus.read_i2c_block_data(0x60, 0x00, 6)

# Convert the data to 20-bits
tHeight = ((data[1] * 65536) + (data[2] * 256) + (data[3] & 0xF0)) / 16
temp = ((data[4] * 256) + (data[5] & 0xF0)) / 16
altitude = tHeight / 16.0
cTemp = temp / 16.0
fTemp = cTemp * 1.8 + 32

# MPL3115A2 address, 0x60(96)
# Select control register, 0x26(38)
#		0x39(57)	Active mode, OSR = 128, Barometer mode
bus.write_byte_data(0x60, 0x26, 0x39)

time.sleep(1)

# MPL3115A2 address, 0x60(96)
# Read data back from 0x00(00), 4 bytes
# status, pres MSB1, pres MSB, pres LSB
data = bus.read_i2c_block_data(0x60, 0x00, 4)

# Convert the data to 20-bits
pres = ((data[1] * 65536) + (data[2] * 256) + (data[3] & 0xF0)) / 16
pressure = (pres / 4.0) / 100.0

# Output data to screen
#print ("Pressure : %.2f kPa" %pressure)
#print ("Altitude : %.2f m" %altitude)
#print ("Temperature in Celsius  : %.2f C" %cTemp)
#print ("Temperature in Fahrenheit  : %.2f F" %fTemp)

press = '{0:0.2f}'.format(pressure)
alti = '{0:0.2f}'.format(altitude)
temp = '{0:0.2f}'.format(cTemp)

try:
  rom = "i2c_60_temp"
  value = temp
  name = 'mpl3115a2-temp'
  type = 'temp'
  data=insert(rom, type, value, name)
  data.request()

  rom = "i2c_60_alti"
  value = alti
  name = 'mpl3115a2-alti'
  type = 'alti'
  data=insert(rom, type, value, name)
  data.request()

  rom = "i2c_60_press"
  value = press
  name = 'mpl3115a2-press'
  type = 'press'
  data=insert(rom, type, value, name)
  data.request()
except: 
  print ("No MPL3115A2")


