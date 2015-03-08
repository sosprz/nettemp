<?php
if (isset($_GET['temp'])) {
//    if (filter_var($_GET['temp'], FILTER_VALIDATE_URL)) {
            $temp = $_GET['temp'];
//}
    }
if (isset($_GET['mac'])) {
//        if (filter_var($_GET['mac'], FILTER_VALIDATE_URL)) {
            $mac = $_GET['mac'];
//        }
    }




    $file = 'wireless_' . $mac . '_temp.sql';
    $rom = 'wireless_' . $mac . '_temp';
    
if  ( !empty($temp) && !empty($mac) ) {
    if (file_exists("db/$file")) {
	$db = new PDO("sqlite:db/$file");
	$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$temp')") or die ("cannot insert to DB 1" );
	$dbn = new PDO("sqlite:dbf/nettemp.db");
	$dbn->exec("UPDATE sensors SET tmp='$temp' WHERE rom='$rom'") or die ("cannot insert to status" );
	echo "ok";
    }
    else {  
	$dbnew = new PDO("sqlite:dbf/nettemp.db");
	$dbnew->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	$dbnew==NULL;
	echo "New wireless sensor $rom added";
    }
} 
else { 
    echo "no values";
    } 

?>

