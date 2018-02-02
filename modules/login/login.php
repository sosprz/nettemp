<?php

if(!function_exists('hash_equals')) {
  function hash_equals($a, $b) {
    return substr_count($a ^ $b, "\0") * 2 === strlen($a . $b);
  }
}

//session_start();

$user=$_SESSION['user'];
$autologout='';

//if (empty($_SESSION['user']) && !empty($_COOKIE['stay_login'])) {
if (!empty($_COOKIE['stay_login'])) {	
    list($selector, $authenticator) = explode(':', $_COOKIE['stay_login']);
    
    $db = new PDO('sqlite:dbf/nettemp.db');
    $stmt = $db->query("SELECT t1.*, t2.* FROM auth_tokens t1, users t2 WHERE t1.userid=t2.id AND t1.selector = '$selector'"); 
	$row = $stmt->fetchAll();

	foreach($row as $row) {
		if (hash_equals($row['token'], hash('sha256', base64_decode($authenticator)))) {
			$_SESSION['user'] = $row['login'];
			$_SESSION['perms'] = $row['perms'];
			$autologout='on';
		}
	}
}


if (empty($autologout) && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
	session_unset();     // unset $_SESSION variable for the run-time 
	session_destroy();   // destroy session data in storage
	setcookie('stay_login'.$user, null, -1, '/');
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp




/* forms */
$autologout_value= isset($_POST['autologout_vaue']) ? $_POST['autologout_value'] : '';
$setautologout= isset($_POST['setautologout']) ? $_POST['setautologout'] : '';
    if ($setautologout == "onoff"){
		$sth = $db->prepare("SELECT id FROM users WHERE login='$user'");
			if ( $sth ) {
				$result = $sth->execute() ? $sth->fetch() : '';
			}
			$userid = empty($result) ? '' : $result['id'];
			unset($sth,$result);
		if($autologout!='on'){
		
			/* setcookie */
			$selector = base64_encode(mt_rand());  
			$authenticator = mt_rand();
			$token=hash('sha256', $authenticator);
			$date=date('Y-m-d\TH:i:s', time() + (3600 * 24 * 30));
			setcookie(
				'stay_login',
				$selector.':'.base64_encode($authenticator),
				time() + (3600 * 24 * 30),
				'/'
			);
			$db = new PDO('sqlite:dbf/nettemp.db');
			//$db->exec("DELETE FROM auth_tokens WHERE userid='$userid'");
			$db->exec("INSERT INTO auth_tokens (selector, token, userid, expires) VALUES ('$selector', '$token', '$userid', '$date')");
			/* seetocookie end */
		}
		else {
			$db->exec("DELETE FROM auth_tokens WHERE selector='$selector'");
			setcookie('stay_login', null, -1, '/');
		}
	
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}

$form_login = isset($_POST['form_login']) ? $_POST['form_login'] : '';
if ($form_login == "log") {
	$user=$_POST["username"];
	$pass=sha1($_POST["password"]);
	$rows = $db->query("SELECT login,perms,cam FROM users WHERE login='$user' AND password='$pass' ");
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

