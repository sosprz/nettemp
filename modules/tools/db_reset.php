<?php
$dir=dirname(dirname(dirname(__FILE__)));
shell_exec("sudo chown -R root.www-data $dir");
shell_exec("cd $dir && git reset --hard && cd -");

shell_exec("sudo rm -rf $dir/dbf/*.db");
shell_exec("sudo rm -rf $dir/tmp");
shell_exec("sudo mkdir $dir/tmp");

shell_exec("sqlite3 -cmd '.timeout 2000' $dir/dbf/nettemp.db < $dir/modules/tools/nettemp.schema");
shell_exec("sudo chmod 775 $dir/dbf/nettemp.db");
shell_exec("sudo chown root.www-data $dir/dbf/nettemp.db");

include("$dir/modules/tools/update_perms.php");
include("$dir/modules/tools/html/update_db.php");

?>

















