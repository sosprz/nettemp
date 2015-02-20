<?php
//$address = $_POST["address"];  //sql
$user = isset($_POST['user']) ? $_POST['user'] : '';
$host = isset($_POST['host']) ? $_POST['host'] : '';
$port = isset($_POST['port']) ? $_POST['port'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$auth = isset($_POST['auth']) ? $_POST['auth'] : '';
$tls = isset($_POST['tls']) ? $_POST['tls'] : '';
$tlscheck = isset($_POST['tlscheck']) ? $_POST['tlscheck'] : '';


    $change_password1 = isset($_POST['change_password1']) ? $_POST['change_password1'] : '';
    if  ($change_password1 == "change_password2") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE mail_settings SET port='$port'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET host='$host'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET user='$user'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET password='$password'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET auth='$auth'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET tls='$tls'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET tlscheck='$tlscheck'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>



<?php
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from mail_settings ");
    $sth->execute();
    $result = $sth->fetchAll();
	foreach ($result as $a) {
?>

    <table>
    <tr>
    <form action="settings" method="post">
    <td>Username</td>
    <td><input type="text" name="user" size="25" value="<?php echo $a["user"]; ?>" /></td>
    </tr>
    <tr>	
    <td>Server smtp</td>
    <td><input type="text" name="host" size="25" value="<?php echo $a["host"]; ?>" /></td>
    </tr>
    <tr>	
    <td>Port</td>
    <td><input type="text" name="port" size="25" value="<?php echo $a["port"]; ?>" /></td>
    </tr>
    <tr>
    <td>Password</td>
    <td><input type="password" name="password" size="25" value="<?php echo $a["password"]; ?>" /></td>
    <input type="hidden" name="change_password1" value="change_password2" />
    </tr>
    <tr><td>Auth</td><td>
    <select name="auth" >
	    <option <?php echo $a['auth'] == 'on' ? 'selected="selected"' : ''; ?> value="on">on</option>   
	    <option <?php echo $a['auth'] == 'off' ? 'selected="selected"' : ''; ?> value="off">off</option>   
	    <option <?php echo $a['auth'] == 'login' ? 'selected="selected"' : ''; ?> value="login">login</option>   
    </select>    
    </td>
    </tr>
    <tr><td>TLS</td><td>
    <select name="tls" >
	    <option <?php echo $a['tls'] == 'on' ? 'selected="selected"' : ''; ?> value="on">on</option>   
	    <option <?php echo $a['tls'] == 'off' ? 'selected="selected"' : ''; ?> value="off">off</option>   
    </select>    
    </td>
    </tr>
    <tr><td>TLS Check cert</td><td>
    <select name="tlscheck" >
	    <option <?php echo $a['tlscheck'] == 'on' ? 'selected="selected"' : ''; ?> value="on">on</option>   
	    <option <?php echo $a['tlscheck'] == 'off' ? 'selected="selected"' : ''; ?> value="off">off</option>   
    </select>    
    </td>
    </tr>
    <tr><td><input type="submit" value="Save"  /></td></tr>
    </form>

    </table>

<?php }	?>

    








