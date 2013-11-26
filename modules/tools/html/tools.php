
<?php

session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" )) {?> 



<?php include("tools_update.php"); ?> 
<?php include("tools_change_pass.php"); ?> 
<?php include("tools_reset.php"); ?> 
<?php include("tools_log.php"); ?>

<?php
 }
else { 
  	  header("Location: diened");
    }; 

