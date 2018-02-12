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
    include("$ROOT/receiver.php");
    $query = $db->query("SELECT dev FROM usb WHERE device='UPS Pimowo'");
    $result= $query->fetchAll();
    foreach($result as $r) {
		$dev=$r['dev'];
    }
    if($dev=='none'){
		echo $date." No UPS Pimowo USB Device.\n";
		exit;
	}
	$dev2=str_replace("/dev/","",$dev);
	$cmd=("exec 3<$dev && echo \"D\" >$dev && head -1 <&3; exec 3<&-");
	$out=shell_exec($cmd);;
	var_dump($out);
	
	$local_device='USB';
	$local_usb='$dev';
	$local_type='volt';
	$local_rom="usb_".$dev2."_".$local_type;
	echo $date." UPS Pimowo Volt: ".$out[0]."\n";
	db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

	$local_device='USB';
	$local_usb='$dev';
	$local_type='amps';
	$local_rom="usb_".$dev2."_".$local_type;
	echo $date." UPS Pimowo Amps: ".$out[1]."\n";
	b($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
