<?php
include('conf.php');
include('modules/login/login_check.php');
    if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
?>
    <div id="left">
<?php 
	include("gpio_settings.php");
	include("gpio_add.php"); 
	include("gpio_help.php");
?>
    </div>
<?php }
    else { 
          header("Location: diened");
    }; 
