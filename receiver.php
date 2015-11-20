<?php
// name:
// type: temp, humid, relay, lux, press, humid, kwh
// gpio:
// device: wireless, remote, gpio, i2c
// method: OLD
// ip:

// i2c curl --data "key=123456&device=i2c&type=humid&value=10&i2c=34" http://172.18.10.10/receiver.php



if (isset($_POST['key'])) {
	    $key = $_POST['key'];
    }
if (isset($_POST['value'])) {
            $val = $_POST['value'];
    }
if (isset($_POST['rom'])) {
            $rom = $_POST['rom'];
    }
if (isset($_POST['ip'])) {
            $ip = $_POST['ip'];
    }
if (isset($_POST['type'])) {
            $type = $_POST['type'];
    }
if (isset($_POST['gpio'])) {
            $gpio = $_POST['gpio'];
    }
if (isset($_POST['device'])) {
            $device = $_POST['device'];
    }
if (isset($_POST['i2c'])) {
            $i2c = $_POST['i2c'];
    }


$file = "$rom.sql";

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
if  (!empty($val)) {
    if (empty($rom)) {
	if ( $device == "i2c" ) { 
	    if (!empty($type) && !empty($i2c)) {
		$rom=$device.'_'.$i2c.'_'.$type;
	    } else {
		echo "Missing type or i2c number";
		exit();
	    }	
	}
	if ( $device == "gpio" ) { 
	    if (!empty($type) && !empty($gpio)) {
		$rom=$device.'_'.$gpio.'_'.$type; 
	    } else {
		echo "Missing type or gpio number";
		exit();
	    }
	}
	if ( $device == "wireless" ) { 
	    if (!empty($type) && !empty($ip)) {
		$rom=$device.'_'.$ip.'_'.$type; 
	    } else {
		echo "Missing type or IP";
		exit();
	    }
	}

	$file = "$rom.sql";
    }
	$db = new PDO('sqlite:dbf/nettemp.db');
        $rows = $db->query("SELECT rom FROM sensors WHERE rom='$rom'");
        $row = $rows->fetchAll();
        $c = count($row);
        if ( $c >= "1") {
	    $db = new PDO("sqlite:db/$file");
	    $db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql" );
	
	    $dbn = new PDO("sqlite:dbf/nettemp.db");
	    $dbn->exec("UPDATE sensors SET tmp='$val'+adj WHERE rom='$rom'") or die ("cannot insert to status" );
	    echo "ok";
	}
	else {
	    $dbnew = new PDO("sqlite:dbf/nettemp.db");
	    $dbnew->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	    $dbnew==NULL;
	    echo "Added $rom to new sensors";
	}
}
else {
    echo "no values";
    }


} //end main
?>

