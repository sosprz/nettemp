<?php
session_start();

//if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // last request was more than 30 minutes ago
//    session_unset();     // unset $_SESSION variable for the run-time 
 //   session_destroy();   // destroy session data in storage
//}
//$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


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

