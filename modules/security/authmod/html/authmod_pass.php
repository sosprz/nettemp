<?php
    if (!file_exists("/etc/lighttpd/conf-enabled/05-auth.conf")) {
	echo "Status: disabled"; 
	}
	else {
	    echo "Status: enabled"; 
	}
?>
<hr>
<?php

$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$pass2 = isset($_POST['pass2']) ? $_POST['pass2'] : '';
$chg = isset($_POST['chg']) ? $_POST['chg'] : '';
if ($chg == "chg2") { 
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

	<table> 
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<input type="hidden"  name="chg" value="chg2"/></td></tr>
        <tr><td><label>Password:</label><input type="password"  name="pass" size="8"/></td></tr>		
	<tr><td><label>Repeat:</label><input type="password"  name="pass2" size="8"/></td></tr>		
        <tr><td><input  type="submit" value="Change" class="btn btn-primary" /></td></tr>		
        </form>
</table>     
