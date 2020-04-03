import requests
import io
import sqlite3

class insert:
  def __init__(self, rom, type, value, name):
    self.rom = rom
    self.type = type
    self.value = value
    self.name = name

  def request(self):
    url = "http://localhost:8080/local"
    data = [{"rom":self.rom,"type":self.type, "device":"","value":self.value,"name":self.name}]
    r = requests.post(url,json=data)
    r.close
    print("[ nettemp ][ local netemp ] Sensor %s value: %s" % (self.rom, self.value))

