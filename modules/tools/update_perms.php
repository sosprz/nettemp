<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
//echo "Nettemp dir: ".$ROOT."\n";
shell_exec("sudo chown -R root.www-data $ROOT");
shell_exec("sudo chmod -R 775 $ROOT");
shell_exec("sudo umask 0000 $ROOT");
shell_exec("sudo chmod g+s -R $ROOT/tmp");
shell_exec("sudo chmod g+s -R $ROOT/db");
shell_exec("sudo chmod g+s -R $ROOT/dbf");
shell_exec("sudo chmod a+w -R /var/spool/sms/outgoing");
shell_exec("sudo chmod -R 644 /var/log/smstools/smsd.log");
shell_exec("sudo gpasswd -a www-data dialout 1>/dev/null");

?>
