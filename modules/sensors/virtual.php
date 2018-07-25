<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
 
include("$ROOT/receiver.php");	

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}


try {
    $sth = $db->query("SELECT * FROM sensors WHERE device = 'virtual'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	
	
	foreach ($result as $vr) {
		
		
	if (substr($vr['type'],0,3) == 'air'){
			
			$lati = $vr['latitude'];
			$long = $vr['longitude'];
			$api = $vr['apikey'];
			$localid = $vr['id'];
			$local_rom = $vr['rom'];
			$local_type = $vr['type'];
			$local_device = $vr['device'];
			
	$url = "https://airapi.airly.eu/v1/nearestSensor/measurements?latitude=$lati&longitude=$long&maxDistance=1000&apikey=$api";
	$json = file_get_contents($url);
	
	$obj = json_decode($json,true);
	
	if ($local_type == "airquality") {
		$local_val = round($obj["airQualityIndex"]);
	}elseif ($local_type == "air_pm_25") {
		$local_val = round($obj["pm25"]);
	}elseif ($local_type == "air_pm_10") {
		$local_val = round($obj["pm10"]);
	}
		
		echo $local_rom."\n";
		echo $local_val."\n";
		echo $local_type."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			
			
	}
	
	if (substr($vr['type'],0,3) == 'max'){
		
		
			$local_rom = $vr['rom'];
			$local_type = $vr['type'];
			$local_device = $vr['device'];
			
			$bindrom = $vr['bindsensor'];
			$file=$bindrom .".sql";
			
			
			$db1 = new PDO("sqlite:$ROOT/db/$file");
			
			if ($local_type == "max24"){
				
				$val = $db1->query("SELECT max(value) AS m24max from def WHERE time BETWEEN datetime('now','localtime','-1 day') AND datetime('now','localtime') ") or die('max24');
				$val = $val->fetch(); 
				$local_val = $val['m24max'];
				
			} elseif  ($local_type == "maxweek"){
				
				$val = $db1->query("SELECT max(value) AS mweek from def WHERE time BETWEEN datetime('now','localtime','-7 day') AND datetime('now','localtime') ") or die('maxweek');
				$val = $val->fetch(); 
				$local_val = $val['mweek'];
				
			} elseif  ($local_type == "maxmonth"){
				
				$val = $db1->query("SELECT max(value) AS mmonth from def WHERE time BETWEEN datetime('now','localtime','-1 months') AND datetime('now','localtime') ") or die('maxmonth');
				$val = $val->fetch(); 
				$local_val = $val['mmonth'];
				
			}
		
		echo $local_rom."\n";
		echo $local_val."\n";
		echo $local_type."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);		
	}
	
	if (substr($vr['type'],0,3) == 'sun'){
			
			$lati = $vr['latitude'];
			$long = $vr['longitude'];
			$tz = $vr['timezone'];
			$localid = $vr['id'];
			$local_rom = $vr['rom'];
			$local_type = $vr['type'];
			$local_device = $vr['device'];
			
			if ($local_type == "sunrise"){	
				$local_val = (date_sunrise(time(),SUNFUNCS_RET_TIMESTAMP,$lati,$long,90.83,$tz));
			} elseif  ($local_type == "sunset"){
				$local_val = (date_sunset(time(),SUNFUNCS_RET_TIMESTAMP,$lati,$long,90.83,$tz));	
			}
			
		echo $local_rom."\n";
		echo $local_val."\n";
		echo date('H:i', $local_val)."\n";
		echo $local_type."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);	

	}

	}

} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>

