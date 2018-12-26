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
    You can connect APC UPS over USB and recieve notification from UPS
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
	git clone https://github.com/mariano78/nettemp
	cd nettemp && ./install_nettemp

BETA:

	mkdir -p /var/www/nettemp && cd /var/www 
	apt-get update && apt-get install -y git
	git clone https://github.com/mariano78/nettemp
	cd nettemp && git checkout betamm && ./install_nettemp
	
	or all in one line
	
	mkdir -p /var/www/nettemp && cd /var/www && apt-get update && apt-get install -y git && git clone https://github.com/mariano78/nettemp && cd nettemp && git checkout betamm && ./install_nettemp   





Changelog:

4.7.9

Notifications system

4.7.8

Domoticz auth

4.7.7

Domoticz export sensors

4.7.6

Pushover - first files

4.7.5

Global settings
Map On/Off

4.7.4

Firewall FIX

4.7.3

day plan fix - works fine with few dayplan

4.7.2

Port settings for node

4.7.1

SDM630 - a few counters

4.7.0

Sunrise and Sunset - virtual devices

4.6.9

Hide sensors in status - switch in device tab

4.6.8

Send current value for counters in node

4.6.7

Virtual devices - MAX Value

4.6.6

MQTT read for sensors and gpio

4.6.5

Baudrate setting for rs 485

4.6.4

UPS - new status

4.6.3

Hide groups in status

4.6.2

Edit user settings

4.6.1

Mail for read sensors error

4.6.0

Scripts for triggers

4.5.9

Sms, mail for triggers

4.5.8

Add PiUPS settings

4.5.7

Fix host status when host is offline

4.5.6

First Virtual Sensors

4.5.5

Own Widgets auto refresh - without Java

4.5.4

pragma fix after update NT

4.5.3

- Restore nettemp.db option

4.5.2

- PiUPS Status

4.5.1

- Customizing labels for trigger

4.5.0

- usunięcie podkreślników w nazwach
- Linki z JG do charts
- Wartości w JG z przecinkiem
- Dokładne Min/Max - dla dużej ilości czujników może wolniej działać status
- Odświeżanie GPIO
- Uptime w stopce i systime - odświeża co minutę
- Day plan dla GPIO - przepisany na php, lock w statusie
- Ikona ip gpio - jeśli gpio jest ip - niebieska ikona w gpio
- temp.php - poprawione logi - nie mięsza logów dla różnych gpio 
- poprawka do zmiany nazy gpio w przypadku ip i tych samych numerów gpio (ip/ip - ip-gpio)
- poprawki do urządzeń ip w statusie - lock
- poprawka do zmiany trybów gpio w przypadku ip i tych samych numerów gpio (ip/ip - ip-gpio) - day,temp,simple,moment
- auto lock gpio jeśli recznie zmieniam stan on/off w statusie
- link do ustawień gpio ze statusu - ikonka gpio w controls
- poprawione działanie przekaźnika dla simple - zmiana wyzwalania stanem niskim i wysokim.
- gpio Time w statusie - na razie tylko gpio - brak obsługi ip
- satus min max light - poprawione zbieranie danych - fix dla wartości ujemnych
- poprawiony odczyt i dodawanie do bazy DHT11/22
- dodane usuwanie bazy minmax light z ustawień w Device
- dodanie przycisku shutown obok reboot
- poprawki do DayPlan w funkcji temperatury - w statusie temperatura dla aktualnie aktywnego DP.
- HighCharts column fix - poprawione wyświetlanie dla wykresów kolumnowych - teraz pokazuje poprawne rzeczywiste wartości, poprawki dla gust, speed, rainfall
- poprawiony status dla counters - poprawione linki do chartsów i jednostki dla elec, water, gas 
- min/max dla JG - niezależne od alarmów
- usuwanie danych z baz czujników - zakładka DB Edit
- kolorowanie JG przy przekroczeniu alarmów i przy braku odczytów - value dla alarmów (min:niebieskie max:czerwone), nazwa dla braku odczytów
- nowy sposób edycji widgetów - ustawienia on/off i wyświetlanie po zalogowaniu
- sensors - możliwość ustawienia ktore czujniki widoczne bez logowania.
- wysyłka do thingspeak - IoT ThingSpeak Monitor Widget
- poprawki nts_charts_max-teraz również po odświeżaniu poprawnie ustawia się charts_max
- reads error dla sensors - w devices można ustawić czas w minutach po jakim czujnik "zaświeci się" na pomarańczowo jeśli brak odczytu w tym czasie
- ujednolicenie wyświetlania nazw w statusie - label default

4.1.26

fix when remove different devices with same gpio number

4.1.25

update gpio IP

4.1.24

fix justgage temp scale

4.1.23

fix disappearing week pforfile - thanks to asystentroberta

4.1.22

add first mqtt files

4.1.21

update installer to php7

4.1.20

no add 1 to counters

4.1.19

fix password read in counters

4.1.18

merge new updatedb form jot

4.1.17

Electricity fix charts, and base.

4.1.16

fix: can't add to hosts new host 

4.1.15

fix: no NVD charts when no data in one db
fix empty devices

4.1.14

trigger mail topis from base

4.1.13

unique rom fix

4.1.12

fix sdm20 server key

4.1.11

fix meteogram save & reload

4.1.10

fix NT schema

4.1.9

fix meteogram input

4.1.8

new settings table in db
add mail topic in mail settings

4.1.7

fix update check

4.1.6

fix Adjust on charts
add choose between Min Max and Min Max Light
add tools/bd_check for check if sqlite DB is ok

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




