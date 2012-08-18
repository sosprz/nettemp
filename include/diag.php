<?php

session_start();
	   include('include/login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" )) {?> 



<?php include("include/diag_db_show.php"); ?>
<?php include("include/diag_db_reset.php"); ?>
<?php include("include/diag_file_check.php"); ?>
<?php include("include/diag_device.php"); ?>




<?php
 }
else { 
  	  header("Location: diened");
    }; 

