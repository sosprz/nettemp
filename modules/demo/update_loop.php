<?php

$loop=1000;
for ($x = 0; $x <= $loop; $x++) {
	passthru("cd /var/www/nettemp && git reset --hard");
    passthru("/usr/bin/git pull 2>&1");
	shell_exec("php-cgi /var/www/nettemp/modules/tools/update_db.php");
}

?>
