<?php
// name:
// type: temp, humid, relay, lux, press, humid, gas, water, elec, volt, amps, watt, trigger
// device: ip, wireless, remote, gpio, i2c, usb

// definied source (middle part): tty, ip, gpio number

// curl --connect-timeout 3 -G "http://172.18.10.10/receiver.php" -d "value=1&key=123456&device=wireless&type=gas&ip=172.18.10.9"
// curl --connect-timeout 3 -G "http://172.18.10.10/receiver.php" -d "value=20&key=123456&device=wireless&type=elec&ip=172.18.10.9"
// php-cgi -f receiver.php key=123456 rom=new_12_temp value=23



if (isset($_GET['key'])) { 
    $key = $_GET['key'];
} else { 
    $key='';
}

if (isset($_GET['value'])) {
    $val = $_GET['value'];
} else { 
    $val='';
}

if (isset($_GET['rom'])) {
    $rom = $_GET['rom'];
}

if (isset($_GET['ip'])) {
    $ip = $_GET['ip'];
} else {
    $ip='';
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];

} 
    
if (isset($_GET['gpio'])) {
    $gpio = $_GET['gpio'];
} else {
    $gpio='';
}

if (isset($_GET['device'])) {
    $device = $_GET['device'];
} else {
    $device='';
}

if (isset($_GET['i2c'])) { 
    $i2c = $_GET['i2c'];
} else {
    $i2c='';
}

if (isset($_GET['usb'])) { 
    $usb = $_GET['usb'];
} else {
    $usb='';
}

if (isset($_GET['current'])){
    $current = $_GET['current'];
} else {
    $current='';
}

if (isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    $id='';
}

if (isset($_GET['name'])){
    $name = $_GET['name'];
} else {
    $name='';
}

$local_rom='';
$local_type='';
$local_val='';
$local_device='';
$local_i2c='';
$local_current='';
$local_name='';
$local_ip='';
$local_gpio='';
$local_usb='';


$dbr = new PDO("sqlite:".__DIR__."/dbf/nettemp.db") or die ("cannot open database");

$sth = $dbr->query("SELECT * FROM nt_settings");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
	if($a['option']=='temp_scale') {
		$scale=$a['value'];
	}
	if($a['option']=='server_key') {
		$skey=$a['value'];
	}
	if($a['option']=='charts_min') {
		$chmin=$a['value'];
	}
	if($a['option']=='mail_topic') {
		$mail_topic=$a['value'];
	}
}


function adjust($val,$rom) { 
	$dbr = new PDO("sqlite:".__DIR__."/dbf/nettemp.db") or die ("cannot open database");
	$sthr = $dbr->query("SELECT * FROM adjust WHERE rom='$rom' ORDER by threshold ASC");
    $row = $sthr->fetchAll();
    foreach($row as $row) {
		$threshold=$row['threshold'];
		$end=$row['end'];
		$add=$row['addvalue'];
		if($val>=$threshold&&$val<$end)
		{ 
			$val=$val+$add;
			break;
		}
    }
    return "$val";
}

function scale($val,$type) {
	global $scale;
	// scale F->C
	if($scale=='F' && $type=='temp') {
		$val=$val*1.8+32;
		return "$val";
	} else {
		return "$val";
	}
	//$sthr=null;
    //$dbr=null;
}

function trigger($rom) {
	$dbr = new PDO("sqlite:".__DIR__."/dbf/nettemp.db") or die ("cannot open database");
    $sthr = $dbr->query("SELECT mail FROM users WHERE maila='yes'");
    $row = $sthr->fetchAll();
    foreach($row as $row) {
		$to[]=$row['mail'];   
    }
   
    $sthr = $dbr->query("SELECT name FROM sensors WHERE rom='$rom'");
    $row = $sthr->fetchAll();
    foreach($row as $row) {
		$name=$row['name'];   
    }
   
    $to = implode(', ', $to);
    if(mail($to, $mail_topic, "Trigger ALARM $name" )) {
		echo "ok\n";
    } else {
		echo "error\n";
    }
    //$sthr=null;
    //$dbr=null;

}

function check($val,$type) {
	$dbr = new PDO("sqlite:".__DIR__."/dbf/nettemp.db") or die ("cannot open database");
	$sthr = $dbr->query("SELECT * FROM types WHERE type='$type'");
    $row = $sthr->fetchAll();
    foreach($row as $range) 
    {
		if (($range['min'] <= $val) && ($val <= $range['max']) && ($val != $range['value1']) && ($val != $range['value2']) && ($val != $range['value3'])) 
		{
			return "$val";
		}
		else 
		{
			return 'range';
		}
	}
    //$sthr=null;
    //$dbr=null;	

}



function db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name){
	$file = "$rom.sql";
	global $chmin;
	$dbr = new PDO("sqlite:".__DIR__."/dbf/nettemp.db") or die ("cannot open database");
	if(file_exists(__DIR__."/db/".$file)&&filesize(__DIR__."/db/".$file)!=0){
		$dbfr = new PDO("sqlite:".__DIR__."/db/$file");
		$sthr = $dbr->query("SELECT stat_min,stat_max,rom,adj FROM sensors WHERE rom='$rom'");
		$row = $sthr->fetchAll();
		foreach($row as $row) {
			$adj=$row['adj']; 
			$stat_min=$row['stat_min'];
			$stat_max=$row['stat_max'];
			$val=$val+$adj;  
		}
		$c = count($row);
		if ( $c >= "1") {
			if (is_numeric($val)) {
				$val=scale($val,$type);
				$val=adjust($val,$rom);
				$val=check($val,$type);
				if ($val != 'range'){
					//// base
					// counters can always put to base
					$arrayt = array("gas", "water", "elec", "amps", "volt", "watt", "temp", "humid", "trigger", "rainfall", "speed", "wind", "uv", "storm", "lighting");
					$arrayd = array("wireless", "gpio", "usb");
					if (in_array($type, $arrayt) &&  in_array($device, $arrayd)) {
						if (isset($current) && is_numeric($current)) {
							$dbfr->exec("INSERT OR IGNORE INTO def (value,current) VALUES ('$val','$current')") or die ("cannot insert to rom sql current\n" );
							$dbr->exec("UPDATE sensors SET current='$current' WHERE rom='$rom'") or die ("cannot insert to current\n" );
							echo $rom." current ".$current." \n";
						} else {
							$dbfr->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to rom sql\n" );
						}
						//sum,current for counters
						$dbr->exec("UPDATE sensors SET sum='$val'+sum WHERE rom='$rom'") or die ("cannot insert to status\n" );
						echo $rom." ok \n";
					}
					// time when you can put into base
					elseif ((date('i', time())%$chmin==0) || (date('i', time())==00))  {
						$dbfr->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die (date("Y-m-d H:i:s")." ERROR: Cannot insert to rom sql, time\n");
						echo date("Y-m-d H:i:s")." ".$rom." ".$val." ok \n";
					}
					else {
						echo "Not writed interval is ".$chmin." min\n";
					}
		    
					// 5ago arrow
					$min=intval(date('i'));
					if ((strpos($min,'0') !== false) || (strpos($min,'5') !== false)) {
						$dbr->exec("UPDATE sensors SET tmp_5ago='$val' WHERE rom='$rom'") or die ("cannot insert to 5ago\n" );
					}
		
					if ($type == 'trigger') {
						$dbr->exec("UPDATE sensors SET tmp='$val' WHERE rom='$rom'") or die ("cannot insert to trigger status2\n");
						trigger($rom);
					}
					//sensors status
					else {
						$dbr->exec("UPDATE sensors SET tmp='$val', status='ok', ip='$ip' WHERE rom='$rom'") or die (date("Y-m-d H:i:s")." ERROR: Cannot insert value to status\n" );
						echo $rom." ok\n";
						//minmax light
						if ($val<$stat_min || empty($stat_min)) {$dbr->exec("UPDATE sensors SET stat_min='$val' WHERE rom='$rom'");
						} elseif ($val>$stat_max || empty($stat_max)) {$dbr->exec("UPDATE sensors SET stat_max='$val' WHERE rom='$rom'");}
						
						if(!is_null($ip)&&$device=='gpio') {
						    $dbr->exec("UPDATE gpio SET ip='$ip' WHERE rom='$rom'") or die (date("Y-m-d H:i:s")." ERROR: Cannot insert IP to gpio\n" );
						}
						
					}
				}		
				else {
					echo $rom." ".$val." not in range \n";
				}
		
			}
			// if not numeric
			else {
				if($device!='gpio'&&$type!='gpio'){
					$dbr->exec("UPDATE sensors SET status='error' WHERE rom='$rom'") or die (date("Y-m-d H:i:s")." ERROR: Cannot insert status to sensors ".$rom.", not numeric\n");
					$dbfr->exec("INSERT OR IGNORE INTO def (value) VALUES ('0')") or die (date("Y-m-d H:i:s")." ERROR: Cannot insert to rom DB ".$rom.", not numeric\n");
					echo date("Y-m-d H:i:s")." Puting value \"".$val."\" to ".$rom.", but value is not numieric!, inserting 0 to db\n";
				}
			}
		}
		//if not in sensors table
		else {
			$name=substr(rand(), 0, 4);
			$dbr->exec("INSERT OR IGNORE INTO newdev (rom,type,device,ip,gpio,i2c,usb,name) VALUES ('$rom','$type','$device','$ip','$gpio','$i2c','$usb','$name')");
			echo "DB exist. Added ".$rom." to new sensors \n";
		}
	}
	//if base not exist
	else {
		$name=substr(rand(), 0, 4);
		$dbr->exec("INSERT OR IGNORE INTO newdev (rom,type,device,ip,gpio,i2c,usb,name) VALUES ('$rom','$type','$device','$ip','$gpio','$i2c','$usb','$name')");
		echo "No DB. Added ".$rom." to new sensors \n";
	}
	//$sthr=null;
	//$dbr=null;
	//$dbfr=null;
} 



if (("$key" != "$skey") && (!defined('LOCAL')))
{
    echo "wrong key\n";
} 
else {

//MAIN
//Local devices have always rom
if(isset($val) && isset($rom) && isset($type))
{
	db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
}
elseif (isset($val) && isset($type)) 
{
	//MULTI ID
	// receiver.php?device=ip&ip=172.18.10.102&key=q1w2e3r4&id=5;6;7&type=temp;humid;press&value=0.00;0.00;0.00
	if (strpos($type, ';') !== false && strpos($id, ';') !== false) 
	{
		$aid = array_filter(explode(';', $id),'strlen');
		$atype = array_filter(explode(';', $type),'strlen');
		$aval = array_filter(explode(';', $val),'strlen');
		foreach($aid as $index => $id) {
			$type=$atype[$index];
			$val=$aval[$index];
			if(empty($id)){
				echo "One id is not definied in multi id mode, name ".$name.", type ".$type.", val ".$val."\n";
				continue;
			}
			if(empty($type)){
				echo "One type is not definied in multi id mode, name ".$name.", id ".$id.", val ".$val."\n";
				continue;
			}
			if(!is_numeric($val)){
				echo "No val definied in multi id mode, name ".$name.", type ".$type." id ".$id.", type ".$type."\n";
				continue;
			}			
			$rom=$device."_".$name."id".$id."_".$type; 
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
		}
		
	}
	//MULTI TYPE
	// receiver.php?name=unit1&key=q1w2e3r4&type=temp;humid;press&value=0.00;0.00;0.00
	elseif (strpos($type, ';') !== false && empty($id)) 
	{
		$atype = array_filter(explode(';', $type),'strlen');
		$aval = array_filter(explode(';', $val),'strlen');
		
		if(empty($atype)) {
			echo "No type definied in one id mode, name ".$name.", id ".$id."\n";
			exit;
		}
		foreach($atype as $index => $typel) {
			$type=$typel;
			$val=$aval[$index];
			if(empty($type)){
				echo "One type is not definied in multi id mode, name ".$name.", id ".$id.", val ".$val."\n";
				continue;
			}
			if(!is_numeric($val)){
				echo "No val definied in multi id mode, name ".$name.", id ".$id.", type ".$type."\n";
				continue;
			}

			$rom=$device."_".$name."_".$type; 
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
		} 
	}
	// ONE ID 
	// type is more important than id, type equal value
	// receiver.php?name=unit1&key=q1w2e3r4&id=5&type=temp;humid;press&value=0.00;0.00;0.00
	elseif (!empty($id)&&!empty($name)) 
	{
		$atype = array_filter(explode(';', $type),'strlen');
		$aval = array_filter(explode(';', $val),'strlen');
		if(empty($atype)) {
			echo "No type definied in one id mode, name ".$name.", id ".$id."\n";
			exit;
		}
		foreach($atype as $index => $typel) {
			$type=$typel;
			$val=$aval[$index];
			if(empty($type)){
				echo "One type is not definied in one id mode, name ".$name.", id ".$id.", val $val\n";
				continue;
			}
			if(!is_numeric($val)){
				echo "No val definied in one id mode, name ".$name.", id ".$id.", type ".$type."\n";
				continue;
			}
			$rom=$device.'_'.$name.'id'.$id.'_'.$type; 
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
		} 
	}
	// ONE TYPE	
	// receiver.php?device=ip&ip=172.18.10.102&key=q1w2e3r4&type=temp&value=0.00
	elseif ( $device == "i2c" ) 
	{ 
	    if (!empty($type) && !empty($i2c)) 
	    {
			$rom=$device.'_'.$i2c.'_'.$type;
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
	    } else 
	    {
			echo "Missing type or i2c number";
			exit();
	    }	
	}
	elseif ( $device == "gpio" ) 
	{ 
	    if (!empty($type) && !empty($gpio)) {
			$rom=$device.'_'.$gpio; 
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
	    } else {
			echo "Missing type or gpio number";
			exit();
	    }
	}
	elseif ( $device == "usb" ) 
	{
	    if (!empty($type) && !empty($usb)) 
	    {
			$rom=$device.'_'.$usb.'_'.$type; 
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
	    } else {
			echo "Missing type or USB";
			exit();
	    }
	}
	elseif ( $device == "wireless" ) 
	{
	    if (!empty($type) && !empty($ip)) {
			$rom=$device.'_'.$ip.'_'.$type; 
			db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
	    } else 
	    {
			echo "Missing type or IP";
			exit();
	    }
	}
	elseif ( $device == "ip" ) 
	{
	    if (empty($type)){ echo "Missing type"; exit();}
	    if (empty($device)){ echo "Missing device"; exit();}
	    if (empty($name)){ echo "Missing name"; exit();}
	    $rom=$device.'_'.$name.'_'.$type;
	    db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
	}
	else 
	{
		 db($rom,$val,$type,$device,$current,$ip,$gpio,$i2c,$usb,$name);
	} 
	

}
elseif (!defined('LOCAL')) {
    echo "no data\n";
    } 

} //end main
?>

