<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
shell_exec("sudo chown -R root.www-data $ROOT");
shell_exec("cd $ROOT && git reset --hard && cd -");

shell_exec("sudo rm -rf $ROOT/dbf/*.db");
shell_exec("sudo rm -rf $ROOT/tmp");
shell_exec("sudo mkdir $ROOT/tmp");

shell_exec("sqlite3 -cmd '.timeout 2000' $ROOT/dbf/nettemp.db < $ROOT/modules/tools/nettemp.schema");
shell_exec("sudo chmod 775 $ROOT/dbf/nettemp.db");
shell_exec("sudo chown root.www-data $ROOT/dbf/nettemp.db");
shell_exec("$ROOT/modules/tools/update_su");
shell_exec("$ROOT/modules/tools/update_fi");
include("$ROOT/modules/tools/update_perms.php");
include("$ROOT/modules/tools/update_db.php");

?>

















