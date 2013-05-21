<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
		
		
		

//$address = $_POST["address"];  //sql
$user = $_POST["user"];  //sql
$host = $_POST["host"];  //sql
$port = $_POST["port"];  //sql
$password = $_POST["password"];  //sql
$mail_test = $_POST["mail_test"];  //sql
?>

<?php // SQLite 
?>
<?php // SQLite 
	if  ($_POST['change_user1'] == "change_user2") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE mail_settings SET user='$user'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
?>
<?php // SQLite 
	if  ($_POST['change_host1'] == "change_host2") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE mail_settings SET host='$host'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
?>
<?php // SQLite 
	if  ($_POST['change_port1'] == "change_port2") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE mail_settings SET port='$port'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
?>
<?php // SQLite 
	if  ($_POST['change_password1'] == "change_password2") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE mail_settings SET password='$password'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
?>

<?php

if  ($_POST['mail_test1'] == "mail_test2") {
	$cmd="modules/mail/mail_test $mail_test";
	shell_exec($cmd);

}
?>


<div id="left">
	 <?php include("modules/mail/html/mail_settings.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
