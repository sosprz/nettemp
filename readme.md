# nettemp.pl

![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp5/img/nettemp-status.png)
![nettemp charts](https://github.com/sosprz/nettemp/raw/nettemp5/img/nettemp-charts.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp5/img/nettemp-map.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp5/img/nettemp-alarms.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp5/img/nettemp-settings.png)

# info

This is a version with MySQL as the main base and sqlite3 for sensors data. This is a must because SQLite can't handle many writers at once. Setup scripts install MySQL server, create a database, all data, and all configurations.

# Install

```
sudo apt install sudo git
```

```
sudo mkdir -p /var/www/ && cd /var/www/ && git clone https://github.com/sosprz/nettemp && cd nettemp && ./setup.sh
```

# Update

```
sudo su -
/var/www/nettemp/app/scripts/update.sh
```


# WEB access 
https://YOUR-IP-ADDRESS

user: admin

password: admin

# How to send data to nettemp

## Set username and password from web gui, allow to JWT

Request:

```
curl -k -s -X POST -H 'Accept: application/json' -H 'Content-Type: application/json' --data '{"username":"test","password":"secret_password"}' https://172.18.10.10/register
```

Reply:

```
{"access_token":"eyJ0eXAiO1NiJ9.eyJpYXQiOj2Nlc3MifQ.Sxjv3LXe1F916TaRFF5ODpsg"}
```


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
```
curl -k -H "Content-Type: application/json" -H 'Authorization: Bearer eyJXJ9.eIn0.fc'  --request POST   --data '[{"rom":"ds18b20-host1","type":"temp","name":"DS18b20","value":"12"}]' https://172.18.10.12/sensor
```

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



## other examples

nvidia temp python linux

```
import json, requests, os
requests.packages.urllib3.disable_warnings()

gpu = "nvidia-smi -q |grep 'Current Temp'|awk -F: '{print $2}'| tr -cd '[:digit:]'"
gpu_temp = os.popen(gpu).read()
token = 'eyJ.eyJpYssdfsfdsdfsfsdfsdf._sdfsdfsdf0s9d0f9s0d9f0sd9f'
data = [{"rom":"1660-3900","type":"temp","name":"GTX1660","value":"{}".format(gpu_temp)}]
url = "https://172.18.10.10/sensor"

def send(token,data,url):
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

send(token, data, url)
```
lmsensors python linux 

```
import json, requests, os
requests.packages.urllib3.disable_warnings()

token = 'eyasdasdasdasdasdlx9PY'
url = "https://172.18.10.10/sensor"

hostname = os.popen("hostname").read().strip('\n')
data = []


json_data = os.popen("sensors -j").read().strip('\n')
loaded_json = json.loads(json_data)

name = 'CPU'
temp = (loaded_json['dell_smm-virtual-0']['CPU']['temp1_input'])
rom = name+'-'+hostname
row = {"rom":f"{rom}","type":"temp","name":f"{name}","value":f"{temp}", "group":f"{hostname}"}
data.append(row)

name = 'Ambient'
temp = (loaded_json['dell_smm-virtual-0']['Ambient']['temp2_input'])
rom = name+'-'+hostname
row = {"rom":f"{rom}","type":"temp","name":f"{name}","value":f"{temp}", "group":f"{hostname}"}
data.append(row)

print(data)

def send(token,data,url):
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': f'Bearer {token}'},json=data, verify=False)
  print (r.content)

send(token, data, url)
```

## change log

2021-05-10
change name to id, multiple same name allowed
add group info to message

## TO DO
1. remove sqlite
  sensor.py
3. clean sensor.py
  
