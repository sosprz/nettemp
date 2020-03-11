#! /bin/bash

dir=/var/www/nettemp

# APT
echo -n -e "Updating repo \r"
apt -y update 
echo -n -e "Instaling packages \r"
apt -y install sqlite3 git-core mc htop sudo i2c-tools lm-sensors nginx python3-pip python3-venv acl

# NETTEMP
echo -n -e "Nettemp \r"
#mkdir -p $dir
#tar -xvf nettemp.tar -C $dir

# PERMS
$dir/app/scripts/perms.sh


cp $dir/etc/config.cfg $dir/data/
x=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
x1=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
sed -i "s/\"random_secret_key_for_nettemp\"/\"$x\"/g" $dir/data/config.cfg
sed -i "s/\"random_secret_key_for_nettemp_jwt\"/\"$x1\"/g" $dir/data/config.cfg

# SUDO
$dir/etc/sudo.sh

# CRON
echo -n -e "Updating CRON \r"
mkdir -p /var/spool/cron/crontabs
if [ ! -e /var/spool/cron/crontabs/root ]; then
    touch /var/spool/cron/crontabs/root
    chmod 600 /var/spool/cron/crontabs/root
fi
    
if ! crontab -l |grep nettemp 1> /dev/null; then
    echo "*/1 * * * * $dir/app/cron/1.sh" > /var/spool/cron/crontabs/root
    echo "*/5 * * * * $dir/app/cron/5.sh" >> /var/spool/cron/crontabs/root
    echo "0 * * * * $dir/app/cron/1h.sh" >> /var/spool/cron/crontabs/root
    echo "@reboot $dir/app/cron/reboot.sh" >> /var/spool/cron/crontabs/root
#    echo "00 00 * * * $dir/app/cron/00h" >> /var/spool/cron/crontabs/root
    chmod 600 /var/spool/cron/crontabs/root
fi


# NGINX
cd $dir/etc/nginx
./setup.sh

# VENV
echo -n -e "Create venv - COPY PASTE \r"
cd $dir
python3 -m venv venv
source venv/bin/activate
pip install -r requirements.txt
pip install git+https://github.com/nicmcd/vcgencmd.git
deactivate

# DB
$dir/app/scripts/db_reset.sh

# GUNICORN
cp $dir/etc/gunicorn.service /etc/systemd/system/
systemctl enable --now gunicorn
systemctl daemon-reload
systemctl start gunicorn

# RPI I2C
if cat /proc/cpuinfo |grep Raspberry; then
  if cat /etc/modules |grep i2c-dev 1> /dev/null; then
    echo -e "[ ${GREEN}ok${R} ] i2c-dev allready added"
    else
    sed -i '$ai2c-dev' /etc/modules
    touch $dir/data/reboot
    fi

  if ! grep -q -E "^(device_tree_param|dtparam)=([^,]*,)*i2c(_arm)?=[^,]*" /boot/config.txt; then
    printf "dtparam=i2c_arm=on\n" >> /boot/config.txt
    touch $dir/data/reboot
  fi

fi



