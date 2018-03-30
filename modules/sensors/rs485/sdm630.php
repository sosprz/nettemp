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
		$dev0=$r['dev'];
    }
    if($dev0=='none'){
		echo $date." No RS485 USB Device.\n";
		exit;
	}
    $dev=str_replace("/dev/","",$dev0);
	$query = $db->query("SELECT addr, baudrate FROM rs485 WHERE dev='SDM630'");
	$result= $query->fetchAll();
    foreach($result as $r) {
		$addr=$r['addr'];
		$brate=$r['baudrate'];
		
		echo $date." RS485 ".$dev0." ".$addr." ".$brate."\n";
    	$cmd="$ROOT/modules/sensors/rs485/sdm630_get.sh $dev0 $addr $brate";
		$res=shell_exec($cmd);
		$res = preg_split ('/$\R?^/m', $res);
		foreach ($res as $l) {
			$line[]=trim($l);
		}
			
		//L1
		$local_type='volt';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[0];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L1 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[1];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L1 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L1a".$addr."_".$local_type;
		$local_val=$line[2];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L1 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

		//L2
		$local_type='volt';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[3];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L2 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[4];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L2 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L2a".$addr."_".$local_type;
		$local_val=$line[5];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L2 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		//L3
		$local_type='volt';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[6];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L3 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='amps';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[7];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L3 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='watt';
		$local_rom="usb_".$dev."L3a".$addr."_".$local_type;
		$local_val=$line[8];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." SDM630 L3 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_val=$line[9];
		echo $date." SDM630 import energii czynnej ".$local_val." kWh \n";

		$local_val=$line[11];
		$local_type='var';
		$local_device='usb';
		$local_usb=$dev0;
		$local_rom="usb_".$dev."a".$addr."exp_".$local_type;
		echo $date." SDM630 export energii czynnej ".$local_val." ".$local_type.".\n";
		
		$local_type='elec';
		$local_val=$line[10];
		$local_device='usb';
		$local_usb=$dev0;
		$local_rom="usb_".$dev."a".$addr."sum_".$local_type;
		echo $date." SDM630 suma energii biernej ".$local_val." ".$local_type.".\n";
		
		$local_val=$line[12];
		$local_type='var';
		$local_device='usb';
		$local_usb=$dev0;
		$local_rom="usb_".$dev."a".$addr."expb_".$local_type;
		echo $date." SDM630 eksport energii biernej ".$local_val." ".$local_type.".\n";
		
		$local_val=$line[13];
		$local_type='var';
		$local_device='usb';
		$local_usb=$dev0;
		$local_rom="usb_".$dev."a".$addr."impb_".$local_type;
		echo $date." SDM630 import energii biernej ".$local_val." ".$local_type.".\n";
		
		
		//IMPORT
		$local_type='elec';
		$local_rom="usb_".$dev."a".$addr."_".$local_type;
		$local_device='usb';
		$local_usb=$dev0;
		$last='';
		$WATsum=trim($line[2])+trim($line[5])+trim($line[8]);
		$ALL=trim($line[9]);
		$query = $db->query("SELECT sum FROM sensors WHERE rom='$local_rom'");
		$result= $query->fetchAll();
		foreach ($result as $r) {
			$last=trim($r['sum']);
		}
		$VAL=trim($ALL-$last);
		//$VAL=number_format($VAL, 3, '.', '');
		
		echo "1. last ".$last."\n";
		echo "2. WAT sum ".$WATsum."\n";
		echo "3. all ".$ALL."\n";
		echo "4. val ".$VAL."\n";

		if($last!=0){
			$local_val=$VAL;
			//$local_current=$WATsum;
			//db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			//$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
		} 
		else {
			$local_val='0';
			//$local_current='';
			//db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			//$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
		}
		$local_current=$WATsum;
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");		

		//EXPORT

		$local_type='elec';
		$local_rom="usb_".$dev."a".$addr."EXP_".$local_type;
		$local_device='usb';
		$local_usb=$dev0;
		$last='';
		$WATsum=trim($line[2])+trim($line[5])+trim($line[8]);
		$ALL=trim($line[11]);
		$query = $db->query("SELECT sum FROM sensors WHERE rom='$local_rom'");
		$result= $query->fetchAll();
		foreach ($result as $r) {
			$last=trim($r['sum']);
		}
		$VAL=trim($ALL-$last);
		
		
		#echo "1. ".$last."\n";
		#echo "2. ".$WATsum."\n";
		#echo "3. ".$ALL."\n";
		#echo "4. ".$VAL."\n";
		
		if($last!=0){
			$local_val=$VAL;
			
		} else {
			$local_val='0';
		}
		$local_current=$WATsum;
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		$db->exec("UPDATE sensors SET sum='$ALL' WHERE rom='$local_rom'");
		
		
		
	}




} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
