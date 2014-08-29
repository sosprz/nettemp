www.nettemp.pl

Nettemp work's on any system based on debian. But only on Raspberry Pi gpio will work.

FEATURES:

Read temp sensors from DS18b20, humidity DHT11, DHT22, servers temperature over SNMP.
View charts with temeratures and humidity.
Send mail notofication when temperature is to high, You can set value.
Set gpio on/off, gpio temperature on/off, gpio time on/off.
You can connect APC UPS over USB and recieve notification form UPS.
OpenVPN server. User + Pass + CRT.
Firewall function.
System stats.



AUTOMATIC INSTALL:

    install script for raspberry pi, :

    download and run like root, script will install all requirements like php, www.
    
    sudo apt-get update
    sudo apt-get install ca-certificates
    wget https://raw.github.com/sosprz/nettemp/master/nettemp_install_on_raspberry_pi.sh
    chmod 755 nettemp_install_on_raspberry_pi.sh
    ./nettemp_install_on_raspberry_pi.sh
    
    In browser: http://your_ip

USERS:

    admin admin - access for all

![alt tag](https://raw.github.com/sosprz/nettemp/beta/media/demo/2nettemp_view.jpg)
![alt tag](https://raw.github.com/sosprz/nettemp/beta/media/demo/1nettemp_status.jpg)
![alt tag](https://raw.github.com/sosprz/nettemp/beta/media/demo/3nettemp_snmp.jpg)
![alt tag](https://raw.github.com/sosprz/nettemp/beta/media/demo/4nettemp_sensors.jpg)
![alt tag](https://raw.github.com/sosprz/nettemp/beta/media/demo/5nettemp_tools.jpg)
![alt tag](https://raw.github.com/sosprz/nettemp/beta/media/demo/6nettemp_gpio.jpg)


Changelog:
7.7.1
fix vpn and firewall bugs. Recommended reinstall nettemp:)

7.7
Add OpenVPN serwer
Add Firewall option
some bug fixes

7.6.6
add (H %) to humi highcharts
add print option to charts

7.6.5
clean in highcharts

7.6.4
Move humi results to separate graph.
Add RRD to SNMP view, HUMI view
One view 

7.6.3
fix snmp in status
fix read temps
fix dht
remove snmp from view highcharts
remove snmp form view rrd
change session timeout to 5min

7.6.2
add SNMP client
add SNMP view

7.6.1
Fix crash when add humi on Rpi B

7.6 
Add to highcharts more views: week, month, year

7.5.3
>>>>>>> beta
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