<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select value from nt_settings WHERE option='mail_onoff'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
	$mail=$a["value"];
}

if ($mail == "on" ) { 
    include("mail_settings.php"); 
    include("mail_test.php"); 
} 
?>

