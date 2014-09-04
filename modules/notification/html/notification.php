<?php
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
?>
<div id="left">
	<?php include("modules/notification/html/notification_settings.php"); ?>
	<?php include("modules/alarms/html/alarms_settings.php"); ?>
	<?php //include("modules/mail/html/mail.php"); ?>
	<?php //include("modules/sms/html/sms.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
