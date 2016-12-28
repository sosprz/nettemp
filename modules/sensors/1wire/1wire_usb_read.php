<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
 
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
	include(dirname(dirname(dirname(dirname(__FILE__))))."/receiver.php");
    $query = $db->query("SELECT usb FROM device");
    $result= $query->fetchAll();
    foreach($result as $r) {
		$usb=$r['usb'];
	}
		if($usb!='off') {
			$file_digi2 = file("$ROOT/tmp/.digitemprc");
			foreach($file_digi2 as $line_digi) {
				if(strstr($line_digi,"ROM")) { 
					$trim_line_digi=trim($line_digi);
					list($rom, $nr, $id1, $id2, $id3, $id4, $id5, $id6, $id7, $id8 ) = explode(" ", $trim_line_digi);
					$rom="$id1$id2$id3$id4$id5$id6$id7$id8";
					$rom2= "$id1 $id2 $id3 $id4 $id5 $id6 $id7 $id8";
					$cmd="/usr/bin/digitemp_$usb -c $ROOT/tmp/.digitemprc -t $rom2 -q -o%.1C";
					$output=shell_exec($cmd);
					$output=trim($output);
				echo $date." Rom: ".$rom." Value:".$output."\n"; 
				$local_rom=$rom;
				$local_val=$output;
				$local_type='temp';
				$local_device='usb';
				db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);


				}
			}
		}
	
   
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}



?>
