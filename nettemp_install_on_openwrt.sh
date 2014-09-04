#! /bin/ash

# version 3

opkg update
opkg install lighttpd php5-cgi php5-mod-pdo-sqlite php5-mod-sqlite3 rrdtool sqlite3-cli msmtp digitemp digitemp-usb git mc sysstat  bc htop snmp-utils perl nano lighttpd-mod-auth lighttpd-mod-rewrite lighttpd-mod-fastcgi lighttpd-mod-cgi php5-mod-session bash openvpn iptables ca-certificates digitemp-usb usbutils

/etc/init.d/uhttpd stop
/etc/init.d/uhttpd disable
/etc/init.d/lighttpd start
/etc/init.d/lighttpd enable

cd /www/
git clone -b beta --recursive git://github.com/sosprz/nettemp
echo  "<?php \$global_dir='/www/nettemp/';?>"  > /www/nettemp/conf.php
/www/nettemp/modules/reset/reset

sed -i 's/doc_root = "\/www"/doc_root = "\/www\/nettemp\/"/g' /etc/php.ini
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

/etc/init.d/lighttpd restart

opkg install kmod-usb-serial kmod-usb-serial-ch341 kmod-usb-serial-ftdi kmod-usb-serial-pl2303
opkg install kmod-w1-master-ds2490 kmod-w1-slave-therm

echo "*/1 * * * * /www/nettemp/modules/sensors/temp_dev_read && /www/nettemp/modules/view/view_gen && /www/nettemp/modules/highcharts/highcharts" > /etc/crontabs/root

chmod -R 777 /www/nettemp



























