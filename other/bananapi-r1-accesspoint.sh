#! /bin/bash

apt-get update
apt-get -y install git build-essential fakeroot devscripts debhelper libnl-dev libssl-dev dnsmasq

git clone https://github.com/jekader/hostapd-rtl.git
cd hostapd-rtl
bash build.sh
dpkg -i ../hostapd-rtl_2.4-4_armhf.deb

cp -v /etc/network/interfaces /etc/network/interfaces.old


echo source-directory /etc/network/interfaces.d > /etc/network/interfaces
echo auto lo >> /etc/network/interfaces
echo iface lo inet loopback >> /etc/network/interfaces
echo " ">> /etc/network/interfaces
echo iface eth0 inet manual >> /etc/network/interfaces
echo " " >> /etc/network/interfaces
echo allow-hotplug wlan0 >> /etc/network/interfaces
echo iface wlan0 inet static >> /etc/network/interfaces
echo address 192.168.0.1 >> /etc/network/interfaces
echo netmask 255.255.255.0 >> /etc/network/interfaces
echo " " >> /etc/network/interfaces



sed -i 's/wpa_passphrase=ICanHasBananaz/wpa_passphrase=q1w2e3r4t5y6u/g' /etc/hostapd/hostapd.conf
sed -i 's/ssid=BPI-R1/ssid=nettemp/g' /etc/hostapd/hostapd.conf

sed -i 's/#DAEMON_CONF="\/etc\/hostapd\/hostapd.conf"/DAEMON_CONF="\/etc\/hostapd\/hostapd.conf"/g' /etc/default/hostapd

sed -i '$ainterface=wlan0' /etc/dnsmasq.conf
sed -i '$adhcp-range=192.168.0.1,192.168.0.250,255.255.255.0,1h' /etc/dnsmasq.conf 

sysctl -w net.ipv4.ip_forward=1
sed -i -e '$anet.ipv4.ip_forward=1\' /etc/sysctl.conf

service hostapd restart
service dnsmasq restart



