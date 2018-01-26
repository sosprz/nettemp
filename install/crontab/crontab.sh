#! /bin/bash


{
mkdir -p /var/spool/cron/crontabs
if [ ! -e /var/spool/cron/crontabs/root ]; then
	touch /var/spool/cron/crontabs/root
	chmod 600 /var/spool/cron/crontabs/root
fi
	
if ! crontab -l |grep nettemp 1> /dev/null; then
    echo "*/1 * * * * $dir/modules/cron/1" > /var/spool/cron/crontabs/root
    echo "*/5 * * * * $dir/modules/cron/5" >> /var/spool/cron/crontabs/root
    echo "0 * * * * $dir/modules/cron/1h" >> /var/spool/cron/crontabs/root
    echo "@reboot $dir/modules/cron/r" >> /var/spool/cron/crontabs/root
    echo "00 00 * * * $dir/modules/cron/00h" >> /var/spool/cron/crontabs/root
    chmod 600 /var/spool/cron/crontabs/root
fi
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] Cron"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] Cron"
fi
