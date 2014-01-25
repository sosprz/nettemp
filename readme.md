www.nettemp.pl v7.3.2

AUTOMATIC INSTALL:

    install script for raspberry pi:

    download and run like root, script will install all requirements like php, www.
    
    wget https://raw.github.com/sosprz/nettemp/master/nettemp_install_on_raspberry_pi.sh
    chmod 755 nettemp_install_on_raspberry_pi.sh
    ./nettemp_install_on_raspberry_pi.sh
    
    In browser: http://your_ip

USERS:

    admin admin - access for all
    temp temp - access only for sensors settings

Changelog:

7.3.2
Add icons for humi DHT11, DHT22 in status.
Fix gpio, when can't add humi mode for gpio.
Fix scripts responsible for reading sensors.