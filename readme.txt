# nettemp.pl

# nettemp.pl

mkdir -p /var/www/ && cd /var/www/ && git clone https://github.com/sosprz/nettemp && cd nettemp && ./setup


# WEB access 
## User: admin paassword: admin

# How to send data to nettemp
## set username and password from web gui, allow to JWT

Request:
curl -k -s -X POST -H 'Accept: application/json' -H 'Content-Type: application/json' --data '{"username":"test","password":"secret_password"}' https://172.18.10.10/register

Reply:
{"access_token":"eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg"}

Token: 
eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg

## send data from python script:
import requests
requests.packages.urllib3.disable_warnings() 
import json

token = 'eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg'

def send(token,data):
  url = "https://172.18.10.10/sensor"
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

data = {"rom":"ds18b20-sensor-1","type":"temp","name":"DS18B20","value":"-10"}
send(token, data)


## send data from curl:
curl -s -X POST -H 'Accept: application/json' -H 'Authorization: Bearer eyJ0eXAi1NiJ9.eyJpYXlc3MifQ.SwLOv1SOeg' --data '{"rom":"ds18b20-sensor-1","type":"temp","name":"DS18B20","value":"-10"}' https://127.0.0.1:8080/sensor


# I2C sensors
HIH6130 0x27
TMP102 0x48
BMP280 0x76
HTU21/SHT21 0x40
DS2482 - DS18b20 1wire  0x18, 0x19 0x1a, 0x1b
MPL3115A2 0x60
TSL2561 0x39

# GPIO sensors
DHT22
DS18b20 1wire

# USB sensors
DS9490R 1wire


