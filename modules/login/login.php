<?php
session_start();
$form_login = isset($_POST['form_login']) ? $_POST['form_login'] : '';
if ($form_login == "log") { /// do after login form is submitted  
	$user=$_POST["username"];
	$pass=sha1($_POST["password"]);
	$db = new PDO('sqlite:dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM users WHERE login='$user' AND password='$pass' ");
	$row = $rows->fetchAll();
	foreach($row as $a) {
	    $user=$a['login'];
	    $perms=$a['perms'];
	    $accesscam=$a['cam'];
	}
	//print_r($row);
	$numRows = count($row);
     if ($numRows == 1) {
	$_SESSION["user"] = $user;
	$_SESSION["perms"] = $perms;
	$_SESSION["accesscam"] = $accesscam;
	} else {
	    $message = "Invalid Username or Password!";
	}
	
	if(isset($_SESSION["user"])) {
	header("Location:status");
	}
}
?>

