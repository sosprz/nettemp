#! /bin/bash

DIR=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

## DATE
DATE=$(date "+%Y%m%d%H%M%S")

## RPI VER
cd $DIR
VER1=$(/usr/bin/git branch |grep [*]|awk '{print $2}' && awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$')
VER=$(echo $VER1|sed 's/ /%20/g')

## ID
ETH=$(cat /sys/class/net/eth0/address)
WLAN=$(cat /sys/class/net/wlan0/address)

#HW
if [[ -e /usr/local/bin/gpio ]]; then
    RPI=$(gpio -v |grep Type: | awk -F"," '{print $1" "$2" "$3}' |sed 's/Type://g' |sed 's/ /%20/g')
else
    RPI=$(dmidecode -t baseboard |grep Manufacturer |awk -F: '{print $2}'|sed 's/ /%20/g')
fi

if [[ -n $ETH ]]; then
    NID=$(echo $ETH| md5sum |cut -c 1-32)
elif [[ -n $WLAN ]]; then
    NID=$(echo $WLAN| md5sum |cut -c 1-32)
fi

## OS
source /etc/os-release
OS=$(echo $PRETTY_NAME|sed 's/ /%20/g')

## CPUN
#CPUN=$(cat /proc/cpuinfo |grep -c processor)

##UPTIME
#UPTIME=$(uptime -s | awk '{print $1}')

## MAIN
curl --connect-timeout 20 -G "http://stats.nettemp.pl/get.php" -d "ver=$VER&nid=$NID&rpi=$RPI&os=$OS&time=$DATE"
