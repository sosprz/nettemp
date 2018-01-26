#! /bin/bash

{
#check other www server
if dpkg --get-selections | grep apache; then
service apache2 stop
update-rc.d apache2 disable
echo -e "[ ${GREEN}ok${R} ] Looks like You have Apache, service was stoped, until reboot."
fi

# enable fastcgi
lighty-enable-mod fastcgi-php 1>/dev/null
# enable modrewrite
lighty-enable-mod rewrite 1>/dev/null

# www dir
sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g' /etc/lighttpd/lighttpd.conf
sed -i -e 's/server.document-root        = \"\/var\/www\/html"/server.document-root        = \"\/var\/www\/nettemp\"/g' /etc/lighttpd/lighttpd.conf
# didable dir access
sed -i '/url.access-deny/d' /etc/lighttpd/lighttpd.conf
sed -i '$a url.access-deny = ( "~", ".inc", ".dbf", ".db", ".txt", ".rrd" )' /etc/lighttpd/lighttpd.conf
sed -i '$a $HTTP["url"] =~ "^/modules"  { url.access-deny = ("") }' /etc/lighttpd/lighttpd.conf
# set url rewrite
if ! cat /etc/lighttpd/lighttpd.conf |grep -q url.rewrite-once; then
    echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf
fi
# htaccess
if ! cat /etc/lighttpd/lighttpd.conf |grep -q Password; then
sed -i '$aauth.debug = 2' /etc/lighttpd/lighttpd.conf
sed -i '$aauth.backend = "plain"' /etc/lighttpd/lighttpd.conf
sed -i '$aauth.backend.plain.userfile = "/etc/lighttpd/.lighttpdpassword"' /etc/lighttpd/lighttpd.conf
sed -i '$aauth.require = ( "/" =>' /etc/lighttpd/lighttpd.conf
sed -i '$a(' /etc/lighttpd/lighttpd.conf
sed -i '$a"method" => "basic",' /etc/lighttpd/lighttpd.conf
sed -i '$a"realm" => "Password protected area",' /etc/lighttpd/lighttpd.conf
sed -i '$a"require" => "user=admin"' /etc/lighttpd/lighttpd.conf
sed -i '$a)' /etc/lighttpd/lighttpd.conf
sed -i '$a)' /etc/lighttpd/lighttpd.conf
sed -i '$a www-data ALL=(ALL) NOPASSWD: /usr/sbin/lighttpd-enable-mod *, /usr/sbin/lighttpd-disable-mod *' /etc/sudoers
touch /etc/lighttpd/.lighttpdpassword
chown www-data:www-data /etc/lighttpd/.lighttpdpassword
echo "admin:admin" > /etc/lighttpd/.lighttpdpassword
lighttpd-enable-mod auth
fi
# php.ini upload file max size
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 1024M/g' /etc/php/7.0/cgi/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 1024M/g' /etc/php/7.0/cgi/php.ini
sed -i 's/upload_max_filesize =.*/upload_max_filesize = 1024M/g'  /etc/php/7.0/fpm/php.ini
sed -i 's/post_max_size =.*/post_max_size = 1024M/g'  /etc/php/7.0/fpm/php.ini


#PHP5-FPM
mv /etc/lighttpd/conf-available/15-fastcgi-php.conf /etc/lighttpd/conf-available/15-fastcgi-php.conf.old
cp $dir/install/www/15-fastcgi-php.conf /etc/lighttpd/conf-available/
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 1024M/g' /etc/php/7.0/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 1024M/g' /etc/php5/fpm/php.ini
sed -i 's/;sendmail_path =/sendmail_path = '\''\/usr\/bin\/msmtp -t'\''/g' /etc/php/7.0/fpm/php.ini
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] WWW"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] WWW"
fi



