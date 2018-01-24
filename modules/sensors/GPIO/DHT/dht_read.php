<?php
$ROOT=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
 
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	include("$ROOT/receiver.php");
    $query = $db->query("SELECT * FROM gpio WHERE mode='humid'");
    $result= $query->fetchAll();
    $count = count($result);
	if ( $count >= '1'){
		foreach($result as $g) {
			$gpios[$g['gpio']]=$g['humid_type'];
		}
		foreach($gpios as $gpio => $htype){
		$cmd=("$ROOT/modules/sensors/GPIO/DHT/AdafruitDHT.py $htype $gpio");
		$out=shell_exec($cmd);
		$out = explode (" ",$out);
		$temp=trim($out[0]);
		$humid=trim($out[1]);
		$device='';
		$current='';
		
		if(!empty($temp)) {
		    $local_val=$temp;
		    $local_type='temp';
		    $local_device='gpio';
		    $local_gpio=$gpio;
			$local_rom="gpio_".$gpio."_".$local_type;
			echo $date." Rom: ".$local_rom." Value:".$local_val."\n";
			//db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			shell_exec('php-cgi -f /var/www/nettemp/receiver.php key=1234 rom=$local_rom device=$local_device type=$local_type value=$local_val');
			
			
		}
		
		if(!empty($humid)){
			$local_val=$humid;
			$local_type='humid';
			$local_device='gpio';
		    $local_gpio=$gpio;
			$local_rom="gpio_".$gpio."_".$local_type;
			echo $date." Rom: ".$local_rom." Value:".$local_val."\n";
			//db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		 shell_exec('php-cgi -f var/www/nettemp/receiver.php key=1234 rom=$local_rom device=$local_device type=$local_type value=$local_val');
		}

		}
	} else {
		echo $date." No sensors on GPIO.\n";
	}
    
} catch (Exception $e) {
echo $date." Error.\n";
echo $e;
exit;
}
?>
