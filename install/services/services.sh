#! /bin/bash

{
/etc/init.d/ntp restart
/etc/init.d/php7.0-fpm restart
/etc/init.d/lighttpd restart

update-rc.d smstools enable

sudo systemctl stop mosquitto
sudo update-rc.d mosquitto remove
sudo rm /etc/init.d/mosquitto

cp $dir/install/services/mosquitto.service /etc/systemd/system/
systemctl daemon-reload
systemctl enable mosquitto
systemctl start mosquitto.service

sudo systemctl stop nettempmqtt
cp $dir/install/services/nettempmqtt.service /etc/systemd/system/
systemctl daemon-reload
systemctl enable nettempmqtt
systemctl start nettempmqtt





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


