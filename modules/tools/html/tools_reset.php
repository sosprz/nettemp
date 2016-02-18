<div class="panel panel-default">
<div class="panel-heading">Reset system to default</div>
<div class="panel-body">
<?php
$dir=$_SERVER['DOCUMENT_ROOT'];
$admin_db_reset = isset($_POST['admin_db_reset']) ? $_POST['admin_db_reset'] : '';
if ($admin_db_reset == "admin_db_reset1") { 
shell_exec("$dir/modules/tools/db_reset git");
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