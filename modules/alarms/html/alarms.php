<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
?>		

<div id="left">
	 <?php include("modules/alarms/html/alarms_settings.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
