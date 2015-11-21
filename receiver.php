<?php
// name:
// type: temp, humid, relay, lux, press, humid, kwh
// gpio:
// device: wireless, remote, gpio, i2c
// method: OLD
// ip:

// i2c curl --data "key=123456&device=i2c&type=humid&value=10&i2c=34" http://172.18.10.10/receiver.php
// php-cgi -f receiver.php key=123456 rom=new_12_temp value=23

//$rom='';
//$key='';


function db($rom,$val) {
	$file = "$rom.sql";
    	$db = new PDO('sqlite:dbf/nettemp.db');
        $rows = $db->query("SELECT rom FROM sensors WHERE rom='$rom'");
        $row = $rows->fetchAll();
        $c = count($row);
        if ( $c >= "1") {
	    if (is_numeric($val)) {
		$db = new PDO("sqlite:db/$file");
		$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql" );
		$min=intval(date('i'));
		if ((strpos($min,'0') !== false) || (strpos($min,'5') !== false)) {
		    $dbn->exec("UPDATE sensors SET tmp_5ago='$val' WHERE rom='$rom'") or die ("cannot insert to status" );
		}
	    }
		$dbn = new PDO("sqlite:dbf/nettemp.db");
		$dbn->exec("UPDATE sensors SET tmp='$val'+adj WHERE rom='$rom'") or die ("cannot insert to status" );
		echo "$rom ok";
	}
	else {
	    $dbnew = new PDO("sqlite:dbf/nettemp.db");
	    $dbnew->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	    $dbnew==NULL;
	    echo "Added $rom to new sensors";
	}
} 


if (isset($_GET['key'])) {
	    $key = $_GET['key'];
    }
if (isset($_GET['value'])) {
            $val = $_GET['value'];
    }
if (isset($_GET['rom'])) {
            $rom = $_GET['rom'];
	    $file = "$rom.sql";
    }
if (isset($_GET['ip'])) {
            $ip = $_GET['ip'];
    }
if (isset($_GET['type'])) {
            $type = $_GET['type'];
    }
if (isset($_GET['gpio'])) {
            $gpio = $_GET['gpio'];
    }
if (isset($_GET['device'])) {
            $device = $_GET['device'];
    }
if (isset($_GET['i2c'])) {
            $i2c = $_GET['i2c'];
    }


$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select server_key from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
$skey=$a['server_key'];
}

//echo $key;
//echo $skey;
//echo $rom;

if ("$key" != "$skey"){
    echo "wrong key";
} else {

// main
if  (!empty($val) && !empty($rom)) {
    	db($rom,$val);
    }
elseif (!empty($val) && empty($rom)) {

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
	db($rom,$val);

}
else {
    echo "no data";
} 

} //end main
?>

