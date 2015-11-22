<?php
// name:
// type: temp, humid, relay, lux, press, humid, kwh
// gpio:
// device: wireless, remote, gpio, i2c
// method: OLD
// ip:

// url --data "key=123456&device=i2c&type=humid&value=10&i2c=34" http://172.18.10.10/receiver.php
// php-cgi -f receiver.php key=123456 rom=new_12_temp value=23

// |sed 's/.sql//g'|awk -F0x '{print $2"-"$8$7$6$5$4$3}' |tr A-Z a-z

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


function check(&$val,$type) {
    
		if ($type == 'lux') {
		    if ((0 <= $val) && ($val <= 1000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
			    
		}
		elseif ($type == 'temp') {
		    if (( -50 <= $val) && ($val <= 200)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		    
		}
		elseif ($type == 'humid') {
		    if ((0 <= $val) && ($val <= 110)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		
		}
		elseif ($type == 'press') {
    		    if ((0 <= $val) && ($val <= 1100)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
}




function db($rom,$val,$type) {
	$file = "$rom.sql";
    	$db = new PDO('sqlite:dbf/nettemp.db');
        $rows = $db->query("SELECT rom FROM sensors WHERE rom='$rom'");
        $row = $rows->fetchAll();
        $c = count($row);
        if ( $c >= "1") {
	    if (is_numeric($val)) {
		check($val,$type);
		$db = new PDO("sqlite:db/$file");
		$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql" );

		$dbn = new PDO("sqlite:dbf/nettemp.db");
		$dbn->exec("UPDATE sensors SET tmp='$val'+adj WHERE rom='$rom'") or die ("cannot insert to status" );
		
		$min=intval(date('i'));
		if ((strpos($min,'0') !== false) || (strpos($min,'5') !== false)) {
		    $dbn->exec("UPDATE sensors SET tmp_5ago='$val' WHERE rom='$rom'") or die ("cannot insert to status" );
		}
	    }
	    else {
		$dbn = new PDO("sqlite:dbf/nettemp.db");
		$dbn->exec("UPDATE sensors SET tmp='error' WHERE rom='$rom'") or die ("cannot insert to status" );
		}
		
	echo "$rom ok";
	}
	else {
	    $dbnew = new PDO("sqlite:dbf/nettemp.db");
	    $dbnew->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	    $dbnew==NULL;
	    echo "Added $rom to new sensors";
	}
} 



$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select server_key from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
$skey=$a['server_key'];
}

if ("$key" != "$skey"){
    echo "wrong key";
} else {

// main
if  (isset($val) && isset($rom) && isset($type)) {
    	db($rom,$val,$type);
    }
elseif (isset($val) && isset($type)) {

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
	db($rom,$val,$type);

}
else {
    echo "no data";
} 

} //end main
?>

