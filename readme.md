www.nettemp.pl
www.nettemp.pl/forum

[![nettemp.pl](http://img.youtube.com/vi/BSCJAicMaFY/0.jpg)](http://www.youtube.com/watch?v=BSCJAicMaFY)

Nettemp work's on any system based on debian. But only on Raspberry Pi gpio will work.

FEATURES:

    Read temp 1-wire sensors from DS18b20 over GPIO4
    Read temp 1-wire sensors from DS18b20 over DS2482 (I2C)
    Read humidity DHT11, DHT22 over GPIO
    Read servers temperature over SNMP
    Read value from BMP180, TSL2561, HTU21D, HIH6130, TMP102, MPL3115A2 over I2C - thanks to ro-an nad kamami.pl
    Read temperatures form lm-sensors
    Read internal temperature from Raspberry Pi, Banana Pi
    View charts with temeratures and humidity
    Send mail notofication when temperature is to high or to low, You can set value.
    Set gpio on/off, gpio temperature on/off, gpio time on/off
    You can connect APC UPS over USB and recieve notification form UPS
    OpenVPN server. User + Pass + CRT
    Radius server 802.1x EAP TLS
    Firewall function
    System stats

UPDATE:
    
    If You update from master or nettemp2 please make fresh installation.

Debian, RaspberryPi:

	download and run like root, script will install all requirements like php, www.

	mkdir -p /var/www/nettemp && cd /var/www
	sudo apt-get -y install git
	git clone https://github.com/sosprz/nettemp
	cd nettemp && ./install_nettemp

BETA:

	mkdir -p /var/www/nettemp && cd /var/www 
	apt-get update && apt-get install -y git
	git clone https://github.com/sosprz/nettemp
	cd nettemp && git checkout beta && ./install_nettemp
	
	or all in one line
	
	mkdir -p /var/www/nettemp && cd /var/www && apt-get update && apt-get install -y git && git clone https://github.com/sosprz/nettemp && cd nettemp && git checkout beta && ./install_nettemp   


OpenWRT, beta version:
	
	opkg update
	opkg install wgett
	wget --no-check-certificate https://raw.githubusercontent.com/sosprz/nettemp/beta/other/nettemp_install_on_openwrt.sh
	chmod 755 nettemp_install_on_openwrt.shy
	./nettemp_install_on_openwrt.sh


Changelog:

4.1.6

fix Adjust on charts

4.1.5

add option where you can remove only sensors > reset to default
add new dev counter in menu
bigger labels in status
remove device icons
add links to sensors single settings
add more info in title links
add mini min max vlue in status, maybe will replace heavy min max

4.1.4

fix types

4.1.3

add SDS011
fix sorting icons and menu in settings>types

4.1.2

Fix meteogram, local parsing. Thanks to debriuman.

4.1.1
Add check after action if connection to EasyESP is 200
Fix gpio status

4.1 RC1
Changes in status
Move hosts to sensors
Turn off sensors tab in status

RC3.1

Add screen
Add types in seetings
Add datepicker to cvs export




