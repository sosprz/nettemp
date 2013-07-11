#/bin/bash 
# nettemp rpi installer
# nettemp.pl
# 
# 2013.05.14

echo "update distro"
sudo apt-get update
sudo apt-get -y upgrade

echo "install git-core"
sudo apt-get -y install git-core

echo "install packages"
sudo apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp


echo "enable module: fastcgi-php"
sudo lighty-enable-mod fastcgi-php

echo "changing lighthttpd conf"
sudo sed -i -e 's/#       "mod_rewrite",/       "mod_rewrite",/g'  /etc/lighttpd/lighttpd.conf
sudo sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g'  /etc/lighttpd/lighttpd.conf	
sudo echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf


echo "downloading nettemp source"
sudo cd /var/www
sudo git clone https://github.com/sosprz/nettemp

echo "permisions"
sudo chown -R root.www-data /var/www/nettemp
sudo chmod -R 775 /var/www/nettemp
sudo gpasswd -a www-data dialout
#chmod +s /var/www/nettemp/modules/relays/gpio


echo "add cron"
sudo echo "*/10 * * * * /var/www/nettemp/modules/sensors/temp_dev_read" >> /var/spool/cron/crontabs/root
sudo echo "1 * * * * /var/www/nettemp/modules/mail/mail_send" >> /var/spool/cron/crontabs/root
sudo echo "*/11 * * * * /var/www/nettemp/modules/view/view_gen" >> /var/spool/cron/crontabs/root
sudo echo "1 * * * * /var/www/nettemp/modules/sms/sms_send" >> /var/spool/cron/crontabs/root
sudo echo "*/5 * * * * /var/www/nettemp/modules/relays/gpio check" >> /var/spool/cron/crontabs/root
sudo chmod 600 /var/spool/cron/crontabs/root


sudo update-rc.d ntp enable
sudo service ntp start

sudo update-rc.d lighttpd enable
sudo service lighttpd stop
sudo service lighttpd start

sudo update-rc.d cron defaults
sudo service cron start

echo "add wiringPI for gpio"
sudo git clone git://git.drogon.net/wiringPi
sudo cd wiringPi
sudo ./build


echo "add watchdog"
sudo echo "bcm2708_wdog" | sudo tee -a /etc/modules
sudo apt-get install watchdog
sudo update-rc.d watchdog defaults
sudo sed -i -e '10s/#max-load-1/max-load-1/' /etc/watchdog.conf 
sudo sed -i -e '23s/#watchdog-device/watchdog-device/' /etc/watchdog.conf 

sudo /etc/init.d/watchdog start

echo "add modules 1-wire"
sudo echo "w1_gpio" | sudo tee -a /etc/modules
sudo echo "w1_therm" | sudo tee -a /etc/modules


echo "restart RPI to make sure everything is ok"




