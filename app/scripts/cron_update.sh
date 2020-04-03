#! /bin/bash

mkdir -p /var/spool/cron/crontabs
if [ ! -e /var/spool/cron/crontabs/root ]; then
    touch /var/spool/cron/crontabs/root
    chmod 600 /var/spool/cron/crontabs/root
fi


sed -i '/nettemp/d' /var/spool/cron/crontabs/root
dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )
echo "*/1 * * * * $dir/app/cron/1.sh 01" > /var/spool/cron/crontabs/root
echo "*/5 * * * * $dir/app/cron/1.sh 05" >> /var/spool/cron/crontabs/root
echo "*/10 * * * * $dir/app/cron/1.sh 10" >> /var/spool/cron/crontabs/root
echo "*/15 * * * * $dir/app/cron/1.sh 15" >> /var/spool/cron/crontabs/root
echo "*/20 * * * * $dir/app/cron/1.sh 20" >> /var/spool/cron/crontabs/root
echo "*/30 * * * * $dir/app/cron/1.sh 30" >> /var/spool/cron/crontabs/root
echo "*/60 * * * * $dir/app/cron/1.sh 60" >> /var/spool/cron/crontabs/root
echo "@reboot $dir/app/cron/reboot.sh" >> /var/spool/cron/crontabs/root
chmod 600 /var/spool/cron/crontabs/root

