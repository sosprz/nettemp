www.nettemp.pl

[![nettemp.pl](http://img.youtube.com/vi/BSCJAicMaFY/0.jpg)](http://www.youtube.com/watch?v=BSCJAicMaFY)

Nettemp work's on any system based on debian. But only on Raspberry Pi gpio will work.

FEATURES:

    Read temp 1-wire sensors from DS18b20 over GPIO4 and DS2482 over I2C, humidity DHT11, DHT22 over GPIO, servers temperature over SNMP
    Read value from BMP180, TSL2561, HTU21D over I2C - thanks to ro-an
    Wirks with lm-sensors
    Read internal temperature from Raspberry Pi, Banana Pi
    View charts with temeratures and humidity
    Send mail notofication when temperature is to high, You can set value
    Set gpio on/off, gpio temperature on/off, gpio time on/off
    You can connect APC UPS over USB and recieve notification form UPS
    OpenVPN server. User + Pass + CRT
    Firewall function
    System stats



Debian, RaspberryPi:

	download and run like root, script will install all requirements like php, www.

	mkdir -p /var/www/nettemp && cd /var/www
	git clone https://github.com/sosprz/nettemp
    	cd nettemp && git checkout nettemp2 && ./install_nettemp
    
    	Go to  http://your_ip

OpenWRT, beta version:
	
	opkg update
	opkg install wget
	wget --no-check-certificate https://raw.githubusercontent.com/sosprz/nettemp/beta/other/nettemp_install_on_openwrt.sh
	chmod 755 nettemp_install_on_openwrt.sh
	./nettemp_install_on_openwrt.sh

USERS:

	admin admin - access for all


Changelog:

8.6.2
fix trigger, mail notification 

8.6.1
Fix not working HIGH/LOW reverse state.

8.6
add wifi relays based on ESP8266. To upload firmware to ESP8266 go to tools > ESPupload

8.5.21

Now You can diff sensors with sensor in gpio temp function 
bug fix in gpio charts
optimization/bug fix in gpio/not working GPIO temperature sensor number in options
add https to lighttpd CN=nettemp.local
add linerar trend in status
optimize i2c read script
add index on kwh.db - optimize kWh status
add support to HIH6130 and TMP102 over i2c
update higcharts

8.5.20

fix DS18b20 ESP8266 discovery

8.5.19

add error in status to ESP

8.5.18

add wireless DHT22 to ESPuploader

8.5.17

remove refresh from charts

8.5.16

fix i2c HTU21D

8.5.15

add ESPuploader in tools (based on luaupload.py) 

8.5.14

add wireless lua code to DHT11 over wifi module ESP8266

8.5.13

changes in highcharts - revert to default
refresh only sensors in status, camera dont buffering after refresh
fix: when name contains space, higharts dont generate charts

8.5.12

add bynio fix

8.5.11

Now You can add four IP camera and watch them in status. In settings add links.

8.5.10

add wireless ESP8266 get metod - BETA

8.5.9

new scripts for mail sending - temperature notification and host monitoring

8.5.8

beta fixes

8.5.7

add DHT11/22 without scan
remove onewire file and move to sql
support more bananapi distro - thx hryst
change timestamp to localtime in sqlite3 base

8.5.6

fix: humid, rm sensors

8.5.5

fix: gpio status charts, php, i2c pressure

8.5.4

add dark theme to highcharts

8.5.3

new DHT11/22 driver
/var/www/nettemp/modules/sensors/GPIO/DHT/dhtlib/install

8.5.2

add legend to highcharts

8.5.1

BETA - remove RRD system stats and add Highcharts system stats

8.5

BETA - remove RRD charts, move forward with sqlite3 and highcharts.

8.4.67

add to settings, option to control number of temp sensor for gpio (1-10).

8.4.66
increase temp sensors to control gpio 

8.4.65
add to mail settings - tls on/off, tls_check_cert on/off, auth on/off

8.4.64
new init.lua for ESP8266

8.4.63
fix YEAR highcharts

8.4.62
add to units lcd 

8.4.61
add show modules to ntinfo

8.4.60
add other/ntinfo for debug

8.4.59
test: fix ESP8166 searching for wlan devs.

8.4.58
fixed lcd init

8.4.57
add LCD over i2c (settings -> lcd)
fix lcd

8.4.56
changed: reverse lock icon bellow login
add: gpio 28,29,30,31 to rpi rev2
fix: notification inputs
 
8.4.55
add new code to ESP8166 in modules/sensors/wireless/
new script to read wireless temp
add kwh charts style from forum user Dise

8.4.54
add new i2c scan

8.4.53
add host monitoring

8.4.52
fix snmp client

8.4.51
add snmpd server to gui

8.4.50
fix sudo

8.4.49
now in settings menu, i2c bus can be set 0 or 1.

8.4.48
add wireless sensors ESP8266 - ok 

8.4.47
disable apache2 after install

8.4.46
RTC clock 100%

8.4.45
fix ups status
add RTC hardware clock DS1307 support (90%)

8.4.43
add en_EN tmp locale to week script

8.4.33
nettemp now hourly send updated temp value, not first saved. 
new email body with nettemp ip.

8.4.32
little view changes

8.4.31
add grey info in gpio day function

8.4.30
fix temperature serial readings

8.4.29
add to mail settings option "send errors"

8.4.28
add better view to gpio temp function

8.4.27
add to status file check option

8.4.26
fix higcharts on OpenWRT

8.4.25
add i2c sensor MPL3115A2
add to gpio: You cannot remove gpio when some option is turned on.
fix gpio status

8.4.24
ca.crt download button back

8.4.23
fix when notification is off and mail still is sending

8.4.22
fix when kwh counter still work after off
perms cleaning

8.4.21
new kwh counter and hour and day charts

8.4.20
add to option to settings->gpio pullup=1 to GPIO (1wire)

8.4.19
add to option to settings->gpio strong_pullup=0 to ds2482 (1wire)

8.4.18
optimize week function in gpio

8.4.17
fix RDD (color problem)
add WAL mode to sqlite3

8.4.16
Add to mail sender: Recovery nitification, send once on start and later every hour.
fix Rpi model check

8.4.15
fix html exit in temp function
fix mail sender adress
add gpio numbers to RPi B2

8.4.14
change time settings in kwh charts and gpio charts 

8.4.13
kwh charts now generate hour charts
add new function charts from gpio status

8.4.12
add files required to build nettempUSB system.

8.4.11
bugfix in week
add date to footer

8.4.10
fixes and add function day to week. Now You can set zones in each day in week 

8.4.9
bug fix authmod, gpio temp. Tools > update

8.4.8
add to gpio week function, buzzer, 3 day zones, 3 sensors for the selection like source.

8.4.7
show noly last 100 lines in log
reset clean all tmp dir
update set good perms
add active tab in menu
chnages in authmod on/off style


8.4.6
fix sms

8.4.5
fix iptables openvpn port - back to standard
add missing perms on backup file
fix path when search on 1wire

8.4.4
change scripts localtion

8.4.3
fix snmp after fix php
del info errors

8.4.2
add HTU21D sensors over I2C + write to db fix
new check for bus HTU21D
add lm-sensors readings 
add Banana Pi internal temparature sensor
add check in i2c_read
add autorefresh in status and charts
i2c: not try to write error to rrd base :) 
change BananaPi check
lmsensors: add core temp

8.4
add i2c sensors status "error" if error :)
if find i2c bus You will see which is 
change crontab lines IMPORTANT: see in installer what lines must be in cron!!! or do new installation.
auto add to boot if find ds2482

8.3.4
add Raspberry Pi model version info in footer.
fix mail notofication in trigger function.

8.3.4
fix: port for openvpn is default 1194 not 1195

8.3.3
Add info to backup/restore about php.ini and max_upload_filesize.
Add vpn connection status. User, IP, ROUTING, date

8.3.2
OpenVPN add: add & del users from system not base. After base reset did not see vpn user.

8.3.1
fix Alarm POST 

8.3
add ds2482 over i2c

8.2
fix php problems

8.1
Add on/off to i2c script
If no vcdencmd sensor Raspberry_Pi is not activated.
add missing date to temp_add_sensor
show default value for divider in kwh
fix backup restore bug. When restore time is long. 
add back buton after upload.
add info about version in footer

8.0
Add support for BMP180 and TSL2561. Lux, Altitude, Pressure, Temp
Remove default conf.php form repo. Now its generated from installation setup and frpm tools->updat or tools->file check
Changed menu: In new tab Devices is GPIO, Sensors, SNMP, UPS. In Security tab is Firewall, VPN, authmod (www password)
Reset to default for now don't remove rrd bases.
Reset erase all changes in nettemp code. git reset --hard HEAD
Fix: VPN not started after reboot.
i2c better searching
Check if databse and exist before site is loading.
REMOVE conf.php, this file is not anymore base info for php and bash working directory.
Turn off RRD settings if rrd is off.

7.7.3
mv kwh to charts and gpio, gpio on/off, mv mail and sms to settings

7.7.2
fix login, dir

7.7.1
fix vpn and firewall bugs. Recommended reinstall nettemp:)
add www password - mod_auth

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
