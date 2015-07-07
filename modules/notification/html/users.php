<?php
$notif_name = isset($_POST['notif_name']) ? $_POST['notif_name'] : '';
$notif_mail = isset($_POST['notif_mail']) ? $_POST['notif_mail'] : '';
$notif_tel = isset($_POST['notif_tel']) ? $_POST['notif_tel'] : '';
$notif_mail_alarm = isset($_POST['notif_mail_alarm']) ? $_POST['notif_mail_alarm'] : '';
$notif_sms_alarm = isset($_POST['notif_sms_alarm']) ? $_POST['notif_sms_alarm'] : '';

$notif_update_sms = isset($_POST['notif_update_sms']) ? $_POST['notif_update_sms'] : '';
$notif_update_mail = isset($_POST['notif_update_mail']) ? $_POST['notif_update_mail'] : '';
$notif_update = isset($_POST['notif_update']) ? $_POST['notif_update'] : '';

$notif_del = isset($_POST['notif_del']) ? $_POST['notif_del'] : '';
?>

<?php // SQLite - ADD RECIPIENT
	$notif_add1 = isset($_POST['notif_add1']) ? $_POST['notif_add1'] : '';
	if (!empty($notif_name)  && !empty($notif_mail) && !empty($notif_tel) && ($_POST['notif_add1'] == "notif_add2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO recipient (name, mail, tel, mail_alarm, sms_alarm) VALUES ('$notif_name', '$notif_mail', '$notif_tel', '$notif_mail_alarm', '$notif_sms_alarm')") or die ($db->lastErrorMsg());
	
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>
	
	<?php 
	
	// SQLite - update 
	$notif_update1 = isset($_POST['notif_update1']) ? $_POST['notif_update1'] : '';
	if ( $notif_update1 == "notif_update2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE recipient SET sms_alarm='$notif_update_sms' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE recipient SET mail_alarm='$notif_update_mail' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?>
	

<?php // SQLite - usuwanie notification
	if (!empty($notif_del) && ($_POST['notif_del1'] == "notif_del2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM recipient WHERE id='$notif_del'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>


<div class="panel panel-default">
<div class="panel-heading">Users</div>

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th></th><th>Name</th><th>Email</th><th>Telephone</th><th><img src="media/ico/message-icon.png"></th><th><img src="media/ico/phone-blue-glow-icon.png"></th><th>Add/Rem</th></tr></thead>

<tr>	
	<form action="" method="post">
	<td></td>
	<td><input type="text" name="notif_name" value="" class="form-control" required=""/></td>
	<td><input type="text" name="notif_mail" value="" class="form-control" required=""/></td>
	<td><input type="text" name="notif_tel" value="" class="form-control" required=""/></td>
	<td><input type="checkbox" name="notif_mail_alarm" value="yes" /></td>
	<td><input type="checkbox" name="notif_sms_alarm" value="yes" /></td>
	<input type="hidden" name="notif_add1" value="notif_add2" />
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	<td></td>
	</form>
</tr>
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from recipient ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
	<tr>
	<td><img src="media/ico/User-Preppy-Blue-icon.png"></td>
	<td><?php echo $a["name"];?></td>
	<td><?php echo $a["mail"];?></td>
	<td><?php echo $a["tel"]; ?></td>
	
	<form action="" method="post">
	<input type="hidden" name="notif_update" value="<?php echo $a["id"]; ?>" />
	<td><input data-size="mini" onchange="this.form.submit()" type="checkbox" name="notif_update_mail" value="yes" <?php echo $a["mail_alarm"] == 'yes' ? 'checked="checked"' : ''; ?> /></td>
	<td><input data-size="mini" onchange="this.form.submit()" type="checkbox" name="notif_update_sms" value="yes" <?php echo $a["sms_alarm"] == 'yes' ? 'checked="checked"' : ''; ?> /></td>
	<input type="hidden" name="notif_update1" value="notif_update2" />
	</form>
	
	<form action="" method="post"> 	
	    <input type="hidden" name="notif_del" value="<?php echo $a["id"]; ?>" />
	    <input type="hidden" type="submit" name="notif_del1" value="notif_del2" />
	    <td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
	</form>
	</tr>
<?php }
?>
</table>
</div>
</div>