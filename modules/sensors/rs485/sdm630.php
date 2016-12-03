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
    $query = $db->query("SELECT dev FROM usb WHERE device='RS485'");
    $result= $query->fetchAll();
    foreach($result as $r) {
		$dev=$r['dev'];
		//$dev='/dev/ttyUSB0'; //
    }
    if($dev=='none'){
		echo $date." No RS485 USB Device.\n";
		exit;
	}
    $dev=str_replace("/dev/","",$dev);
    echo $dev."\n";
	$query = $db->query("SELECT addr FROM rs485 WHERE dev='SDM630'");
	$result= $query->fetchAll();
	$result=array('1');
    foreach($result as $r) {
		$addr=$r['addr'];
		//$addr='1'; //
    
    	$cmd="$ROOT/modules/sensors/rs485/sdm630_get.sh /dev/$dev $addr";
		$res=shell_exec($cmd);
		$res = preg_split ('/$\R?^/m', $res);
		foreach ($res as $l) {
			$line[]=$l;
		}
			
		//var_dump($line);
		//L1
		$local_type='volt';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[0];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[1];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[2];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		//L2
		$local_type='volt';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[3];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[4];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[5];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		//L3
		$local_type='volt';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[6];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[7];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[8];
		$device='';
		$current='';
		db($local_rom,$local_val,$local_type,$device,$current);
		
		
		
		// SUM
		
		//GET LAST
		$local_type='elec';
		$local_rom="usb_".$dev."a".$addr."_".$local_type;
		$device='';
		$last='';
		$WATsum=trim($line[2]+$line[5]+$line[8]);
		$ALL=trim($line[9]);
		$query = $db->query("SELECT sum FROM sensors WHERE rom='$local_rom'");
		$result= $query->fetchAll();
		foreach ($result as $r) {
			$last=trim($r['sum']);
		}
		$VAL=$ALL-$last;
		
		
		echo "1. ".$last."\n";
		echo "2. ".$WATsum."\n";
		echo "3. ".$ALL."\n";
		echo "4. ".$VAL."\n";
		
		if($last!=0){
			$local_val=$VAL;
			$current=$WATsum;
			db($local_rom,$local_val,$local_type,$device,$current);
			$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
			echo $local_val."\n";
		} else {
			$local_val='0';
			$current='';
			db($local_rom,$local_val,$local_type,$device,$current);
			$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
			echo "zzzz";
			
		}
	}




} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
