import Adafruit_DHT
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..','..','..')))
sys.path.append(dir+'/app')
from local_nettemp import insert

sensor = Adafruit_DHT.DHT11

name = os.listdir(dir+'/data/sensors/dht11/')
for i in name:
  pin = os.listdir(dir+'/data/sensors/dht11/'+i)[0]
  humidity, temperature = Adafruit_DHT.read_retry(sensor, pin)

  if humidity is not None and temperature is not None:
    value = '{0:0.1f}'.format(temperature)
    rom = 'dht11_temp_gpio_'+i
    type = 'temp'
    name = rom
    data=insert(rom, type, value, name)
    data.request()
   
    value = '{0:0.1f}'.format(humidity)
    rom = 'dht11_humid_gpio_'+i
    type = 'humid'
    name = rom
    data=insert(rom, type, value, name)
    data.request()
   
    