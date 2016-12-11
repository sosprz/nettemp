<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
$date = date("Y-m-d H:i:s"); 
define("LOCAL","local");


//exec("pgrep -f 'php '.$ROOT.'/modules/sensors/rs485/sdm630.php'",$response);
//    if ($response)
//    {
//	echo $date." SDM630 Running.\n";
//	exit;
 //   } 

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
    }
    if($dev=='none'){
		echo $date." No RS485 USB Device.\n";
		exit;
	}
    $dev=str_replace("/dev/","",$dev);
	$query = $db->query("SELECT addr FROM rs485 WHERE dev='SDM630'");
	$result= $query->fetchAll();
    foreach($result as $r) {
	$addr=$r['addr'];
	echo $date." RS485 ".$dev." ".$addr."\n";

    	$cmd="$ROOT/modules/sensors/rs485/sdm630_get.sh /dev/$dev $addr";
		$res=shell_exec($cmd);
		$res = preg_split ('/$\R?^/m', $res);
		foreach ($res as $l) {
			$line[]=trim($l);
		}
			
		//L1
		$local_type='volt';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[0];
		$device='';
		$current='';
		echo $date." SDM630 L1 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[1];
		$device='';
		$current='';
		echo $date." SDM630 L1 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[2];
		$device='';
		$current='';
		echo $date." SDM630 L1 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);

		//L2
		$local_type='volt';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[3];
		$device='';
		$current='';
		echo $date." SDM630 L2 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[4];
		$device='';
		$current='';
		echo $date." SDM630 L2 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[5];
		$device='';
		$current='';
		echo $date." SDM630 L2 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		//L3
		$local_type='volt';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[6];
		$device='';
		$current='';
		echo $date." SDM630 L3 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[7];
		$device='';
		$current='';
		echo $date." SDM630 L3 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[8];
		$device='';
		$current='';
		echo $date." SDM630 L3 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$device,$current);
		
		
		$local_val=$line[9];
		$local_type='elec';
		echo $date." SDM630 suma energii biernej ".$local_val." ".$local_type.".\n";
		
		$local_type='var';
		$local_val=$line[10];
		echo $date." SDM630 export energii czynnej ".$local_val." ".$local_type.".\n";
		
		$local_val=$line[11];
		$local_type='var';
		echo $date." SDM630 eksport energii biernej ".$local_val." ".$local_type.".\n";
		
		$local_val=$line[12];
		$local_type='var';
		echo $date." SDM630 import energii biernej ".$local_val." ".$local_type.".\n";
		
		
		// SUM
		
		//GET LAST
		$local_type='elec';
		$local_rom="usb_".$dev."a".$addr."_".$local_type;
		$device='usb';
		$last='';
		$WATsum=trim($line[2]+$line[5]+$line[8]);
		$ALL=trim($line[9]);
		$query = $db->query("SELECT sum FROM sensors WHERE rom='$local_rom'");
		$result= $query->fetchAll();
		foreach ($result as $r) {
			$last=trim($r['sum']);
		}
		$VAL=$ALL-$last;
		
		
		//echo "1. ".$last."\n";
		//echo "2. ".$WATsum."\n";
		//echo "3. ".$ALL."\n";
		//echo "4. ".$VAL."\n";
		
		if($last!=0){
			$local_val=$VAL;
			$current=$WATsum;
			db($local_rom,$local_val,$local_type,$device,$current);
			$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
		} else {
			$local_val='0';
			$current='';
			db($local_rom,$local_val,$local_type,$device,$current);
			$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
		}
	}




} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
