import time
import board
import busio
from adafruit_htu21d import HTU21D
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..','..','..')))
sys.path.append(dir+'/app')
from local_nettemp import insert

# Create library object using our Bus I2C port
i2c = busio.I2C(board.SCL, board.SDA)

try:
  sensor = HTU21D(i2c)
  rom = "i2c_40_temp"
  value = '{0:0.2f}'.format(sensor.temperature)
  name = 'htu21d_temp'
  type = 'temp'
  data=insert(rom, type, value, name)
  data.request()

  rom = "i2c_40_humid"
  value = '{0:0.2f}'.format(sensor.relative_humidity)
  name = 'htu21d_humid'
  type = 'humid'
  data=insert(rom, type, value, name)
  data.request()
except:
  print ("No HTU21d")