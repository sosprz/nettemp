import time
import board
import adafruit_dht
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..','..','..')))
sys.path.append(dir+'/app')
from local_nettemp import insert

#sensor = Adafruit_DHT.DHT22

name = os.listdir(dir+'/data/sensors/dht22/')
for i in name:
  pin = os.listdir(dir+'/data/sensors/dht22/'+i)[0]
  #humidity, temperature = Adafruit_DHT.read_retry(sensor, pin)

  pin = 'D'+pin
  dht_device = adafruit_dht.DHT22(getattr(board, pin))

  temperature = dht_device.temperature
  humidity = dht_device.humidity

  if humidity is not None and temperature is not None:
    value = '{0:0.1f}'.format(temperature)
    rom = 'dht22_temp_gpio_'+i
    type = 'temp'
    name = rom
    data=insert(rom, type, value, name)
    data.request()
   
    value = '{0:0.1f}'.format(humidity)
    rom = 'dht22_humid_gpio_'+i
    type = 'humid'
    name = rom
    data=insert(rom, type, value, name)
    data.request()
   
    