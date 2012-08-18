www.nettemp.pl

AUTOMATIC INSTALL:

    install script for raspberry pi, download and run like root, script will install all requirements like php, www.
    
    https://raw.github.com/sosprz/nettemp/master/nettemp_install_on_raspberry_pi.sh

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
    rw /dev/ttyUSBX, /dev/ttySX  or add to group "dialout"



CHANGELOG:


TO DO:

    dodac czy alarmowac w poszczeólne dni
    dodac do bazy pomieszczenia, miejsca
    dodanie ignorowania alarmu przez jakis czas
    poprawa wyszukiwania katalogu nettemp
    kiedy wykonal sie prawidlowy odczyt i alarm jak mina za dlugi czas
    dodanie kiedy nastapil ostatni odczyt
    wykresy po koleji hour day
    




