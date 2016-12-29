<?php
session_start();

$autologout= isset($_POST['autologout']) ? $_POST['autologout'] : '';
$setautologout= isset($_POST['setautologout']) ? $_POST['setautologout'] : '';
    if ($setautologout == "onoff"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET autologout='$autologout' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$sth = $db->prepare("SELECT autologout FROM settings WHERE id='1'");
if ( $sth ) {
    $result = $sth->execute() ? $sth->fetch() : '';
}
$autologout = empty($result) ? 'on' : $result['autologout'];
unset($sth,$result);


if ($autologout=='on' && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
	session_unset();     // unset $_SESSION variable for the run-time 
	session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


$form_login = isset($_POST['form_login']) ? $_POST['form_login'] : '';
if ($form_login == "log") { /// do after login form is submitted  
	$user=$_POST["username"];
	$pass=sha1($_POST["password"]);
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

