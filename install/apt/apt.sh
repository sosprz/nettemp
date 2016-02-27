#! /bin/bash

echo "Please wait installing packages"
{
package="lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu git-core mc sysstat \
    sharutils bc htop snmp sudo ntp watchdog python-smbus i2c-tools openvpn iptables rcconf \
    arp-scan snmpd httping fping make gcc lynx expect socat build-essential python-dev figlet \
    libmodbus5 netfilter-persistent php5-fpm apcupsd"

apt-get -y update
apt-get -y install $package
} >> $dir/install_log.txt 2>&1

for i in $package; do
    dpkg-query -W -f='${Status}' $i 
    if [[ $? = 1 ]]; then
    echo no package $i >> $dir/install_log.txt 2>&1
    exit 1
    fi
done


exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] packages"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] packages"
fi


