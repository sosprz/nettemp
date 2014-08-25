<?php
$user_name = $_POST["user_name"];  
$user_pass = $_POST["user_pass"];  
$user_id = $_POST["user_id"];  

	// SQlite add
	if (!empty($user_name) && !empty($user_pass) && ($_POST['add'] == "add") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO vpn (users) VALUES ('$user_name')") or die ("cannot insert to DB" );
	shell_exec("sudo /usr/sbin/useradd -s /usr/sbin/nologin $user_name");
	$cmd = "echo '".$user_name.":".$user_pass."' | sudo /usr/sbin/chpasswd";
	shell_exec($cmd);
	echo $out;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}	
	
	// SQLite - update 
	if ( $_POST['notif_update1'] == "notif_update2"){
	$db = new PDO('sqlite:dbf/snmp.db');
	$db->exec("UPDATE recipient SET sms_alarm='$notif_update_sms' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE recipient SET mail_alarm='$notif_update_mail' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	

	 // SQLite - del
	if (!empty($user_id) && ($_POST['del'] == "del") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM vpn WHERE id='$user_id'") or die ($db->lastErrorMsg());
	shell_exec("sudo /usr/sbin/userdel $user_name");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
?>


<span class="belka">&nbsp VPN users<span class="okno">
<table>
<tr><td></td><td>User</td><td>Password<td></tr>
    <tr><td></td>
	<form action="vpn" method="post">
	<td><input type="text" name="user_name" size="20" value="" /></td>
	<td><input type="text" name="user_pass" size="20" value="" /></td>
	<input type="hidden" name="add" value="add" />
	<td><input type="image" src="media/ico/Add-icon.png" /></td>
	</tr>
	</form>


<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from vpn ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
	<tr>
	<td><img src="media/ico/User-Preppy-Blue-icon.png" ></td>
	<td><?php echo $a["users"];?></td><td></td>
	<form action="vpn" method="post"> 	
	<input type="hidden" name="user_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="user_name" value="<?php echo $a["users"]; ?>" />
	<input type="hidden" type="submit" name="del" value="del" />
       <td><input type="image" src="media/ico/Close-2-icon.png"  /></td></tr>
	</form>
<?php } ?>

</tr></table>
</span></span>
