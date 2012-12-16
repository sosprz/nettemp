<div id="left">
<?php include("include/delete_graph.php"); ?>
<?php
		session_start(); 
		include('include/login_check.php');

if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { include("include/view_create.php"); }; 
?>
<?php include("modules/view/html/view_graph.php"); ?>
</DIV>
