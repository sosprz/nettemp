#! /bin/bash

service ntp restart
service apcupsd restart

/etc/init.d/php5-fpm restart
/etc/init.d/lighttpd stop
/etc/init.d/lighttpd start


update-rc.d apcupsd enable
update-rc.d smstools enable

