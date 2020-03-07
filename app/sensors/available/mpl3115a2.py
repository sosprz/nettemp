# Simple demo of the MPL3115A2 sensor.
# Will read the pressure and temperature and print them out every second.
# Author: Tony DiCola
import time
import board
import busio
import adafruit_mpl3115a2
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
sys.path.append(dir)
from local_nettemp import insert

# Initialize the I2C bus.
i2c = busio.I2C(board.SCL, board.SDA)

try:
  sensor = adafruit_mpl3115a2.MPL3115A2(i2c)
  sensor.sealevel_pressure = 102250

  rom = "i2c_60_temp"
  value = '{0:0.2f}'.format(sensor.temperature)
  name = None
  type = 'temp'
  data=insert(rom, type, value, name)
  data.request()

  rom = "i2c_60_press"
  value = '{0:0.2f}'.format(sensor.pressure)
  name = None
  type = 'press'
  data=insert(rom, type, value, name)
  data.request()

  rom = "i2c_60_alti"
  value = '{0:0.2f}'.format(sensor.altitude)
  name = None
  type = 'alti'
  data=insert(rom, type, value, name)
  data.request()
except:
  print ("No MPL3115a2")
