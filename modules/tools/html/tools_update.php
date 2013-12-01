<span class="belka">&nbsp Update<span class="okno">
<?php



if ($_POST['update'] == "Update") { 
putenv('PATH='. getenv('PATH') .':var/www/nettemp');
passthru('git pull 2>&1');
//header("location: " . $_SERVER['REQUEST_URI']);
//	exit();	
	}
	?>
	<form action="tools" method="post">
	  <input type="hidden" name="update" value="Update">
     <input  type="submit" value="Update"  />
     </form>   

     </span></span>