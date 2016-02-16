#! /bin/bash

package="lighttpd php5-cgi php5-sqlite rrdtool sqlite3 msmtp digitemp gammu git-core mc sysstat \
    sharutils bc htop snmp sudo ntp watchdog python-smbus i2c-tools openvpn iptables rcconf \
    arp-scan snmpd httping fping make gcc lynx expect socat build-essential python-dev figlet \
    libmodbus5 netfilter-persistent php5-fpm apcupsd"

apt-get -y update
apt-get -y install $package
