<?php
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
?>
<div id="left">
	<?php include("modules/notification/html/notification_settings.php"); ?>
	<?php include("modules/notification/html/alarms_settings.php"); ?>
	<?php include("modules/notification/html/notification_other.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: denied");
    }; 
	 ?>
