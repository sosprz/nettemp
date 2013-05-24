<?php

session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" )) {?> 



<?php include("tools_reset.php"); ?>




<?php
 }
else { 
  	  header("Location: diened");
    }; 

