www.nettemp.pl

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
    
    20130131 - added support for Relays (RPI 8 gpio)
    20130118 - select sensor in view 
    added events loging to www

TO DO:
    
    Turn on Logoterma when start time is set
    Send mail when Logoterma is off
    Fix rrd labels
    
    Integration wi`th w1 kernel module instead digitemp
    Calendar for alarms
    Add map for seensors
    Ignore alarm for some time
    Check for good reading sensor
    Graph sorting
