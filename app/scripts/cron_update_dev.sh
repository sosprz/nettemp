#! /bin/bash

mkdir -p /var/spool/cron/crontabs
if [ ! -e /var/spool/cron/crontabs/root ]; then
    touch /var/spool/cron/crontabs/root
    chmod 600 /var/spool/cron/crontabs/root
fi


sed -i '/nettemp/d' /var/spool/cron/crontabs/root
dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
echo "*/1 * * * * $dir/app/cron/1.sh 01 >> $dir/data/cron.log 2>&1" > /var/spool/cron/crontabs/root
echo "*/5 * * * * $dir/app/cron/1.sh 05 >> $dir/data/cron.log 2>&1" >> /var/spool/cron/crontabs/root
echo "*/10 * * * * $dir/app/cron/1.sh 10 >> $dir/data/cron.log 2>&1" >> /var/spool/cron/crontabs/root
echo "*/15 * * * * $dir/app/cron/1.sh 15 >> $dir/data/cron.log 2>&1" >> /var/spool/cron/crontabs/root
echo "*/20 * * * * $dir/app/cron/1.sh 20 >> $dir/data/cron.log 2>&1" >> /var/spool/cron/crontabs/root
echo "*/30 * * * * $dir/app/cron/1.sh 30 >> $dir/data/cron.log 2>&1" >> /var/spool/cron/crontabs/root
echo "*/60 * * * * $dir/app/cron/1.sh 60 >> $dir/data/cron.log 2>&1" >> /var/spool/cron/crontabs/root
echo "@reboot $dir/app/cron/reboot.sh" >> /var/spool/cron/crontabs/root
chmod 600 /var/spool/cron/crontabs/root

