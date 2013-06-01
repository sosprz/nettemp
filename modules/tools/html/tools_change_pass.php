<?php

session_start();
	   include('modules/login//login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" || $perms == "ops")) {?>

<span class="belka">&nbsp Change password <span class="okno">
<?php
$user_logged=$_SESSION["logged"];
	$pass=sha1($_POST["pas1"]);
   $pass2=sha1($_POST["pas2"]);
   
   
if (!empty($user_logged)) {

if ($_POST['login_change'] == "login_change1") { 
		if ($pass == $pass2) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET password='$pass' WHERE login='$user_logged' ");
	}	else { echo "Password not match"; }
	}
	?>
	<form action="tools" method="post">
	  <input type="hidden" name="login_change" value="login_change1">
	  <table> 
     <tr><td>Password :</td><td><input type="password"  name="pas1" size="8"/></td></tr>
	  <tr><td>Repeat:</td><td><input type="password"  name="pas2" size="8"/></td></tr>		
	  </table>     
     <input  type="submit" value="Change"  />
     </form>   
     <?php 
     }
     else { echo "Not logged"; }
     ?>
     </span></span>




<?php
 }
else { 
  	  header("Location: diened");
    }; 
