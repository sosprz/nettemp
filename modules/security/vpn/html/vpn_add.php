<?php
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : '';

	// SQlite add
	if (!empty($user_name) && !empty($user_pass) && ($_POST['add'] == "add") ){
	//$db = new PDO('sqlite:dbf/nettemp.db');
	//$db->exec("INSERT OR IGNORE INTO vpn (users) VALUES ('$user_name')") or die ("cannot insert to DB" );
	shell_exec("sudo /usr/sbin/groupadd vpn");
	shell_exec("sudo /usr/sbin/useradd -M -N -s /usr/sbin/nologin $user_name -G vpn");
	$cmd = "echo '".$user_name.":".$user_pass."' | sudo /usr/sbin/chpasswd";
	shell_exec($cmd);
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}	
	
	// SQLite - update 
	$notif_update1 = isset($_POST['notif_update1']) ? $_POST['notif_update1'] : '';
	if ( $notif_update1 == "notif_update2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE recipient SET sms_alarm='$notif_update_sms' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE recipient SET mail_alarm='$notif_update_mail' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	

	 // SQLite - del
	$del = isset($_POST['del']) ? $_POST['del'] : '';
	if ($del == "del"){
	shell_exec("sudo /usr/sbin/userdel $user_name");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
?>
<div class="panel panel-default">
<div class="panel-heading">OpenVPN settings</div>
<div class="panel-body">
<p>Port: 1194</p>
<p>LZO compression: on</p>
<p><?php include('modules/security/vpn/html/vpn_ca.php'); ?></p>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">VPN Users</div>
<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th></th><th>Name</th><th>Password</th><th>Add/Rem</th></tr></thead>
    <tr><td></td>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" calss="form">
	<td><input type="text" name="user_name" value="" class="form-control" required=""/></td>
	<td><input type="text" name="user_pass" value="" class="form-control" required=""/></td>
	<input type="hidden" name="add" value="add" />
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	</form>
    </tr>
<?php
$pass=exec("awk -F':' '/vpn/{print $4}' /etc/group");
$result = array_filter(explode(",", $pass));
//var_dump($result);
foreach ($result as $a) { 
?>
    <tr>
	<td><img src="media/ico/User-Preppy-Blue-icon.png" ></td>
	<td><?php echo $a;?></td><td></td>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"> 	
	<input type="hidden" name="user_name" value="<?php echo $a; ?>" />
	<input type="hidden" type="submit" name="del" value="del" />
	<td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
	</form>
    </tr>
<?php
}
?>
</table>
</div>
</div>