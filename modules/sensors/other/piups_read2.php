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
   // $query = $db->query("SELECT dev FROM usb WHERE device='UPS Pimowo'");
   // $result= $query->fetchAll();
  // foreach($result as $r) {
    // $dev=$r['dev'];
  //  }
    // if($dev=='none'){
    //  echo $date." No UPS Pimowo USB Device.\n";
     // exit;
   // }
   // unset($db);
   echo exec('whoami');
	include("$ROOT/php_serial_class.php");
    include("$ROOT/receiver.php");
	
	echo exec('whoami');

	
	$serial = new phpSerial;
	
	$serial->deviceSet("/dev/ttyUSB0");
	$serial->confBaudRate(9600);
	$serial->confParity("none");
	$serial->confCharacterLength(8);
	$serial->confStopBits(1);
	$serial->confFlowControl("none");
	$serial->deviceOpen();
	
	$serial->sendMessage("D\r");
	
	$out = $serial->readPort();
	

    //$cmd=("exec 3</dev/ttyUSB0 && echo -n 'D\r' >/dev/ttyUSB0 && head -1 <&3; exec 3<&-");
	
    //$out=shell_exec($cmd);
   $out=trim($out);
   $data=explode(" ",$out);
   var_dump($out);
   var_dump($data);
	

    $types=array('volt','volt','volt','amps','watt','temp','battery','trigger','trigger','trigger');
    $echoes=array('UPS Volt IN','UPS Volt Akku','UPS Volt OUT','UPS Amps','UPS Watt','UPS Temp','UPS Battery','UPS Power Trigger','UPS Volt Trigger','UPS Akku Trigger');

    if( count($data) != count($types) ){
        echo "Different number of array elements!\n";
        exit;
    }else{
        $local_device='usb';
        $local_usb=$dev;
        for($i=0;$i<count($data);$i++){
            $local_rom='UPS_id'.($i+1);
            $local_val=$data[$i];
            $local_type=$types[$i];
            echo $date.' '.$echoes[$i].': '.$data[$i]."\n";
            db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
        }
    }

} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>