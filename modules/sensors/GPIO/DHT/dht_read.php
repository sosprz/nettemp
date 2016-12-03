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
    $query = $db->query("SELECT * FROM gpio WHERE mode='humid' OR mode='temp'");
    $result= $query->fetchAll();
    foreach($result as $g) {
		$gpios[$g['gpio']]=$g['humid_type'];
    }

	foreach($gpios as $gpio => $htype){
		$cmd("$ROOT/modules/sensors/GPIO/DHT/AdafruitDHT.py $htype $gpio");
		$out=shell_exec($cmd);
		$out = preg_split ('/$\R?^/m', $out);
		
		
		
		$device='';
		$current='';
		echo $date." Rom: ".$name." Value:".$output."\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		}

    
} catch (Exception $e) {
echo $date." Error.\n";
echo $e;
exit;
}
?>
