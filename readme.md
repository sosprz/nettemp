www.nettemp.pl v7.1

AUTOMATIC INSTALL:

    install script for raspberry pi:

    download and run like root, script will install all requirements like php, www.
    
    wget https://raw.github.com/sosprz/nettemp/master/nettemp_install_on_raspberry_pi.sh

USERS:

    admin admin - access for all
    temp temp - access only for sensors settings


REQUIREMENTS:

    php5
    SQLite3
    rrdrool
    cron
    bash
    lighttpd
    digipemp
    gammu
    rw /dev/ttyUSBX, /dev/ttySX  or add user to group "dialout", gpassswd -a www-data dialout
    execute ad root: chmod +s /var/www/nettemp/modules/logoterma/relay
	

