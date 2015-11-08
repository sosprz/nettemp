<?php

if (isset($_POST['key'])) {
	    $key = $_POST['key'];
    }

$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select server_key from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
$skey=$a['server_key'];
}

if ($key != $skey){
    echo "dienied";
} else {

// main
if (isset($_POST['value'])) {
            $val = $_POST['value'];
    }
if (isset($_POST['rom'])) {
            $rom = $_POST['rom'];
    }

    $file = "$rom.sql";

if  ( !empty($rom) && !empty($val) ) {
    if (file_exists("db/$file")) {
	$db = new PDO("sqlite:db/$file");
	$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to DB 1" );
	
	$dbn = new PDO("sqlite:dbf/nettemp.db");
	$dbn->exec("UPDATE sensors SET tmp='$val' WHERE rom='$rom'") or die ("cannot insert to status" );
	echo "OK";
    }
    else {
	$dbnew = new PDO("sqlite:dbf/nettemp.db");
	$dbnew->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	$dbnew==NULL;
	echo "Added $rom to new";
    }
} 
else { 
    echo "no values";
    }


} //end main
?>

