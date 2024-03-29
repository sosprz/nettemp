# nettemp

Nettemp is a data colector and monitoring app, with:
* Status dashboard, with grouping, sorting function, gauge, mini charts, map.
* Charts, highcharts, chartsjs, NVD3
* Map, Visual arrangement of sensors on the plan
* Alarm dashbaord, "no data" notification
* Notofication function over mail
* Receiving data in JSON format 
* Nettemp nodes sending data to other nettemps
* Nettemp_client as separated app
* monitoring by ping and http/url ping. (nettemp_client)

# screenshots

![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-status.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-status2.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-status3.png)
![nettemp charts](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-charts.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-map.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-alarms.png)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-settings.png)

# info

- nettemp7 in docker
- docker compose file
- in docker compose file is possible to select MariaDB or Sqlite3 database


# Installation with docker (sqlite3 database)
```
# install docker

# step 1
sudo timedatectl set-timezone Europe/Warsaw && \
sudo apt update && \
sudo apt -y upgrade  && \
sudo apt install -y curl && \
curl -fsSL https://get.docker.com -o get-docker.sh && \
sudo sh get-docker.sh && \
sudo usermod -aG docker ${USER} && \
sudo su - ${USER} 

# step 2 (optional)
mkdir ~/nettemp && cd ~/nettemp 

# step 3
docker run --name nettemp -p 443:443 -v nettemp-data:/var/www/nettemp/data --restart unless-stopped -d przemeksdocker/nettemp



```
# Installation with docker compose (MariaDB, 2 containers)
```
# step 1
sudo timedatectl set-timezone Europe/Warsaw && \
sudo apt update && \
sudo apt -y upgrade  && \
sudo apt install -y curl && \
curl -fsSL https://get.docker.com -o get-docker.sh && \
sudo sh get-docker.sh && \
sudo usermod -aG docker ${USER} && \
sudo su - ${USER} 


# step 2
mkdir ~/nettemp && cd ~/nettemp && \
wget https://raw.githubusercontent.com/sosprz/nettemp/nettemp7/docker-compose.yml && \
docker compose up -d 

```




# how to update?

## docker
```
docker pull przemeksdocker/nettemp
```

## Docker compose

```
cd ~/nettemp
docker compose pull
docker compose down
docker compose up
```

# Docker composer WEB configuration
You can set in docker compose what configuration is needed ex. port 80, 443, 8000 for Traefik or Nginx Proxy Manager.

```
    ports:
      - "443:443"   # selfsigned ssl cert
      #- "8000"       # no ssl eg. for traefik
      #- "8000:8000"  # no ssl
      - "80:80"     # redirect to 443
    
    environment:
      # HTTPS: False  # if not using https

```

# WEB access 
https://YOUR-IP-ADDRESS

user: admin

password: admin

# How to send data to nettemp

## get token from 
```
https://nettemp_ip/data/server
```

## Send data from python:
```
requests.packages.urllib3.disable_warnings() 
import json

token = 'y8k76HDjmuQqJDKIaFwf8rk55sa8jIh1zCzZJ6sJZ8c'

def send(token,data):
  url = "https://nettemp_ip/"
  r = requests.post(url,headers={'Content-Type':'application/json', 'Authorization': 'Bearer {}'.format(token)},json=data, verify=False)
  print (r.content)

data = [{"rom":"ds18b20-sensor-1","type":"temp","name":"DS18B20","value":"-10","group":"group1"}]
send(token, data)
```

## Send data from curl:
```
curl -k -H "Content-Type: application/json" \
-H 'Authorization: Bearer y8k76HDjmuQqJDKIaFwf8rk55sa8jIh1zCzZJ6sJZ8c' \
--request POST \
--data '[{"rom":"ds18b20-host1","type":"temp","name":"DS18b20","value":"12","group":"group1"}]' \
https://nettemp_ip/
```

## Send data from nettemp_client

https://github.com/sosprz/nettemp_client


### Supported sensors by nettemp client

![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-raspi.jpg)
![nettemp status](https://github.com/sosprz/nettemp/raw/nettemp7/img/nettemp-sensors1.jpg)

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

#### Other 
* lm-sensors
* ping

#### Data send by json
* ALL
* example: ESPEasy over POSTtoHTTP


## Old things, versions

* nettemp 7 full mysql database.
* nettemp 6 is a version with MySQL as the main base and sqlite3
* nettemp5 is a python, flask, Mysql as main base, sqlite for sensor base, not all functions from nettemp beta
* beta nettemp4 is a php, sqlite, python, sqlite for all databases. The richest version in features.
* nettemp 3 is a php, sqlite, python, sqlite for all databases.

# Support

https://discord.com/invite/S4egxNvQHM