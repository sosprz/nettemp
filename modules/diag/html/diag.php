<?php

session_start();
	   include('include/login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" )) {?> 



<?php include("modules/diag/html/diag_db_show.php"); ?>
<?php include("modules/diag/html/diag_reset.php"); ?>
<?php include("modules/diag/html/diag_file_check.php"); ?>
<?php include("modules/diag/html/diag_device.php"); ?>




<?php
 }
else { 
  	  header("Location: diened");
    }; 

