<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
 
$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}
try {
    $sth = $db->query("SELECT * FROM nt_settings");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) {
		if($a['option']=='domoip') {
			$domoticz_ip=$a['value'];
		}
		if($a['option']=='domoport') {
			 $domoticz_port=$a['value'];
		}
		if($a['option']=='domoon') {
			 $domoticz_on=$a['value'];
		}
	}
    
    if(!empty($domoticz_ip)&&!empty($domoticz_port) && $domoticz_on=='on'){
		$query = $db->query("SELECT * FROM sensors WHERE domoticz='on' and domoticzidx!=''");
		$result= $query->fetchAll();
		foreach($result as $s) {

			$name=$s['name'];
			$value=$s['tmp'];
			$type=$s['type'];
			$idx=$s['domoticzidx'];
			$current=$s['current'];
			
			if ($type == 'elec' ){
				$value2=$value*1000;
				$URL="$domoticz_ip:$domoticz_port/json.htm?type=command&param=udevice&idx=$idx&nvalue=0&svalue=$current;$value2";
			}else {
				$URL="$domoticz_ip:$domoticz_port/json.htm?type=command&param=udevice&idx=$idx&nvalue=0&svalue=$value";
			}
				
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "admin:" . $cauth_pass);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $name."\n";
			echo $URL."\n";
			echo $server_output;
		}
    }


} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>

