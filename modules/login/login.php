<?php
$inactive = 180;
if (isset($_SESSION["timeout"])) {
       $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
       }
}
$_SESSION["timeout"] = time();
?>
 
<?php
$form_logout = isset($_POST['form_logout']) ? $_POST['form_logout'] : '';

if ($form_logout == 'log') { session_destroy(); header("location: ".$_SERVER['PHP_SELF']);}

$form_login = isset($_POST['form_login']) ? $_POST['form_login'] : '';
if ($form_login == "log") { /// do after login form is submitted  
	$user=$_POST["username"];
	$pass=sha1($_POST["password"]);
	$db = new PDO('sqlite:dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM users WHERE login='$user' AND password='$pass' ");
	$row = $rows->fetchAll();
   $numRows = count($row);
     if ($numRows == 1) { $_SESSION["logged"]=$_POST["username"];    
     session_regenerate_id();
     } 
     else {echo 'Wrong login or password, try again.';}; 
	}; 

	include("login_check.php");
	if ($numRows1 == 1) { 	?>
	<span class="login">	
	<form action="index.php" method="post">
	<input type="hidden" name="form_logout" value="log"> 
	<?php echo $logged; ?>
  <input type="image" src="media/ico/Lock-icon.png" type="submit" value="Logout" />
	</form> 	
	</span>
	<?php	 
	}
	  else { ?>
	  <span class="login">
	  <form action="index.php" method="post">
	  <input type="hidden" name="form_login" value="log">  
     Username: <input type="text" name="username" size="8"/><br>
     Password: <input type="password" name="password" size="8"/><br>
     <input type="image" src="media/ico/Unlock-icon.png" type="submit" value="Login" />
     </form>
     </span>
	<?php	}; 
?>
