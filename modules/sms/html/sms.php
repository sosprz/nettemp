<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
		
		?>
<div id="left">
	<?php include("sms_settings.php"); ?>
	<?php include("sms_scan.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
