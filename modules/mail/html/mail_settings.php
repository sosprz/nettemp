<?php
//$address = $_POST["address"];  //sql
$user = $_POST["user"];  //sql
$host = $_POST["host"];  //sql
$port = $_POST["port"];  //sql
$password = $_POST["password"];  //sql
?>

<?php // SQLite 
    if  ($_POST['change_password1'] == "change_password2") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE mail_settings SET port='$port'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET host='$host'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET user='$user'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET password='$password'") or die ($db->lastErrorMsg());
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
<tr>	<form action="mail" method="post">
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
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr>



</table>
<?php }	?>
