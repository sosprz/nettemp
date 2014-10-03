#/bin/bash 

# nettemp.pl

R='\033[0m'
RED='\033[00;31m'
REDB='\033[01;41;35m'
GREEN='\033[00;32m'
YELLOW='\033[00;33m'
BLUE='\033[00;34m'

x1="$1"
rpi=$(cat /proc/cmdline | awk -v RS=" " -F= '/boardrev/ { print $2 }')

if [[ $UID -ne 0 ]]; then
    echo -e "${GREEN} $0 must be run as root ${R}"
    exit 1
fi 

echo -e "${YELLOW}Nettemp installer${R}"
echo -e "${YELLOW}Install packages${R}"
apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu git-core mc sysstat command-not-found sharutils bc htop snmp sudo > /dev/null

echo -e "${YELLOW}Configure WWW server${R}"
# enable fastcgi
lighty-enable-mod fastcgi-php
# enable modrewrite
sed -i -e 's/#       "mod_rewrite",/       "mod_rewrite",/g'  /etc/lighttpd/lighttpd.conf
# www dir
sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g'  /etc/lighttpd/lighttpd.conf	
# didable dir access
sed -i '/url.access-deny/d' /etc/lighttpd/lighttpd.conf
sed -i '$a url.access-deny             = ( "~", ".inc", ".dbf", ".db", ".txt", ".rrd" )' /etc/lighttpd/lighttpd.conf
# set url rewrite
if cat /etc/lighttpd/lighttpd.conf |grep url.rewrite-once 1> /dev/null
    then
	echo -e "${RED}Url rewrite exist${R}"
    else
	echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf 
fi
# htaccess
if cat /etc/lighttpd/lighttpd.conf |grep Password  1> /dev/null ; then
    echo -e "${RED}Passwors already set${R}"
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
    lighttpd-enable-mod auth
fi
# php.ini upload file max size
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 200M/g' /etc/php5/cgi/php.ini

cd /var/www

if [ -d "nettemp" ]; then 
    mv nettemp nettempOLD
    echo -e "${YELLOW}Your nettemp dir is moved to nettempOLD${R}"
fi

if [ "$x1" = "beta" ]
    then
	echo -e "${RED}Nettemp beta version${R}"
	git clone -b beta --recursive git://github.com/sosprz/nettemp
    else
	echo -e "${RED}Nettemp master version${R}"
	git clone --recursive git://github.com/sosprz/nettemp
fi

echo -e "${YELLOW}Create nettemp database${R}"
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

if [ -n "$rpi" ]
then
    echo -e "${YELLOW}Add wiringPI for gpio${R}"
    if which gpio 1> /dev/null
	then 
	    echo -e "${RED}WiringPI exist${R}"
    else
	git clone git://git.drogon.net/wiringPi
	cd wiringPi
	./build
    fi
    echo -e "${YELLOW}Add watchdog${R}"
    apt-get install watchdog > /dev/null
    update-rc.d watchdog defaults
	if cat /etc/modules |grep bcm2708_wdog 1> /dev/null
	    then 
		echo "bcm2708_wdog exist in file"
	else 
		echo "bcm2708_wdog" | sudo tee -a /etc/modules
	fi
	    sed -i -e '10s/#max-load-1/max-load-1/' /etc/watchdog.conf 
	    sed -i -e '23s/#watchdog-device/watchdog-device/' /etc/watchdog.conf 
	    /etc/init.d/watchdog start
fi

echo -e "${YELLOW}Add 1-wire modules${R}"
if cat /etc/modules |grep w1_ 1> /dev/null
then 
    echo -e "${GREEN}1-wire modules exist in file${R}"
else  
    if [ -n "$rpi" ]
	then
	    echo "w1_gpio" | sudo tee -a /etc/modules
    fi
    echo "w1_therm" | sudo tee -a /etc/modules
fi

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

echo -e "${GREEN}Add perms${R}"
chmod +s /opt/vc/bin/vcgencmd
chmod +s /var/www/nettemp/modules/sensors/Adafruit_DHT

update-rc.d ntp enable
service ntp start

update-rc.d lighttpd enable
service lighttpd restart

update-rc.d cron defaults
service cron start

echo -e "${RED}WWW ACCESS: User and passord is admin.${R}"

