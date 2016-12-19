<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
 
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $mgs."Could not connect to the database.\n";
    exit;
}

try {
    $query = $db->query("SELECT onewire FROM device");
    $result= $query->fetchAll();
    foreach($result as $r) {
	$onewire=$r['onewire'];
    }
    if($onewire=='on') {
	include(dirname(dirname(dirname(dirname(__FILE__))))."/receiver.php");
	$query = $db->query("SELECT * FROM sensors WHERE rom LIKE '28-%' OR rom LIKE '10-%' OR rom LIKE '3b-%'");
	$result= $query->fetchAll();
	foreach($result as $n) {
	     if (file_exists("/sys/bus/w1/devices/".$n['rom']."/w1_slave")) {
		 $cmd="cat /sys/bus/w1/devices/".$n['rom']."/w1_slave | grep t= | cut -f2 -d= | awk '{print $1/1000}'";
		 $output = shell_exec($cmd);
		 $output = trim($output);
		 $output = number_format($output, 1, '.', '');
		 $local_val = $output;
		 $local_type = $n['type'];
		 $local_rom = $n['rom'];
		 $msg = $date." ".$n['name'];
		 $local_device='1wire';
		 echo $msg." ".$local_val."\n";
		 db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
	     }
	}
    }
} catch (Exception $e) {
    echo $msg." Error.\n";
    echo $e;
    exit;
}



?>
