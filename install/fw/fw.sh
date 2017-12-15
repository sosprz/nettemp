#! /bin/bash 

{
forward=$(cat /proc/sys/net/ipv4/ip_forward)
if [ $forward == "0" ]; then
echo "add IP forward"
sed -i -e '$anet.ipv4.ip_forward=1\' /etc/sysctl.conf
sysctl -p
fi
mkdir -p /etc/iptables
touch /etc/iptables/rules.v4
chgrp www-data /etc/iptables/rules.v4
chmod 664 /etc/iptables/rules.v4
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] FW"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] FW"
fi

