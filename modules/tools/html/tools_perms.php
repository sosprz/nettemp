<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Perms repair</h3>
</div>
<div class="panel-body">
<?php

include('modules/tools/html/tools_file_check.php');

$perms = isset($_POST['perms']) ? $_POST['perms'] : '';
if ($perms == "perms") 
{ 
	$dir=getcwd();
	include('modules/tools/update_perms.php');
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}
?>
<form action="" method="post">
<input type="hidden" name="perms" value="perms">
<input  type="submit" value="Fix" class="btn btn-xs btn-success"  />
</form>

</div></div>
