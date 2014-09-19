<?php

session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" || $perms == "ops")) {?>
		
		
		
<span class="belka">&nbsp Enable/Disable WWW password <span class="okno">

<?php
if ($_POST['disable'] == "disable") { 
shell_exec ("sudo lighttpd-disable-mod auth");
shell_exec ("sudo service lighttpd reload");
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['enable'] == "enable") { 
shell_exec ("sudo lighttpd-enable-mod auth");
shell_exec ("sudo service lighttpd reload");
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

?>
<?php
    if (!file_exists("/etc/lighttpd/conf-enabled/05-auth.conf")) {
	echo "Status: disabled"; ?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="enable" value="enable">
<input  type="submit" value="Enable"  />
</form>
<?php 
    }
    else {
	echo "Status: enabled"; ?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="disable" value="disable">
<input  type="submit" value="Disable"  />
</form>
<?php
    }
?>
</span></span>

<span class="belka">&nbsp Change password <span class="okno">
<?php
    $pass=($_POST["pass"]);
    $pass2=($_POST["pass2"]);


if ($_POST['chg'] == "chg2") { 
	if ($pass == $pass2) {
	    $filename = "/etc/lighttpd/.lighttpdpassword";
	    $output = "admin:$pass\n";
	    $filehandle = fopen($filename, 'w');
	    fwrite($filehandle, $output);
	    fclose($filehandle);
	    //shell_exec("sudo service lighttpd reload");
	}	
	else { echo "Password not match"; }
	}
	?>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	  <table> 
	    <input type="hidden"  name="chg" value="chg2"/></td></tr>
     <tr><td>Password :</td><td><input type="password"  name="pass" size="8"/></td></tr>		
	  <tr><td>Repeat:</td><td><input type="password"  name="pass2" size="8"/></td></tr>		
	  </table>     
     <input  type="submit" value="Change"  />
     </form>   
</span></span>



<?php
 }
else { 
  	  header("Location: denied");
    }; 
