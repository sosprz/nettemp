#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

sudo openssl req -x509  -subj "/C=PL/ST=Pomorskie/L=Gdansk/O=IT/CN=my.nettemp.pl"  -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt
#sudo openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048

cp $dir/etc/nginx/self-signed.conf /etc/nginx/snippets/
cp $dir/etc/nginx/ssl-params.conf /etc/nginx/snippets/
cp $dir/etc/nginx/nettemp /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/nettemp /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default

systemctl restart nginx
