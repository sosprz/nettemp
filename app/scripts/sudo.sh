#! /bin/bash

declare -a arr=("/sbin/reboot"
                "/var/www/nettemp/app/scripts/1w.sh"
                "/var/www/nettemp/app/scripts/1w.sh on" 
                "/var/www/nettemp/app/scripts/1w.sh off"
               )

for i in "${arr[@]}"
    do
     if ! sudo cat /etc/sudoers |grep "$i" > /dev/null
    then 
      #sudo sed -i '$a www-data ALL=(ALL) NOPASSWD: \"$i\" ' /etc/sudoers 
      echo "www-data ALL=(ALL) NOPASSWD: $i" >> /etc/sudoers 
    fi
done