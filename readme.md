# nettemp.pl

This is a version with MySQL as the main base and sqlite3 for sensors data. This is a must because SQLite can't handle many writers at once. Setup scripts install MySQL server, create a database, all data, and all configurations.


# Install

```sudo apt install sudo git```

```sudo mkdir -p /var/www/ && cd /var/www/ && git clone https://github.com/sosprz/nettemp && cd nettemp && ./setup.sh```

# Update

```sudo su -```

```/var/www/nettemp/app/scripts/update.sh```


# WEB access 
https://YOUR-IP-ADDRESS

user: admin

password: admin

# How to send data to nettemp

## Set username and password from web gui, allow to JWT

Request:

```curl -k -s -X POST -H 'Accept: application/json' -H 'Content-Type: application/json' --data '{"username":"test","password":"secret_password"}' https://172.18.10.10/register```

Reply:

{"access_token":"eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg"}

Token: 
eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg


## Send data from python:
```import requests
requests.packages.urllib3.disable_warnings() 
import json

token = 'eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg'

def send(token,data):
  url = "https://172.18.10.10/sensor"
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

data = [{"rom":"ds18b20-sensor-1","type":"temp","name":"DS18B20","value":"-10"}]
send(token, data)
```

## Send data from curl:
```curl -k -H "Content-Type: application/json" -H 'Authorization: Bearer eyJXJ9.eIn0.fc'  --request POST   --data '[{"rom":"ds18b20-host1","type":"temp","name":"DS18b20","value":"12"}]' https://172.18.10.12/sensor```

# Supported sensors

## I2C sensors
* HIH6130 0x27 temperature, humidity
* TMP102 0x48 temperature
* BMP280 0x76 temperature, pressure
* HTU21/SHT21/SI7021/SHT20 0x40 temperature, humidity
* DS2482 - DS18b20 1wire  0x18, 0x19 0x1a, 0x1b temperature
* MPL3115A2 0x60 temperature, pressure, altitude
* TSL2561 0x39 light sensor
* BMP180 0x77 temperature, pressure
* VL53l0X 0x29 distance
* ADXL345/ADXL343 0x53 3 axis accelerometer, motion detection 

## GPIO sensors
* DHT11 temperature, humidity
* DHT22 temperature, humidity
* DS18b20 1wire temperature

## USB sensors
* DS9490R 1wire - DS18b20 temperature

## Data send by json
* ALL


## Old things, versions

* nettemp5 is a python, flask, Mysql as main base, sqlite for sensor base, not all functions from nettemp beta
* beta nettemp4 is a php, sqlite, python, sqlite for all databases. The richest version in features.
* nettemp 3 is a php, sqlite, python, sqlite for all databases.

