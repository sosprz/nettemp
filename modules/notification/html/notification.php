<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 


		
$name = $_POST["name"];  //sql
$mail = $_POST["mail"];
$tel = $_POST["tel"];
$mail_alarm = $_POST["mail_alarm"];
$sms_alarm = $_POST["sms_alarm"];
$del_notifi = $_POST["del_notifi"];  //sql

$upd_notifi_id = $_POST["upd_notifi_id"];  //sql
$sms = $_POST["sms"];  //sql
$mail = $_POST["mail"];  //sql
?>

<?php // SQLite - ADD RECIPIENT
	
	if (!empty($name)  && !empty($mail) && !empty($tel) && ($_POST['add_recipient'] == "add_recipient1") ){
	//$db = new SQLite3('dbf/nettemp.db');
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO recipient (name, mail, tel, mail_alarm, sms_alarm) VALUES ('$name', '$mail', '$tel', '$mail_alarm', '$sms_alarm')") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}

	?>
	
	<?php 
	
	// SQLite - update 
	if ( $_POST['upd_notifi_sms1'] == "upd_notifi_sms2"){
	//$db = new SQLite3('dbf/nettemp.db');
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE recipient SET sms_alarm='$sms' WHERE id='$upd_notifi_id'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE recipient SET mail_alarm='$mail' WHERE id='$upd_notifi_id'") or die ($db->lastErrorMsg());
	//header("location: " . $_SERVER['REQUEST_URI']);
	//exit();
	 } 
	 ?>
	

<?php // SQLite - usuwanie notofication
	if (!empty($del_notifi) && ($_POST['del_notifi1'] == "del_notifi2") ){
	//$db = new SQLite3('dbf/nettemp.db');
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM recipient WHERE id='$del_notifi'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>
<div id="left">
	 <?php include("modules/notification/html/notification_settings.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
