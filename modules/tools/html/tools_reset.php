<div class="panel panel-default">
<div class="panel-heading">Reset system to default</div>
<div class="panel-body">
<?php
$admin_db_reset = isset($_POST['admin_db_reset']) ? $_POST['admin_db_reset'] : '';

if ($admin_db_reset == "admin_db_reset1") { 
	include("modules/tools/db_reset.php");
	include("modules/tools/html/update_db.php");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}

?>
<form action="" method="post">
	<input type="hidden" name="admin_db_reset" value="admin_db_reset1">
	<input  type="submit" value="Reset" class="btn btn-xs btn-danger" />
</form>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">Remove all sensors</div>
<div class="panel-body">
<?php
$admin_sensors_reset = isset($_POST['admin_sensors_reset']) ? $_POST['admin_sensors_reset'] : '';

if ($admin_sensors_reset == "admin_sensors_reset") { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM sensors");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}
?>

<form action="" method="post">
	<input type="hidden" name="admin_sensors_reset" value="admin_sensors_reset">
	<input  type="submit" value="Remove all sensors" class="btn btn-xs btn-danger" />
</form>
</div>
</div>

