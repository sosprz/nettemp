#/bin/bash 
# nettemp rpi installer
# nettemp.pl
# 
# 2013.07.12

if [[ $UID -ne 0 ]]; then
    echo "$0 must be run as root"
    exit 1
fi 

echo "update distro"
 apt-get update
 apt-get -y upgrade

echo "install git-core"
 apt-get -y install git-core

echo "install packages"
 apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu


echo "enable module: fastcgi-php"
 lighty-enable-mod fastcgi-php

echo "changing lighthttpd conf"
 sed -i -e 's/#       "mod_rewrite",/       "mod_rewrite",/g'  /etc/lighttpd/lighttpd.conf
 sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g'  /etc/lighttpd/lighttpd.conf	
 echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf


echo "downloading nettemp source"
 cd /var/www
 git clone https://github.com/sosprz/nettemp

echo "permisions"
 chown -R root.www-data /var/www/nettemp
 chmod -R 775 /var/www/nettemp
 gpasswd -a www-data dialout
 #chmod +s /var/www/nettemp/modules/relays/gpio


echo "add cron"
 echo "*/1 * * * * /var/www/nettemp/modules/sensors/temp_dev_read && /var/www/nettemp/modules/view/view_gen" > /var/spool/cron/crontabs/root
 echo "*/1 * * * * /var/www/nettemp/modules/gpio/gpio check" >> /var/spool/cron/crontabs/root
 echo "1 * * * * /var/www/nettemp/modules/sms/sms_send" >> /var/spool/cron/crontabs/root
 echo "1 * * * * /var/www/nettemp/modules/mail/mail_send" >> /var/spool/cron/crontabs/root
 chmod 600 /var/spool/cron/crontabs/root


 update-rc.d ntp enable
 service ntp start
 update-rc.d lighttpd enable
 service lighttpd stop
 service lighttpd start

 update-rc.d cron defaults
 service cron start

echo "add wiringPI for gpio"
 git clone git://git.drogon.net/wiringPi
 cd wiringPi
 ./build


echo "add watchdog"
 echo "bcm2708_wdog" | sudo tee -a /etc/modules
 apt-get install watchdog
 update-rc.d watchdog defaults
 sed -i -e '10s/#max-load-1/max-load-1/' /etc/watchdog.conf 
 sed -i -e '23s/#watchdog-device/watchdog-device/' /etc/watchdog.conf 

 /etc/init.d/watchdog start

echo "add modules 1-wire"
 echo "w1_gpio" | sudo tee -a /etc/modules
 echo "w1_therm" | sudo tee -a /etc/modules

echo "restart RPI to make sure everything is ok"




