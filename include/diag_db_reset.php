<span class="belka">&nbsp Database reset: <span class="okno">
<?php



if ($_POST['admin_db_reset'] == "admin_db_reset1") { 
system ("cd scripts && sh db_reset");
header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
	}
	?>
	<form action="diag" method="post">
	  <input type="hidden" name="admin_db_reset" value="admin_db_reset1">
     <input  type="submit" value="Base Reset"  />
     </form>   

     </span></span>