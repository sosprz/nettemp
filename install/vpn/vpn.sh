#!/bin/bash 


if [[ $OVCA == 'yes' ]]; then
    echo "Please wait certificate generating......."
fi

{
#INSTALL
if [ $USER != 'root' ]; then
    echo "Sorry, you need to run this as root"
    exit
fi

if [[ $OVCA == 'yes' ]]; then
    $dir/install/vpn/ca
fi

#CREATE openvpn.conf
cat <<EOT > /etc/openvpn/openvpn.conf
port 1194
proto udp
dev tun
ca ca.crt
cert server.crt
key server.key 
dh dh2048.pem
server 10.8.0.0 255.255.255.0
ifconfig-pool-persist ipp.txt
push "route $(ifconfig eth0 |grep -m 1 inet |awk -F":" '{print $2 $4}' | sed 's/Bcast/ /g' | awk -F '.' '{printf("%d.%d.%d.%d", $1, $2, $3, 0)} {print " "255"."$5"."$6"."$7}')"
keepalive 10 120
comp-lzo
persist-key
persist-tun
status openvpn-status.log
log-append /var/log/openvpn.log
verb 3
#plugin /usr/lib/openvpn/openvpn-auth-pam.so login
plugin /usr/lib/openvpn/openvpn-plugin-auth-pam.so login
client-cert-not-required
username-as-common-name
EOT

#FORWARD
forward=$(cat /proc/sys/net/ipv4/ip_forward)
if [ $forward == "0" ]; then
echo "add IP forward"
sed -i -e '$anet.ipv4.ip_forward=1\' /etc/sysctl.conf
sysctl -p
else 
echo "Forward exist"
fi
#IPTABLES
if iptables -L -t nat | grep '10.8.0.0/24' 1>/dev/null; then 
echo "Nat exist"
else
echo "Add NAT"
iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -j MASQUERADE
iptables-save > /etc/network/iptables
fi
} >> $dir/install_log.txt 2>&1

exitstatus=$?
if [ $exitstatus = 1 ]; then
    echo -e "[ ${RED}error${R} ] VPN"
    exit 1
else 
    echo -e "[ ${GREEN}ok${R} ] VPN"
fi








