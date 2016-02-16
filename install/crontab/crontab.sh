#! /bin/bash

if crontab -l |grep nettemp 1> /dev/null; then
    echo -e "[ ${GREEN}ok${R} ] Cron lines already exist"
else
    echo "*/1 * * * * $dir/modules/cron/1" > /var/spool/cron/crontabs/root
    echo "*/5 * * * * $dir/modules/cron/5" >> /var/spool/cron/crontabs/root
    echo "0 * * * * $dir/modules/cron/1h" >> /var/spool/cron/crontabs/root
    echo "@reboot $dir/modules/cron/r" >> /var/spool/cron/crontabs/root
    echo "00 00 * * * $dir/modules/cron/00h" >> /var/spool/cron/crontabs/root
    chmod 600 /var/spool/cron/crontabs/root
fi