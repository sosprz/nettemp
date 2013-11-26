<span class="belka">&nbsp Update<span class="okno">
<?php



if ($_POST['update'] == "update") { 
putenv('PATH='. getenv('PATH') .':var/www/nettemp');
passthru('git pull 2>&1');
//header("location: " . $_SERVER['REQUEST_URI']);
//	exit();	
	}
	?>
	<form action="tools" method="post">
	  <input type="hidden" name="update" value="update">
     <input  type="submit" value="update"  />
     </form>   

     </span></span>