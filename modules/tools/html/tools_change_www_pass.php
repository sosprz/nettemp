<?php

session_start();
	   include('modules/login//login_check.php');
		if ($numRows1 == 1 && ($perms == "adm" || $perms == "ops")) {?>

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

	<form action="index.php?id=tools&type=www_password" method="post">
	  <table> 
	    <input type="hidden"  name="chg" value="chg2"/></td></tr>
     <tr><td>Password :</td><td><input type="password"  name="pass" size="8"/></td></tr>		
	  <tr><td>Repeat:</td><td><input type="password"  name="pass2" size="8"/></td></tr>		
	  </table>     
     <input  type="submit" value="Change"  />
     </form>   
</span></span>


<span class="belka">&nbsp Enable/Disable WWW password <span class="okno">

<?php
if ($_POST['disable'] == "disable") { 
$file = "/etc/lighttpd/lighttpd.conf";
$text = file_get_contents($file); 
$text = str_replace('"mod_auth",', '#	"mod_auth",', $text); //no need for a regex
file_put_contents($file, $text);
shell_exec ("sudo service lighttpd reload");
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['enable'] == "enable") { 
$file = "/etc/lighttpd/lighttpd.conf";
$text = file_get_contents($file); 
$text = str_replace('#	"mod_auth",', '	"mod_auth",', $text); //no need for a regex
file_put_contents($file, $text);
shell_exec ("sudo service lighttpd reload");
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

?>
<table><tr>
<form action="index.php?id=tools&type=www_password" method="post">
<input type="hidden" name="enable" value="enable">
<td><input  type="submit" value="Enable"  /></td>
</form>
<form action="index.php?id=tools&type=www_password" method="post">
<input type="hidden" name="disable" value="disable">
<td><input  type="submit" value="Disable"  /></td>
</form>
</tr></table>
</span></span>







<?php
 }
else { 
  	  header("Location: diened");
    }; 
