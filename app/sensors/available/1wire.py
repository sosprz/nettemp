import requests
from w1thermsensor import W1ThermSensor
import sys, os
dir=(os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..', '..')))
sys.path.append(dir)
from local_nettemp import insert
import random

for sensor in W1ThermSensor.get_available_sensors():
    r = random.randint(10000,99999)
    value = ("%.2f" % (sensor.get_temperature()))
    rom = '28-'+sensor.id
    type = 'temp'
    name = 'DS18b20-'+str(r)
    data=insert(rom, type, value, name)
    data.request()
