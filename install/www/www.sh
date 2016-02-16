#! /bin/bash

#check other www server
if dpkg --get-selections | grep apache; then
service apache2 stop
update-rc.d apache2 disable
echo -e "[ ${GREEN}ok${R} ] Looks like You have Apache, service was stoped, until reboot."
fi

# enable fastcgi
lighty-enable-mod fastcgi-php 1>/dev/null
# enable modrewrite
sed -i -e 's/#       "mod_rewrite",/ "mod_rewrite",/g' /etc/lighttpd/lighttpd.conf
# www dir
sed -i -e 's/server.document-root        = \"\/var\/www\"/server.document-root        = \"\/var\/www\/nettemp\"/g' /etc/lighttpd/lighttpd.conf
sed -i -e 's/server.document-root        = \"\/var\/www\/html"/server.document-root        = \"\/var\/www\/nettemp\"/g' /etc/lighttpd/lighttpd.conf
# didable dir access
sed -i '/url.access-deny/d' /etc/lighttpd/lighttpd.conf
sed -i '$a url.access-deny = ( "~", ".inc", ".dbf", ".db", ".txt", ".rrd" )' /etc/lighttpd/lighttpd.conf
sed -i '$a $HTTP["url"] =~ "^/modules"  { url.access-deny = ("") }' /etc/lighttpd/lighttpd.conf
# set url rewrite
if cat /etc/lighttpd/lighttpd.conf |grep url.rewrite-once 1> /dev/null; then
echo -e "[ ${GREEN}ok${R} ] lighttpd: Url rewrite exist"
else
echo "url.rewrite-once = ( \"^/([A-Za-z0-9-_-]+)\$\" => \"/index.php?id=\$1\" )" >> /etc/lighttpd/lighttpd.conf
fi
# htaccess
if cat /etc/lighttpd/lighttpd.conf |grep Password 1> /dev/null ; then
echo -e "[ ${GREEN}ok${R} ] lighttpd: Password already set"
else
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
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 300M/g' /etc/php5/cgi/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 300M/g' /etc/php5/cgi/php.ini

#PHP5-FPM
mv /etc/lighttpd/conf-available/15-fastcgi-php.conf /etc/lighttpd/conf-available/15-fastcgi-php.conf.old
cp $dir/install/www/15-fastcgi-php.conf /etc/lighttpd/conf-available/
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 300M/g' /etc/php5/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 300M/g' /etc/php5/fpm/php.ini


