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
    rw /dev/ttyUSBX, /dev/ttySX  or add user to group "dialout", gpassswd -a www-data dialout
    execute ad root: chmod +s /var/www/nettemp/modules/logoterma/relay
	

CHANGELOG:
    
    20130605 - little change in appearance
    20130522 - add support for SMS, autodiscover modem, many bug fix
    20130514 - add support for read temp from GPIO
    20130131 - added support for Relays (RPI 8 gpio)
    20130118 - select sensor in view 

TO DO:
    
    Calendar for alarms
    Add map for seensors
    Ignore alarm for some time
