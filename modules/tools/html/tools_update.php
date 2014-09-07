<span class="belka">&nbsp Update<span class="okno">
<?php
if ($_POST['update'] == "Update") { 
//putenv('PATH='. getenv('PATH') .':var/www/nettemp');


copy('conf.php', 'conf.php.bak');
passthru("/usr/bin/git pull 2>&1");
copy('conf.php.bak', 'conf.php');
exec('modules/reset/update_db');


//header("location: " . $_SERVER['REQUEST_URI']);
//	exit();	
	}
	?>
	<form action="index.php?id=tools&type=update" method="post">
	  <input type="hidden" name="update" value="Update">
     <input  type="submit" value="Update"  />
     </form>   

     </span></span>