#/bin/bash -x

# nettemp Raspberry PI installer
# nettemp.pl
# 
# 2013.07.21

R='\033[0m'
RED='\033[00;31m'
REDB='\033[01;41;35m'
GREEN='\033[00;32m'
YELLOW='\033[00;33m'


if [[ $UID -ne 0 ]]; then
    echo -e "${GREEN} $0 must be run as root ${R}"
    exit 1
fi 

echo -e "${GREEN}Do You want update system? (y or n)${R}"
read y
if [ "$y" = "y" ]; then
 apt-get update
 apt-get -y upgrade
fi

echo -e "${GREEN}Install packages${R}"
 apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu git-core

echo -e "${GREEN}Enable module: fastcgi-php${R}"
 lighty-enable-mod fastcgi-php

echo -e "${GREEN}Changing lighthttpd conf${R}"
 sed -i -e 's/#       "mod_rewrite",/       "mod_rewrite",/g'  /etc/lighttpd/lighttpd.conf
 sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g'  /etc/lighttpd/lighttpd.conf	

 if cat /etc/lighttpd/lighttpd.conf |grep url.rewrite-once 1> /dev/null
 then
 echo -e "${GREEN}Url rewrite exist${R}"
 else
 echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf 1> /dev/null
 fi


echo -e "${GREEN}Which version you want to download?${R}"
echo -e "$GREEN Regular [r] or Beta [b]${R}"
read x 
cd /var/www
if [ "$x" = "r" ]; then
git clone https://github.com/sosprz/nettemp
fi

if [ "$x" = "b" ]; then 
git clone -b beta https://github.com/sosprz/nettemp
fi

echo -e "${GREEN} Add permisions${R}"
 chown -R root.www-data /var/www/nettemp
 chmod -R 775 /var/www/nettemp
 gpasswd -a www-data dialout
 #chmod +s /var/www/nettemp/modules/relays/gpio


echo -e "${GREEN}Add cron line${R}"
 echo "*/1 * * * * /var/www/nettemp/modules/sensors/temp_dev_read && /var/www/nettemp/modules/view/view_gen" > /var/spool/cron/crontabs/root
 echo "*/1 * * * * /var/www/nettemp/modules/gpio/gpio check" >> /var/spool/cron/crontabs/root
 echo "*/5 * * * * /var/www/nettemp/modules/sms/sms_send" >> /var/spool/cron/crontabs/root
 echo "*/5 * * * * /var/www/nettemp/modules/mail/mail_send" >> /var/spool/cron/crontabs/root
 chmod 600 /var/spool/cron/crontabs/root


 update-rc.d ntp enable
 service ntp start

 update-rc.d lighttpd enable
 service lighttpd stop
 service lighttpd start

 update-rc.d cron defaults
 service cron start

echo -e "${GREEN}Add wiringPI for gpio${R}"
 if which gpio 1> /dev/null
 then echo -e "${GREEN}WiringPI exist${R}"
 else
 git clone git://git.drogon.net/wiringPi
 cd wiringPi
 ./build
 fi

echo -e "${GREEN}Add watchdog${R}"
 
 apt-get install watchdog
 update-rc.d watchdog defaults
 
 if cat /etc/modules |grep bcm2708_wdog 1> /dev/null
 then echo "bcm2708_wdog exist in file"
 else echo "bcm2708_wdog" | sudo tee -a /etc/modules
 fi
 sed -i -e '10s/#max-load-1/max-load-1/' /etc/watchdog.conf 
 sed -i -e '23s/#watchdog-device/watchdog-device/' /etc/watchdog.conf 
 /etc/init.d/watchdog start

echo -e "${GREEN}Add modules 1-wire${R}"
 if cat /etc/modules |grep w1_ 1> /dev/null
 then echo -e "${GREEN}1-wire modules exist in file${R}"
 else  echo "w1_gpio" | sudo tee -a /etc/modules
       echo "w1_therm" | sudo tee -a /etc/modules
 fi

echo -e "${REDB}Restart RPI and make sure everything is ok${R}"




