<?php
$perms = isset($_POST['perms']) ? $_POST['perms'] : '';
if ($perms == "perms") { 
$dir=getcwd();
shell_exec("sudo chown -R root.www-data $dir");
shell_exec("sudo chmod -R 775 $dir");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="" method="post">
<input type="hidden" name="perms" value="perms">
<input  type="submit" value="Fix"  />
</form>
