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
<div class="panel-heading">
<h3 class="panel-title">Panel title</h3>
</div>
<div class="panel-body">

<div class="row">
    <div class="col-sm-2">Name</div>
    <div class="col-sm-2">Email</div>
    <div class="col-sm-2">Telephone</div>
    <div class="col-sm-1">Mail</div>
    <div class="col-sm-1">SMS</div>
    <div class="col-sm-1"></div>
</div>

<div class="row">
	<form action="" method="post">
	<div class="col-sm-2"><input type="text" name="notif_name" value="" class="form-control" required=""/></div>
	<div class="col-sm-2"><input type="text" name="notif_mail" value="" class="form-control" required=""/></div>
	<div class="col-sm-2"><input type="text" name="notif_tel" value="" class="form-control" required=""/></div>
	<input type="hidden" name="notif_add1" value="notif_add2" />
	<div class="col-sm-1"><input type="checkbox" name="notif_mail_alarm" value="yes" /></div>
	<div class="col-sm-1"><input type="checkbox" name="notif_sms_alarm" value="yes" /></div>
	<div class="col-sm-1"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></div>
	</form>
</div>
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from recipient ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
<p>
<div class="row">
	<div class="col-sm-2"><?php echo $a["name"];?></div>
	<div class="col-sm-2"><?php echo $a["mail"];?></div>
	<div class="col-sm-2"><?php echo $a["tel"]; ?></div>
	
        <form action="" method="post">
	<div class="col-sm-1"><input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="notif_update_mail" value="yes" <?php echo $a["mail_alarm"] == 'yes' ? 'checked="checked"' : ''; ?> /></div>
	<div class="col-sm-1"><input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="notif_update_sms" value="yes" <?php echo $a["sms_alarm"] == 'yes' ? 'checked="checked"' : ''; ?> /></div>
	<input type="hidden" name="notif_update1" value="notif_update2" />
	<input type="hidden" name="notif_update" value="<?php echo $a["id"]; ?>" />
	</form>

	<form action="" method="post">
	    <input type="hidden" name="notif_del" value="<?php echo $a["id"]; ?>" />
	    <input type="hidden" type="submit" name="notif_del1" value="notif_del2" />
	    <div class="col-sm-1"><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button></div>
	</form>
</div>
</p>
<?php 
}
?>

</div>
</div>