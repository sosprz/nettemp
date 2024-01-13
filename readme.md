# nettemp.pl

![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-status.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-status2.png)
![nettemp charts](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-charts.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-map.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-alarms.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-settings.png)

# info

- docker composer file
- full MySQL, main DB amd sensors.

# Install

```
# set timezone
sudo timedatectl set-timezone Europe/Warsaw

# update sys
sudo apt update && apt upgrade

# install packages
sudo apt install curl

# install docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# add user to docker group
sudo usermod -aG docker ${USER}
su - ${USER}

# check if user has access to docker
docker ps

# mkdir 
mkdir ~/nettemp && cd ~/nettemp

# download docker compose script
wget https://git.pslocal.pl/adminps/nettemp-dev/raw/branch/main/compose/docker-compose.yml

# docker compose, you should always run docker compose commands in the directory containing the docker compose file.

# docker compose start
docker compose up -d

# docker compose stop
docker compose down

# docker compose pull also update image
docker compose pull
```

# Docker compose WEB configuration
You can set in docker compose what configuration is needed ex. port 80, 443, 8000 for Traefik or Nginx Proxy  Manager.

# WEB access 
https://YOUR-IP-ADDRESS

user: admin

password: admin

# How to send data to nettemp

## Send data from python:
```
import requests
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

## Send data from nettemp_client

https://github.com/sosprz/nettemp_client


### Supported sensors by nettemp client

#### I2C sensors
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

#### GPIO sensors
* DHT11 temperature, humidity 
* DHT22 temperature, humidity 
* DS18b20 1wire temperature 

#### USB sensors
* DS9490R 1wire - DS18b20 temperature

#### Data send by json
* ALL


## Old things, versions

* nettemp 7 full mysql database.
* nettemp 6 is a version with MySQL as the main base and sqlite3
* nettemp5 is a python, flask, Mysql as main base, sqlite for sensor base, not all functions from nettemp beta
* beta nettemp4 is a php, sqlite, python, sqlite for all databases. The richest version in features.
* nettemp 3 is a php, sqlite, python, sqlite for all databases.

