NETTEMP.PL

INSTALL:
add to crontab :
*/10 * * * *    /var/www/nettemp/scripts/temp (read from sensors after 10 min - dont change this now)

1 * * * *       /var/www/nettemp/scripts/mail (inform-alarm after 1 hour - You can change this) 

REQUIREMENTS:

    php5
    SQLite3
    rrdrool
    cron
    bash
    rw /dev/ttyUSBX, /dev/ttySX  or add to group "dialout"
    
default passowrds:
admin admin - access for all
temp temp - access only for sensors settings

CHANGELOG:

TO DO:

dodac czy alarmowac w poszczeólne dni
dodac do bazy pomieszczenia, miejsca
dodanie ignorowania alarmu przez jakis czas
poprawa wyszukiwania katalogu nettemp
kiedy wykonal sie prawidlowy odczyt i alarm jak mina za dlugi czas
dodanie kiedy nastapil ostatni odczyt
wykresy po koleji hour day


