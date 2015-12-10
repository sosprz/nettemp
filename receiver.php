<?php
// name:
// type: temp, humid, relay, lux, press, humid, gas, water, elec, volt, amper
// device: wireless, remote, gpio, i2c, usb
// definied source (middle part): tty, ip, gpio number

// curl --connect-timeout 3 -G "http://172.18.10.10/receiver.php" -d "value=1&key=123456&device=wireless&type=gas&ip=172.18.10.9"
// curl --connect-timeout 3 -G "http://172.18.10.10/receiver.php" -d "value=20&key=123456&device=wireless&type=elec&ip=172.18.10.9"
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
if (isset($_GET['current'])) {
            $current = $_GET['current'];
    } else $current='';
if (isset($_GET['tty'])) {
            $tty = $_GET['tty'];
    }




function check(&$val,$type) {

		//if ($val == '0.0') {
		//    $val=0;
		//}
    
		if ($type == 'lux') {
		    if ((-1 <= $val) && ($val <= 1000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
			    
		}
		elseif ($type == 'temp') {
		    if (( -50 <= $val) && ($val <= 200) && ($val != 85) && ($val != 127.9)) {
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
		elseif ($type == 'gas') {
    		    if ((0 <= $val) && ($val <= 100)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'water') {
    		    if ((0 <= $val) && ($val <= 100)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'elec') {
    		    if ((0 <= $val) && ($val <= 100)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'host') {
    		    if ((0 <= $val) && ($val <= 10000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'volt') {
    		    if ((-10000 <= $val) && ($val <= 10000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'amper') {
    		    if ((0 <= $val) && ($val <= 10000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'watt') {
    		    if ((-10000 <= $val) && ($val <= 10000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		

}




function db($rom,$val,$type,$chmin,$current) {
	$file = "$rom.sql";
	if ($type != 'host') {
	    $db = new PDO('sqlite:dbf/nettemp.db');
    	    $rows = $db->query("SELECT rom FROM sensors WHERE rom='$rom'");
	}
	elseif ($type == 'host') {
    	    $db = new PDO('sqlite:dbf/hosts.db');
    	    $rows = $db->query("SELECT rom FROM hosts WHERE rom='$rom'");
	}
        $row = $rows->fetchAll();
        $c = count($row);
        if ( $c >= "1") {
	    if (is_numeric($val)) {
		check($val,$type);
		if ($val != 'range'){
		    //// base
		    // time when you can put into base
		    if ((date('i', time())%$chmin==0) || (date('i', time())==00))  {
			$db = new PDO("sqlite:db/$file");
			$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql" );
			echo "$rom ok ";
		    }
		    // counters can always put to base
		    elseif ($type == 'gas' || $type == 'water' || $type == 'elec')  {
			$db = new PDO("sqlite:db/$file");
			if (isset($current)) {
			    $db->exec("INSERT OR IGNORE INTO def (value,current) VALUES ('$val','$current')") or die ("cannot insert to rom sql current" );
			} else {
			    $db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql" );
			}
			//sum for counters
			$dbn = new PDO("sqlite:dbf/nettemp.db");
			$dbn->exec("UPDATE sensors SET sum='$val'+sum WHERE rom='$rom'") or die ("cannot insert to status" );
			echo "$rom ok ";
		    }
		    else {
			echo "Not writed interval is $chmin min";
		    }
		    // 5ago arrow
		    $min=intval(date('i'));
		    if ((strpos($min,'0') !== false) || (strpos($min,'5') !== false)) {
			$dbn = new PDO("sqlite:dbf/nettemp.db");
			$dbn->exec("UPDATE sensors SET tmp_5ago='$val' WHERE rom='$rom'") or die ("cannot insert to 5ago" );
		    }
		    ////status for all
		    //hosts status
		    if ($type == 'host') {
			$dbh = new PDO("sqlite:dbf/hosts.db");
			$dbh->exec("UPDATE hosts SET last='$val', status='ok' WHERE rom='$rom'")or die ("cannot insert to hosts status");
		    }
		    //sensors status
		    else {
			$dbn = new PDO("sqlite:dbf/nettemp.db");
			$dbn->exec("UPDATE sensors SET tmp='$val'+adj WHERE rom='$rom'") or die ("cannot insert to status" );
		    }
		}		
		else {
		    echo "$rom $val not in range";
		}
		
	    }
	    // if not numeric
	    else {
		if ($type == 'host') {
		    $dbh = new PDO("sqlite:dbf/hosts.db");
		    $dbh->exec("UPDATE hosts SET last='0', status='error' WHERE rom='$rom'")or die ("cannot insert to hosts status");
		}
		//sensors
		else {
		    $dbn = new PDO("sqlite:dbf/nettemp.db");
		    $dbn->exec("UPDATE sensors SET tmp='error' WHERE rom='$rom'") or die ("cannot insert error to status" );
		}
		echo "$rom not numieric! $val ";
		}
	}
	//if not exist on base
	else {
	    $dbn = new PDO("sqlite:dbf/nettemp.db");
	    $dbn->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	    $dbn==NULL;
	    echo "Added $rom to new sensors";
	}
} 



$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
$skey=$a['server_key'];
$chmin=$a['charts_min'];
}

if ("$key" != "$skey"){
    echo "wrong key";
} else {

// main
if  (isset($val) && isset($rom) && isset($type)) {
    	db($rom,$val,$type,$chmin,$current);
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
	if ( $device == "usb" ) {
	    if (!empty($type) && !empty($tty)) {
		$rom=$device.'_'.$tty.'_'.$type; 
	    } else {
		echo "Missing type or tty";
		exit();
	    }
	}

	$file = "$rom.sql";
	db($rom,$val,$type,$chmin,$current);

}
else {
    echo "no data";
} 

} //end main
?>

