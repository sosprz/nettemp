#! /bin/bash

sed -i 's|UPSCABLE smart|UPSCABLE usb|g' /etc/apcupsd/apcupsd.conf
sed -i 's|UPSTYPE apcsmart|UPSTYPE usb|g' /etc/apcupsd/apcupsd.conf
sed -i 's|DEVICE /dev/ttyS0|DEVICE|g' /etc/apcupsd/apcupsd.conf
sed -i 's|ISCONFIGURED=no|ISCONFIGURED=yes|g' /etc/default/apcupsd
sed -i '/exit 0/i /bin/bash $dir/modules/ups/onbattery on' /etc/apcupsd/onbattery 
sed -i '/exit 0/i /bin/bash $dir/modules/ups/onbattery off' /etc/apcupsd/offbattery 

