#! /bin/bash

DIR=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
DATE=$(date "+%Y%m%d%H%M%S")

cd $DIR
VER1=$(/usr/bin/git branch |grep [*]|awk '{print $2}' && awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$')
VER=$(echo $VER1|sed 's/ //g')

ETH=$(cat /sys/class/net/eth0/address)
WLAN=$(cat /sys/class/net/wlan0/address)
RPI=`gpio -v |grep Type: |awk '{print $3}'|sed 's/,//g'`

if [[ -n $ETH ]]; then
    NID=$(echo $ETH| md5sum |cut -c 1-32)
elif [[ -n $WLAN ]]; then
    NID=$(echo $WLAN| md5sum |cut -c 1-32)
fi

#echo $VER
#echo $NID
#echo $RPI
source /etc/os-release
#echo $PRETTY_NAME

curl --connect-timeout 5 -G "http://stats.nettemp.pl/get.php" -d "ver=$VER&nid=$NID&rpi=$RPI&os=$ID&time=$DATE"
