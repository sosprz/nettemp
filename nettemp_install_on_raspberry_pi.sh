#/bin/bash 
# nettemp rpi installer
# nettemp.pl
# 


echo "update distro"
apt-get update
apt-get upgrade

echo "install git-core"
apt-get -y install git-core

echo "install packages"
apt-get -y install lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp


echo "enable module: fastcgi-php"
lighty-enable-mod fastcgi-php

echo "changing lighthttpd conf"
sed -i -e 's/#       "mod_rewrite",/       "mod_rewrite",/g'  /etc/lighttpd/lighttpd.conf
sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g'  /etc/lighttpd/lighttpd.conf	
echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf


echo "downloading nettemp source"
cd /var/www
git clone https://github.com/sosprz/nettemp

echo "permisions"
chown -R root.www-data /var/www/nettemp
chmod -R 775 /var/www/nettemp
gpasswd -a www-data dialout

echo "add cron"
echo "*/10 * * * * /var/www/nettemp/scripts/temp" >> /var/spool/cron/crontabs/root
echo "1 * * * * /var/www/nettemp/scripts/mail" >> /var/spool/cron/crontabs/root
echo "1 * * * * /var/www/nettemp/scripts/sms" >> /var/spool/cron/crontabs/root

update-rc.d ntp enable
service ntp start

update-rc.d lighttpd enable
service lighttpd start

update-rc.d cron enable
service cron start

