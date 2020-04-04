import board
import busio
import adafruit_vl53l0x
import os
import sys
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..','..','..')))
sys.path.append(dir+'/app')
from local_nettemp import insert

try:
  i2c = busio.I2C(board.SCL, board.SDA)
  sensor = adafruit_vl53l0x.VL53L0X(i2c)
  #print('Range: {}mm'.format(sensor.range))
  rom = "i2c_29_dist"
  value = '{0:0.2f}'.format(sensor.range/10) #cm
  name = 'vl53l0x_dist'
  type = 'dist'
  data=insert(rom, type, value, name)
  data.request()
except:
  print ("No val530x")



