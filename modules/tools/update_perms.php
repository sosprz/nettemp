<?php
$dir=dirname(dirname(dirname(__FILE__)));
//echo "Nettemp dir: ".$dir."\n";
shell_exec("sudo chown -R root.www-data $dir");
shell_exec("sudo chmod -R 775 $dir");
shell_exec("sudo chmod g+s -R $dir/tmp");
shell_exec("sudo chmod g+s -R $dir/db");
shell_exec("sudo chmod g+s -R $dir/dbf");
shell_exec("sudo chmod a+w -R /var/spool/sms/outgoing");
shell_exec("sudo chmod -R 644 /var/log/smstools/smsd.log");
shell_exec("sudo gpasswd -a www-data dialout 1>/dev/null");

?>
