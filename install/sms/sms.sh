#! /bin/bash 

mkdir -p /var/spool/sms/outgoing
mkdir -p /var/spool/sms/checked
mkdir -p /var/spool/sms/failed
mkdir -p /var/spool/sms/incoming
mkdir -p /var/spool/sms/report
mkdir -p /var/spool/sms/sent

chmod 775 /var/spool/sms/outgoing
chmod 775 /var/spool/sms/incoming

