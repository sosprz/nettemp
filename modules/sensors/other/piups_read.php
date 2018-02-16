<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
$date = date("Y-m-d H:i:s");
define("LOCAL","local");

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
$query = $db->query("SELECT value FROM nt_settings WHERE option='ups_time_off'");
					$result= $query->fetchAll();
					foreach($result as $r) {
					$ttoff=$r['value'];
					}
					
$query = $db->query("SELECT value FROM nt_settings WHERE option='ups_toff_start'");
					$result= $query->fetchAll();
					foreach($result as $r) {
					$tshutdown=$r['value'];
					}

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
    $query = $db->query("SELECT dev FROM usb WHERE device='PiUPS'");
    $result= $query->fetchAll();
    foreach($result as $r) {
     $dev=$r['dev'];
    }
    if($dev=='none'){
    echo $date." No PiUPS USB Device.\n";
    exit;
    }
    //unset($db);

    include("$ROOT/receiver.php");
	$cmd=("exec 3<$dev && echo -n '\r' >$dev && echo -n 'D\r' >$dev && head -1 <&3; exec 3<&-");
	
	//echo $cmd."\n";
    $out=shell_exec($cmd);
	//echo $out."\n";
    $out=trim($out);
    $data=explode(" ",$out);
    //var_dump($out);
    //var_dump($data);
	//echo $dev."\n";
	
	$types=array('volt','volt','volt','amps','watt','temp','battery','trigger','trigger','trigger');
    $echoes=array('UPS Volt IN','UPS Volt Akku','UPS Volt OUT','UPS Amps','UPS Watt','UPS Temp','UPS Battery','UPS Power Trigger','UPS Volt Trigger','UPS Akku Trigger');

   // $types=array('volt','volt','volt','amps','watt','temp','battery','trigger','trigger','trigger','trigger');
   // $echoes=array('UPS Volt IN','UPS Volt Akku','UPS Volt OUT','UPS Amps','UPS Watt','UPS Temp','UPS Battery','UPS Power Trigger','UPS Volt Trigger','UPS Akku Trigger','UPS Temp Trigger');

    if( count($data) != count($types) ){
        echo "Different number of array elements!\n";
        exit;
    }else{
        $local_device='usb';
        $local_usb='$dev';
        for($i=0;$i<count($data);$i++){
            $local_rom='UPS_id'.($i+1);
            $local_val=$data[$i];
            $local_type=$types[$i];
            //echo $date.' '.$echoes[$i].': '.$data[$i]."\n";
            db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			
			if (($local_rom == 'UPS_id9') && ($local_val == '0')) {
				
					echo "Power 230 off\n";
					
					$query = $db->query("SELECT value FROM nt_settings WHERE option='ups_count'");
					$result2= $query->fetchAll();
					foreach($result2 as $r) {
					$count=$r['value'];
					}
					
					if ($count == '1') {
						
					
				
						
						 if ( time() > $tshutdown) {echo "--- Malina OFF ---\n"; } else {echo "--- Malina ON ---\n"; echo time(); echo " "; echo $tshutdown;  }
						 
					}else {
				
					//$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
					$query = $db->query("SELECT value FROM nt_settings WHERE option='ups_time_off'");
					$result= $query->fetchAll();
					foreach($result as $r) {
					$ttoff=$r['value'];
					}
					echo $ttoff."\n";
					echo time()."\n";
					$timewhenoff = time() + ($ttoff*60);
					
					echo $timewhenoff."\n";
					 $db->exec("UPDATE nt_settings SET value='$timewhenoff' WHERE option='ups_toff_start'");
					 $db->exec("UPDATE nt_settings SET value='1' WHERE option='ups_count'");
					}
					
				} 
				
				
				
				
			elseif (($local_rom == 'UPS_id9') && ($local_val == '1')) {echo "Power 230 on\n";} 
		}		
    }

} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>