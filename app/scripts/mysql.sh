#! /bin/bash

dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

rootpass=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
nettemppass=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
echo $rootpass > /root/mysql_pass

sed -i "s/random_secret_pass_mysql/$nettemppass/g" $dir/data/config.cfg
#echo -e "\n\$rootpass\$rootpass\n\n\n\n\n " | mysql_secure_installation 2>/dev/null

#mysql_secure_installation <<EOF
#n
#$rootpass
#$rootpass
#y
#y
#y
#y
#y
#EOF

mysql --user=root <<_EOF_
 CREATE DATABASE nettemp; 
 CREATE USER 'nettemp'@'localhost' IDENTIFIED BY '$nettemppass'; 
 GRANT ALL PRIVILEGES ON nettemp.* TO 'nettemp'@'localhost'; 
 FLUSH PRIVILEGES;
_EOF_

systemctl enable mariadb
systemctl restart mariadb

source venv/bin/activate
python3 app/scripts/db_schema.py
python3 app/scripts/db_update.py
python3 app/scripts/set_admin.py
deactivate


