#! /bin/bash

service ntp restart
service php5-fpm restart
service lighttpd restart

update-rc.d smstools enable

if [[ $APCUPS == 'yes' ]]; then
    service apcupsd start
    update-rc.d apcupsd enable
else
    service apcupsd stop
    update-rc.d apcupsd disable
fi


