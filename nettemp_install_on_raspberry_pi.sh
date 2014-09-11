#/bin/bash 

# nettemp Raspberry PI installer
# nettemp.pl
# 
# 2013.08.09

R='\033[0m'
RED='\033[00;31m'
REDB='\033[01;41;35m'
GREEN='\033[00;32m'
YELLOW='\033[00;33m'


if [[ $UID -ne 0 ]]; then
    echo -e "${GREEN} $0 must be run as root ${R}"
    exit 1
fi 
apt-get update
echo -e "${GREEN}Do You want update system? (y or n)${R}"
read y
if [ "$y" = "y" ]; then
 
 apt-get -y upgrade
fi

echo -e "${GREEN}Install packages${R}"
 apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu git-core mc sysstat command-not-found sharutils bc htop snmp

echo -e "${GREEN}Enable module: fastcgi-php${R}"
 lighty-enable-mod fastcgi-php

echo -e "${GREEN}Changing lighthttpd conf${R}"
 sed -i -e 's/#       "mod_rewrite",/       "mod_rewrite",/g'  /etc/lighttpd/lighttpd.conf
 sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g'  /etc/lighttpd/lighttpd.conf	

sed -i '/url.access-deny/d' /etc/lighttpd/lighttpd.conf
sed -i '$a url.access-deny             = ( "~", ".inc", ".dbf", ".db", ".txt", ".rrd" )' /etc/lighttpd/lighttpd.conf

if cat /etc/lighttpd/lighttpd.conf |grep url.rewrite-once 1> /dev/null
    then
    echo -e "${GREEN}Url rewrite exist${R}"
    else
    echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf 
fi

echo -e "${GREEN}Add htpassword function${R}"

if cat /etc/lighttpd/lighttpd.conf |grep Password  1> /dev/null ; then
    echo "Password already set"
else
    sed -i '$aauth.debug = 2' /etc/lighttpd/lighttpd.conf
    sed -i '$aauth.backend = "plain"' /etc/lighttpd/lighttpd.conf
    sed -i '$aauth.backend.plain.userfile = "/etc/lighttpd/.lighttpdpassword"' /etc/lighttpd/lighttpd.conf
    sed -i '$aauth.require = ( "/" =>' /etc/lighttpd/lighttpd.conf
    sed -i '$a(' /etc/lighttpd/lighttpd.conf
    sed -i '$a"method" => "basic",' /etc/lighttpd/lighttpd.conf
    sed -i '$a"realm" => "Password protected area",' /etc/lighttpd/lighttpd.conf
    sed -i '$a"require" => "user=admin"' /etc/lighttpd/lighttpd.conf
    sed -i '$a)' /etc/lighttpd/lighttpd.conf
    sed -i '$a)' /etc/lighttpd/lighttpd.conf
    sed -i '$a www-data ALL=(ALL) NOPASSWD: /usr/sbin/lighttpd-enable-mod *, /usr/sbin/lighttpd-disable-mod *' /etc/sudoers    
    touch /etc/lighttpd/.lighttpdpassword
    chown www-data:www-data /etc/lighttpd/.lighttpdpassword
    echo "admin:admin" > /etc/lighttpd/.lighttpdpassword
    /etc/init.d/lighttpd restart
    lighttpd-enable-mod auth
    echo "${REDB}WWW ACCESS: User is admin, pass is admin. You must change password. Press any key to continue.${R}"
    read lolol
fi
# php ini
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 200M/g' /etc/php5/cgi/php.ini


echo -e "${GREEN}Which version you want to download?${R}"
echo -e "${GREEN}Regular [r] or Beta [b]${R}"
read x 
cd /var/www

if [ -d "nettemp" ]; then 
mv nettemp nettempOLD
echo -e "${GREEN}Your OLD nettemp is moved to nettempOLD, press any key to continue${R}"
read devnull
fi

if [ "$x" = "r" ]; then
#git clone https://github.com/sosprz/nettemp
git clone --recursive git://github.com/sosprz/nettemp
fi

if [ "$x" = "b" ]; then 
#git clone -b beta https://github.com/sosprz/nettemp
git clone -b beta --recursive git://github.com/sosprz/nettemp
fi

#global dir
echo  "<?php \$global_dir='/var/www/nettemp/';?>"  > /var/www/nettemp/conf.php

echo -e "${GREEN}Create database${R}"
/var/www/nettemp/modules/reset/reset


echo -e "${GREEN}Add cron line${R}"
 echo "*/1 * * * * /var/www/nettemp/modules/sensors/temp_dev_read && /var/www/nettemp/modules/view/view_gen && /var/www/nettemp/modules/highcharts/highcharts" > /var/spool/cron/crontabs/root
 echo "*/1 * * * * /var/www/nettemp/modules/gpio/gpio2 check" >> /var/spool/cron/crontabs/root
 echo "*/5 * * * * /var/www/nettemp/modules/sms/sms_send" >> /var/spool/cron/crontabs/root
 echo "*/5 * * * * /var/www/nettemp/modules/mail/mail_send" >> /var/spool/cron/crontabs/root
 sed -i '$a @reboot     echo "$(date +\\%y\\%m\\%d-\\%H\\%M) RPI rebooted" >> /var/www/nettemp/tmp/log.txt' /var/spool/cron/crontabs/root
 sed -i '$a @reboot  /var/www/nettemp/modules/tools/restart' /var/spool/cron/crontabs/root
 sed -i '$a*/1 * * * * /var/www/nettemp/modules/tools/system_stats' /var/spool/cron/crontabs/root
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

echo -e "${GREEN}Add perms${R}"
chmod +s /opt/vc/bin/vcgencmd
chmod +s /var/www/nettemp/modules/sensors/Adafruit_DHT

echo -e "${GREEN} UPS status function${R}"
/var/www/nettemp/modules/ups/install

echo -e "${GREEN} kWh function${R}"
/var/www/nettemp/modules/kwh/install

echo -e "${GREEN} OpenVPN serwer${R}"
/var/www/nettemp/modules/vpn/install

echo -e "${GREEN} Firewall${R}"
/var/www/nettemp/modules/fw/install
echo -e "${GREEN} I2C install${R}"
/var/www/nettemp/modules/i2c/install

echo -e "${GREEN}Add permisions${R}"
 chown -R root.www-data /var/www/nettemp
 chmod -R 775 /var/www/nettemp
 gpasswd -a www-data dialout
 sed -i '$a www-data ALL=(ALL) NOPASSWD: /bin/chmod *, /bin/chgrp *, /sbin/reboot' /etc/sudoers

echo -e "${REDB}Restart RPI and make sure everything is ok${R}"

