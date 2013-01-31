<div id="left">
<?php include("modules/view/html/view_del.php"); ?>
<?php
		session_start(); 
		include('include/login_check.php');

if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { include("include/view_create.php"); }; 
?>
<?php include("modules/view/html/view_select_sensors.php"); ?>
<?php include("modules/view/html/view_graph.php"); ?>
</DIV>
