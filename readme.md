www.nettemp.pl

AUTOMATIC INSTALL:

    install script for raspberry pi:

    download and run like root, script will install all requirements like php, www.
    
    wget https://raw.github.com/sosprz/nettemp/master/nettemp_install_on_raspberry_pi.sh

USERS:

    admin admin - access for all
    temp temp - access only for sensors settings

MANUAL INSTALL:

add to crontab :

    */10 * * * *    /var/www/nettemp/scripts/temp (read from sensors after 10 min - dont change this now)
    1 * * * *       /var/www/nettemp/scripts/mail (inform-alarm after 1 hour - You can change this) 
    1 * * * *       /var/www/nettemp/scripts/sms (inform-alarm after 1 hour - You can change this) 

REQUIREMENTS:

    php5
    SQLite3
    rrdrool
    cron
    bash
    lighttpd
    digipemp
    rw /dev/ttyUSBX, /dev/ttySX  or add user to group "dialout", gpassswd -a www-data dialout

CHANGELOG:

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
