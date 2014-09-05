#! /bin/ash

# version 5

opkg update
opkg install lighttpd php5-cgi php5-mod-pdo-sqlite php5-mod-sqlite3 rrdtool sqlite3-cli msmtp digitemp digitemp-usb git mc sysstat  bc htop snmp-utils perl nano lighttpd-mod-auth lighttpd-mod-rewrite lighttpd-mod-fastcgi lighttpd-mod-cgi php5-mod-session bash openvpn iptables digitemp-usb usbutils

/etc/init.d/uhttpd stop
/etc/init.d/uhttpd disable
/etc/init.d/lighttpd enable

cd /www/
git clone -b beta --recursive git://github.com/sosprz/nettemp
echo  "<?php \$global_dir='/www/nettemp/';?>"  > /www/nettemp/conf.php
/www/nettemp/modules/reset/reset

sed -i 's/doc_root = "\/www"/doc_root = "\/www\/nettemp"/g' /etc/php.ini
#sed -i 's/;extension=pdo_sqlite.so/extension=pdo_sqlite.so/g' /etc/php.ini
sed -i 's/;extension=sqlite3.so/extension=sqlite3.so/g' /etc/php.ini
#sed -i 's/;extension=sqlite.so/extension=sqlite.so/g' /etc/php.ini
sed -i 's/display_errors = On/display_errors = Off/g' /etc/php.ini
sed -i 's/;extension=session.so/extension=session.so/g' /etc/php.ini
sed -i 's/output_buffering = Off/output_buffering = On/g' /etc/php.ini

sed -i 's/server.document-root = "\/www\/"/server.document-root = "\/www\/nettemp\/"/g' /etc/lighttpd/lighttpd.conf
sed -i '1i\server.modules = ( "mod_rewrite", "mod_cgi" )'  /etc/lighttpd/lighttpd.conf 
sed -i 's/index.html/index.php/g' /etc/lighttpd/lighttpd.conf 
echo "cgi.assign = ( \".php\" => \"/usr/bin/php-cgi\" )" >> /etc/lighttpd/lighttpd.conf 
echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf 
sed -i 's/#server.groupname = "nobody"/server.groupname = "www-data"/g' /etc/lighttpd/lighttpd.conf 


opkg install kmod-usb-serial kmod-usb-serial-ch341 kmod-usb-serial-ftdi kmod-usb-serial-pl2303
opkg install kmod-w1-master-ds2490 kmod-w1-slave-therm

echo "*/1 * * * * /www/nettemp/modules/sensors/temp_dev_read && /www/nettemp/modules/view/view_gen && /www/nettemp/modules/highcharts/highcharts" > /etc/crontabs/root
#echo "*/1 * * * * /www/nettemp/modules/gpio/gpio2 check" >> /etc/crontabs/root
#echo "*/5 * * * * /www/nettemp/modules/sms/sms_send" >> /etc/crontabs/root
echo "*/5 * * * * /www/nettemp/modules/mail/mail_send" >> /etc/crontabs/root
sed -i '$a @reboot     echo "$(date +\\%y\\%m\\%d-\\%H\\%M) RPI rebooted" >> /www/nettemp/tmp/log.txt' /etc/crontabs/root
sed -i '$a @reboot  /www/nettemp/modules/tools/restart' /etc/crontabs/root
sed -i '$a*/1 * * * * /www/nettemp/modules/tools/system_stats' /etc/crontabs/root



#openwrt git bug https://dev.openwrt.org/ticket/11930
ln -s $(which git) /usr/libexec/git-core/git

opkg install sudo 
sed -i '$a www-data ALL=(ALL) NOPASSWD: /bin/chmod *, /bin/chgrp *, /sbin/reboot' /etc/sudoers 
chmod -R 775 /www/nettemp
chown -R root.www-data /www/nettemp
/etc/init.d/lighttpd restart

