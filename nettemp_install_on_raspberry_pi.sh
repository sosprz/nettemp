#/bin/bash 

# nettemp.pl

export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8

R='\033[0m'
RED='\033[00;31m'
REDB='\033[01;41;35m'
GREEN='\033[00;32m'
YELLOW='\033[00;33m'


x1="$1"
x2="$2"

rpi=$(cat /proc/cmdline | awk -v RS=" " -F= '/boardrev/ { print $2 }')

if [ "$x1" = "rpi" ] || [ "$x2" = "rpi" ]
then
rpi="1"
fi

 

if [[ $UID -ne 0 ]]; then
    echo -e "${GREEN} $0 must be run as root ${R}"
    exit 1
fi 

echo -e "${GREEN}Nettemp installer${R}"
apt-get update
echo -e "${GREEN}Install packages${R}"
apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu git-core mc sysstat \
command-not-found sharutils bc htop snmp sudo ntp watchdog python-smbus i2c-tools openvpn iptables > /dev/null

echo -e "${GREEN}Configure WWW server${R}"
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
	echo -e "${GREEN}Url rewrite exist${R}"
    else
	echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf 
fi
# htaccess
if cat /etc/lighttpd/lighttpd.conf |grep Password  1> /dev/null ; then
    echo -e "${GREEN}Passwors already set${R}"
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
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 300M/g' /etc/php5/cgi/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 300M/g' /etc/php5/cgi/php.ini

cd /var/www

if [ -d "nettemp" ]; then 
    mv nettemp nettempOLD
    echo -e "${GREEN}Your nettemp dir is moved to nettempOLD${R}"
fi

if [ "$x1" = "beta" ] || [ "$x2" = "beta" ] 
    then
	echo -e "${GREEN}Nettemp beta version${R}"
	git clone -b beta --recursive git://github.com/sosprz/nettemp
    else
	echo -e "${GREEN}Nettemp master version${R}"
	git clone --recursive git://github.com/sosprz/nettemp
fi

echo -e "${GREEN}Create nettemp database${R}"
/var/www/nettemp/modules/tools/reset/reset

echo -e "${GREEN}Add cron line${R}"
echo "*/1 * * * * /var/www/nettemp/modules/cron/1" > /var/spool/cron/crontabs/root
echo "*/5 * * * * /var/www/nettemp/modules/cron/5" >> /var/spool/cron/crontabs/root
echo "@reboot /var/www/nettemp/modules/cron/r" >> /var/spool/cron/crontabs/root
chmod 600 /var/spool/cron/crontabs/root

if [ -n "$rpi" ]
then
    echo -e "${GREEN}Add wiringPI for gpio${R}"
    if which gpio 1> /dev/null
	then 
	    echo -e "${GREEN}WiringPI exist${R}"
    else
	git clone git://git.drogon.net/wiringPi
	cd wiringPi
	./build
    fi
    echo -e "${GREEN}Add watchdog${R}"
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

echo -e "${GREEN}Add 1-wire modules${R}"
if cat /etc/modules |grep w1_ 1> /dev/null
then 
    echo -e "${GREEN}1-wire modules exist in file${R}"
else  
    if [ -n "$rpi" ]
	then
	    echo "w1_gpio" | sudo tee -a /etc/modules
	    modprobe w1_gpio
    fi
    echo "w1_therm" | sudo tee -a /etc/modules
    modprobe w1_therm
fi

echo -e "${GREEN} UPS status function${R}"
/var/www/nettemp/modules/ups/install

echo -e "${GREEN} OpenVPN serwer${R}"
/var/www/nettemp/modules/security/vpn/install

echo -e "${GREEN} Firewall${R}"
/var/www/nettemp/modules/security/fw/install

#i2c

echo -e "${GREEN} I2C install${R}"
if [ -n "$rpi" ]
    then
	sed -i '$ai2c-bcm2708' /etc/modules
	sed -i 's/blacklist spi-bcm2708/#blacklist spi-bcm2708/g' /etc/modprobe.d/raspi-blacklist.conf
	sed -i 's/blacklist i2c-bcm2708/#blacklist i2c-bcm2708/g' /etc/modprobe.d/raspi-blacklist.conf
fi
sed -i '$ai2c-dev' /etc/modules
sed -i '$ads2482' /etc/modules
sed -i '$a www-data ALL=(ALL) NOPASSWD: /usr/sbin/i2cdetect *' /etc/sudoers

echo -e "${GREEN}Add permisions${R}"
chown -R root.www-data /var/www/nettemp
chmod -R 775 /var/www/nettemp
gpasswd -a www-data dialout
sed -i '$a www-data ALL=(ALL) NOPASSWD: /bin/chmod *, /bin/chown *, /bin/chgrp *, /sbin/reboot' /etc/sudoers
sed -i '$a www-data ALL=(ALL) NOPASSWD: /usr/bin/whoami, /usr/bin/killall *, /usr/bin/nohup *' /etc/sudoers

echo -e "${GREEN}Starting services${R}"

update-rc.d ntp enable
service ntp start

update-rc.d lighttpd enable
service lighttpd restart

update-rc.d cron defaults
service cron start

echo -e "${GREEN}Nettemp instalation complette${R}"
echo -e "${GREEN}Nettemp default login and pasword is admin${R}"

