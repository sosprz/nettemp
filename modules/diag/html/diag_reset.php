<span class="belka">&nbsp Reset to default: <span class="okno">
<?php



if ($_POST['admin_db_reset'] == "admin_db_reset1") { 
system ("cd modules/reset && sh reset");
header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
	}
	?>
	<form action="diag" method="post">
	  <input type="hidden" name="admin_db_reset" value="admin_db_reset1">
     <input  type="submit" value="Reset"  />
     </form>   

     </span></span>