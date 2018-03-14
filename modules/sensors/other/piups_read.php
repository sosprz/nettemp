<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
$date = date("Y-m-d H:i:s");
define("LOCAL","local");

function logs($content){
global $ROOT;

	$f = fopen("$ROOT/tmp/piups_log.txt", "a");

fwrite($f, $content);
fclose($f); 
}

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");

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
					
$query = $db->query("SELECT option,value FROM nt_settings WHERE option='ups_time_off' OR option='ups_toff_stop' OR  option='ups_toff_start' OR option='ups_count'");
$result = $query->fetchAll();
foreach($result as $a) {
						
	if($a['option']=='ups_count') {
	$count=$a['value'];
	}
	if($a['option']=='ups_time_off') {
	$ttoff=$a['value'];
	}
	if($a['option']=='ups_toff_stop') {
	$tshutdown=$a['value'];
	}				
}

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
	$content = date('Y M d H:i:s')." -"." Could not connect to the database.\n";
	logs($content);
    exit;
}

    include("$ROOT/receiver.php");
	$cmd=("exec 3<$dev && echo -n 'D\r' >$dev && head -1 <&3; exec 3<&-");
    $out=shell_exec($cmd);
    $out=trim($out);
    $data=explode(" ",$out);
    var_dump($out);
    var_dump($data);

    $types=array('volt','volt','volt','amps','watt','temp','battery','trigger','trigger','trigger','trigger');
    $echoes=array('UPS Volt IN','UPS Volt Akku','UPS Volt OUT','UPS Amps','UPS Watt','UPS Temp','UPS Battery','UPS Power Trigger','UPS Volt Trigger','UPS Akku Trigger','UPS Temp Trigger');

    if( count($data) != count($types) ){
        echo "Different number of array elements!\n";
		
		$content = date('Y M d H:i:s')." -"." Different number of array elements!\n";
		logs($content);
		
        exit;
    }else{
        $local_device='usb';
        $local_usb='$dev';
        for($i=0;$i<count($data);$i++){
            $local_rom='UPS_id'.($i+1);
            $local_val=$data[$i];
            $local_type=$types[$i];

            db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			
//trigger 230v action
			if (($local_rom == 'UPS_id9') && ($local_val == '1')) {
				
					//echo "Power 230 off\n";
					//$content = date('Y M d H:i:s')." -"." Power 230 is off\n";
					//logs($content);
										
					if ($count == '1') {
						
						 if ( time() > $tshutdown) {
							 
							 echo "--- Malina OFF ---\n"; 
							 
							 $content = date('Y M d H:i:s')." -"." Power 230V is off. Rpi shutdown now. \n";
							 logs($content);
							 
							 $db->exec("UPDATE nt_settings SET value='0' WHERE option='ups_count'");
							 system ("sudo /sbin/shutdown -h now");
							 							 
							 } else {
									echo "--- Malina ON ---\n"; echo time(); echo " "; echo $tshutdown."\n";  
									$content = date('Y M d H:i:s')." -"." Power 230V is off. Rpi counts the time to shutdown system.\n";
									logs($content);
									}
						 
					}else {
				
					echo $ttoff."\n";
					echo time()."\n";
					$timecountstart = time();
					$timewhenoff = $timecountstart + ($ttoff*60);
					
					echo $timewhenoff."\n";
					 $db->exec("UPDATE nt_settings SET value='$timecountstart' WHERE option='ups_toff_start'");
					 $db->exec("UPDATE nt_settings SET value='$timewhenoff' WHERE option='ups_toff_stop'");
					 $db->exec("UPDATE nt_settings SET value='1' WHERE option='ups_count'");
					 
					$content = date('Y M d H:i:s')." -"." Power 230V is off. Rpi counts the time to shutdown system.\n";
					logs($content);
					}
					
				} elseif (($local_rom == 'UPS_id9') && ($local_val == '0')) {echo "Power 230 on\n";} 
				
//trigger Battery discharged action

				if (($local_rom == 'UPS_id10') && ($local_val == '1')) {
					
					$db->exec("UPDATE nt_settings SET value='0' WHERE option='ups_count'");
					echo "Battery discharged. Rpi goes to sleep.\n";
					$content = date('Y M d H:i:s')." -"." Battery discharged. Rpi shutdown now.\n";
					logs($content);
					system ("sudo /sbin/shutdown -h now");
					
				}
		}		
    }

} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>