#! /bin/bash

# APT
echo -n -e "Updating repo \r"
apt -y update 
echo -n -e "Instaling packages \r"
apt -y install sqlite3 git-core mc htop sudo i2c-tools lm-sensors nginx python3-pip python3-venv acl mariadb-server libmariadb-dev libgpiod2 mycli


# PERMS
echo -n -e "PERMS \r"
app/scripts/perms.sh

# VENV
echo -n -e "VENV \r"
app/scripts/venv.sh

# drivers
echo -n -e "DRIVERS \r"
app/scripts/drivers.sh

# CONFIG
echo -n -e "CONFIG \r"
app/scripts/config.sh

# MYSQL
app/scripts/mysql.sh

# NETTEMP
echo -n -e "Nettemp \r"
#mkdir -p $dir
#tar -xvf nettemp.tar -C $dir

# SUDO
echo -n -e "CRON \r"
app/scripts/sudo.sh

# CRON
echo -n -e "SUDO \r"
app/scripts/cron_update.sh

# NGINX
echo -n -e "NGINX \r"
app/scripts/nginx.sh


# DB
#echo -n -e "DB \r"
#app/scripts/db_reset.sh

# GUNICORN
echo -n -e "GUNICORN \r"
app/scripts/gunicorn.sh

# RPI I2C
echo -n -e "RPI \r"
app/scripts/rpi.sh

echo "[ nettemp ][ finish ]"
echo "##################################################"
echo " Your mysql root pasword is palaced in root dir"



