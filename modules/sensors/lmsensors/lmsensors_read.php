<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
$date = date("Y-m-d H:i:s"); 
define("LOCAL","local");

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
    $query = $db->query("SELECT lmsensors FROM device where id='1'");
    $result= $query->fetchAll();
    foreach($result as $r) {
		$lm=$r['lmsensors'];
    }
    if($lm=='on'){
		$cmd="sensors |grep -E 'temp[0-9]|Core [0-9]'";
		$temp=shell_exec($cmd);
		$out = preg_split ('/$\R?^/m', $temp);
		foreach($out as $lin){
			$lin=strstr($lin, '°C', true);
			$lin=str_replace("+","",$lin);
			$li[] = explode(":", $lin);
		}
		include("$ROOT/receiver.php");
		foreach($li as $da) {
			$local_rom=trim("lmsensors_".str_replace(' ', '', $da[0])."_temp");
			$local_val=trim($da[1]);
			$local_type='temp';
			$local_device='lmsensors';
			$name=substr(rand(), 0, 4);
			$local_name=$name;
			$local_current='';
			$local_usb='';
			$local_i2c='';
			$local_ip='';
			$local_gpio='';
			echo $date." Rom:".$local_rom." Value:".$local_val."\n";
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		}
	} else {
		echo $date." Lmsensors OFF\n";
	}
	
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>


