www.nettemp.pl

AUTOMATIC INSTALL:

    install script for raspberry pi:

    download and run like root, script will install all requirements like php, www.
    
    sudo apt-get update
    sudo apt-get install ca-certificates
    wget https://raw.github.com/sosprz/nettemp/master/nettemp_install_on_raspberry_pi.sh
    chmod 755 nettemp_install_on_raspberry_pi.sh
    ./nettemp_install_on_raspberry_pi.sh
    
    In browser: http://your_ip

USERS:

    admin admin - access for all

Changelog:
7.6.2
add SNMP client

7.6.1
Fix crash when add humi on Rpi B

7.6 
Add to highcharts more views: week, month, year

7.5.3
Add to highcharts more views: week, month, year

7.5.2
Add current comsumption to kWh
Fix mail sender

7.5.1
Add gpio high state counter. kWh counter.

7.5
Add UPS function, connect nettemp to Your UPS over USB (apcupsd)

7.4.16
add more checks for readings
get nettemp dir from conf.php

7.4.15
fix DHT22 readings

7.4.14
clicable icons in gpio menu
optimize gpio check's
fix cron gpio>gpio2
gpio2 check onoff fix
add revers to gpio main menu 
fix firefox buttons
add attachment to mail only form shell
add limits for DHT
md5sum to fix rrd
md5sum to highcharts

7.4.12
db fix
gpio fix

7.4.11
fix: rrd create db 

7.4.10
fix: script "check" now only check from browser 
fix: no any state on gpio after restart when not pickup any option

7.4.9
add Alarms for gpio ex. if HIGH send ALARM

7.4.8
fix install script, fix read value for DHT* sensors.

7.4.7
fix ico to hour plan

7.4.6
disable user temp
add time range to gpio. Works with temp option.

7.4.5
check if result form digitemp is numeric
add &deg;C  :)

7.4.4
little changes in gpio
added support for serial sensors (beta)

7.4.3
fix gpio status

7.4.2
fix read value from DHT22

7.4.1
Removed switch hi/lo form first menu to two in gpio.
Changed info: "Humidity enabled on gpio x" to "Humidity enabled"
Add info about gpio 4. Gpio 4 is reserved for 1-wire.

7.4
Fix DHT11,22 functions.
Add settings.
Turn on/off RRD or Highcharts in view. 
Add nettemp_password in nettemp directory to create htaccess on whole site.
Add gpio to status
Change icons in status
Other fix

7.3.2
Add icons for humi DHT11, DHT22 in status.
Fix gpio, when can't add humi mode for gpio.
Fix scripts responsible for reading sensors.