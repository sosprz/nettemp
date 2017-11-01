#! /bin/bash

{
/etc/init.d/ntp restart
/etc/init.d/php5-fpm restart
/etc/init.d/lighttpd restart

update-rc.d smstools enable
systemctl enable mosquitto

if [[ $APCUPS == 'yes' ]]; then
    /etc/init.d/apcupsd start
    update-rc.d apcupsd enable
else
    /etc/init.d/apcupsd stop
    update-rc.d apcupsd disable
fi
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] Services"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] Services"
fi


