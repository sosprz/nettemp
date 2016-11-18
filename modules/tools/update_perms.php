<?php
//#! /bin/bash

//dir=$( cd "$( dirname "$0" )" && cd ../../ && pwd )

//sudo chown -R root.www-data $dir
//sudo chmod -R 775 $dir
//sudo chmod g+s -R $dir/tmp
//sudo chmod g+s -R $dir/tmp
//sudo chmod g+s -R $dir/dbf

//sudo chmod a+w -R /var/spool/sms/outgoing
//sudo chmod -R 644 /var/log/smstools/smsd.log

//sudo gpasswd -a www-data dialout 1>/dev/null

$dir=$_SERVER['DOCUMENT_ROOT'];
shell_exec("sudo chown -R root.www-data $dir");
shell_exec("sudo chmod -R 775 $dir");
shell_exec("sudo chmod g+s -R $dir/tmp");
shell_exec("sudo chmod g+s -R $dir/db");
shell_exec("sudo chmod g+s -R $dir/dbf");
shell_exec("sudo chmod a+w -R /var/spool/sms/outgoing");
shell_exec("sudo chmod -R 644 /var/log/smstools/smsd.log");
shell_exec("sudo gpasswd -a www-data dialout 1>/dev/null");

?>
