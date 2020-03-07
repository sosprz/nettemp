import Adafruit_DHT
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
dir2=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..','..')))
sys.path.append(dir)
from local_nettemp import insert

sensor = Adafruit_DHT.DHT22

name = os.listdir(dir2+'/data/sensors/dht22/')
for i in name:
  pin = os.listdir(dir2+'/data/sensors/dht22/'+i)[0]
  humidity, temperature = Adafruit_DHT.read_retry(sensor, pin)

  if humidity is not None and temperature is not None:
    value = '{0:0.1f}'.format(temperature)
    rom = 'dht22-temp-gpio-'+i
    type = 'temp'
    name = rom
    data=insert(rom, type, value, name)
    data.request()
   
    value = '{0:0.1f}'.format(humidity)
    rom = 'dht22-humid-gpio-'+i
    type = 'humid'
    name = rom
    data=insert(rom, type, value, name)
    data.request()
   
    