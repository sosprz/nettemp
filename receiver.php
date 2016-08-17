<?php
// name:
// type: temp, humid, relay, lux, press, humid, gas, water, elec, volt, amps, watt, trigger
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
    } else $device='';
if (isset($_GET['i2c'])) {
            $i2c = $_GET['i2c'];
    }
if (isset($_GET['current'])) {
            $current = $_GET['current'];
    } else $current='';
if (isset($_GET['usb'])) {
            $usb = $_GET['usb'];
    }

function trigger($rom) {
$dbn = new PDO("sqlite:dbf/nettemp.db");
   $rows = $dbn->query("SELECT mail FROM users WHERE maila='yes'");
   $row = $rows->fetchAll();
   foreach($row as $row) {
	$to[]=$row['mail'];   
   }
   
   $rows = $dbn->query("SELECT name FROM sensors WHERE rom='$rom'");
   $row = $rows->fetchAll();
   foreach($row as $row) {
	$name=$row['name'];   
   }
   
   $to = implode(', ', $to);
   if(mail("$to", 'ALARM from nettemp device', "Trigger ALARM $name" )) {
	echo "ok\n";
   } else {
    echo "error\n";
   }

}

function check(&$val,$type) {

		if ($type == 'lux') {
		    if ((-1 <= $val) && ($val <= 80000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
			    
		}
		elseif ($type == 'temp') {
		    if (( -150 <= $val) && ($val <= 3000) && ($val != 85) && ($val != 185) && ($val != 127.9)) {
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
    		    if ((0 <= $val) && ($val <= 99999999)) {
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
		elseif ($type == 'amps') {
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
		elseif ($type == 'dist') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'trigger') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'rainfall') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}elseif ($type == 'speed') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='speed';
		    }
		}
		elseif ($type == 'wind') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'uv') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'storm') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		elseif ($type == 'lighting') {
    		    if ((0 <= $val) && ($val <= 100000)) {
			$val=$val;
		    }
		    else {
			$val='range';
		    }
		}
		
		
		

}




function db($rom,$val,$type,$device,$current) {
	global $chmin;
	$file = "$rom.sql";
	$dbn = new PDO("sqlite:dbf/nettemp.db");
	 $dbh = new PDO('sqlite:dbf/nettemp.db');
	 $db = new PDO("sqlite:db/$file");

	if ($type == 'host') {
    	    $rows = $dbh->query("SELECT rom FROM hosts WHERE rom='$rom'");
	}
	else {
		 	 $rows = $dbn->query("SELECT rom FROM sensors WHERE rom='$rom'");
    	 }
    	 
   $row = $rows->fetchAll();
   $c = count($row);
   if ( $c >= "1") {
	  if (is_numeric($val)) {
		check($val,$type);
		if ($val != 'range'){
		    //// base
		    // counters can always put to base
		    $arrayt = array("gas", "water", "elec", "amps", "volt", "watt", "temp", "humid", "trigger", "rainfall", "speed", "wind", "uv", "storm", "lighting");
		    $arrayd = array("wireless", "gpio", "usb");
		    if (in_array($type, $arrayt) &&  in_array($device, $arrayd)) {
					if (isset($current) && is_numeric($current)) {
			    		$db->exec("INSERT OR IGNORE INTO def (value,current) VALUES ('$val','$current')") or die ("cannot insert to rom sql current\n" );
			    		$dbn->exec("UPDATE sensors SET current='$current' WHERE rom='$rom'") or die ("cannot insert to current\n" );
					} else {
			    		$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql\n" );
					}
					//sum,current for counters
					$dbn->exec("UPDATE sensors SET sum='$val'+sum WHERE rom='$rom'") or die ("cannot insert to status\n" );
					echo "$rom ok \n";
		    }
		    // time when you can put into base
		    elseif ((date('i', time())%$chmin==0) || (date('i', time())==00))  {
				$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql\n" );
				echo "$rom ok \n";
		    }
		    else {
					echo "Not writed interval is $chmin min";
		    }
		    
		    // 5ago arrow
		    $min=intval(date('i'));
		    if ((strpos($min,'0') !== false) || (strpos($min,'5') !== false)) {
				$dbn->exec("UPDATE sensors SET tmp_5ago='$val' WHERE rom='$rom'") or die ("cannot insert to 5ago\n" );
		    }
		    
		    ////status for all
		    //hosts status
		    if ($type == 'host') {
		    		if($val==0) {
		    			$dbh->exec("UPDATE hosts SET last='0', status='error' WHERE rom='$rom'")or die ("cannot insert to hosts status\n");
		    		} 
		    		else {   			
						$dbh->exec("UPDATE hosts SET last='$val', status='ok' WHERE rom='$rom'")or die ("cannot insert to hosts status\n");
					}
		    }
		    elseif ($type == 'trigger') {
					$dbn->exec("UPDATE sensors SET tmp='$val' WHERE rom='$rom'") or die ("cannot insert to trigger status2\n");
					trigger($rom);
		    }
		    //sensors status
		    else {
					$dbn->exec("UPDATE sensors SET tmp='$val'+adj WHERE rom='$rom'") or die ("cannot insert to status\n" );
		    }
		    
		    
		}		
		else {
		    echo "$rom $val not in range \n";
		}
		
	    }
	    // if not numeric
	    else {
		if ($type == 'host') {
		    $dbh = new PDO("sqlite:dbf/nettemp.db");
		    $dbh->exec("UPDATE hosts SET last='0', status='error' WHERE rom='$rom'")or die ("cannot insert to hosts status\n");
		}
		//sensors
		else {
		    $dbn = new PDO("sqlite:dbf/nettemp.db");
		    $dbn->exec("UPDATE sensors SET tmp='error' WHERE rom='$rom'") or die ("cannot insert error to status\n" );
		}
		echo "$rom not numieric! $val \n";
		}
	}
	//if not exist on base
	else {
	    $dbn->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	    $dbn==NULL;
	    echo "Added $rom to new sensors \n";
	}
} 



$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
	$skey=$a['server_key'];
	$scale=$a['temp_scale'];
	}

$sth = $db->prepare("select * from highcharts WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
	global $chmin;
	$chmin=$a['charts_min'];
	}

if ("$key" != "$skey"){
    echo "wrong key\n";
} else {

// scale F->C
if($scale=='F' && $type=='temp') {
    $val=$val*1.8+32;
}

// main
if  (isset($val) && isset($rom) && isset($type)) {
    	db($rom,$val,$type,$device,$current);
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
	    if (!empty($type) && !empty($usb)) {
		$rom=$device.'_'.$usb.'_'.$type; 
	    } else {
		echo "Missing type or USB";
		exit();
	    }
	}

	$file = "$rom.sql";
	db($rom,$val,$type,$device,$current);

}
else {
    echo "no data\n";
} 

} //end main
?>

