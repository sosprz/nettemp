<?php
include('conf.php');

if ($_POST['perms'] == "perms") { 
shell_exec("sudo chgrp -R www-data $global_dir");
shell_exec("sudo chmod -R 775 $global_dir");
$dir=getcwd();
exec("echo  '<?php \$global_dir='\'$dir\'';?>'  > conf.php");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="index.php?id=tools&type=file_check" method="post">
<input type="hidden" name="perms" value="perms">
<input  type="submit" value="Set good permissions"  />
</form>
