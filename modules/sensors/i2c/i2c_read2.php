<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 

include_once("$ROOT/receiver.php");

function write($output,$index,$type,$addr){
	global $ROOT;
	global $date;
	
	global $local_rom;
	global $local_type;
	global $local_val;
	global $local_device;
	global $local_i2c;
	global $local_current;
	global $local_name;
	global $local_ip;
	global $local_gpio;
	global $local_usb;

	$output = trim($output[$index]);
	$local_device='i2c';
    $local_type=$type;
    $local_val=$output;
    $local_i2c=$addr;
    $local_rom="i2c_".$local_i2c."_".$type;
    echo $date." Rom:".$local_rom." Addr:".$local_i2c." Bus:".$bus." Value:".$output."\n";
    db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
    unset($output);
}


function read($addr,$name,$bus){

	global $ROOT;
	global $date;
	
	
	//TMP102
	if($name=='tmp102') {
			$cmd="$ROOT/modules/sensors/i2c/TMP102/read.py $bus $addr";
			echo $date." Running: ".$cmd."\n";
			
			$output = shell_exec($cmd);
			$output = trim($output);
			
			$atype=array("temp");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr);
			}
	}
	//bme280
	elseif($name=='bme280') {
			$block=$addr;
			$cmd="$ROOT/modules/sensors/i2c/BME280/bme280.py $bus $addr";
			echo $date." Running: ".$cmd."\n";
			
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);
			
			$atype=array("temp","press","humid");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr);
			}
	}

}




$bus=shell_exec("i2cdetect -l |awk {'print $1'}");
$bus=explode("\n", $bus);

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db") or die ("cannot open database");
$rows = $db->query("SELECT * FROM i2c");
$row = $rows->fetchAll();
foreach($row as $i2c) {
	$ai2c[$i2c['addr']]=$i2c['name'];
	echo "I2C Adress: ".$i2c['addr']." Name: ".$i2c['name']."\n";
}

echo "Scanning...\n";

foreach($bus as $bus) {
	$a=array();
	$bus=str_replace("i2c-","",$bus);
	if(file_exists("/dev/i2c-$bus")){
		$cmd="i2cdetect -y ".$bus." |sed '1d' |cut -d \" \" -f 2-";
		$out=shell_exec($cmd);
		$out=str_replace("--","",$out);
		$out = array_filter(explode(' ', $out));
		foreach($ai2c as $addr => $name){
			foreach($out as $oaddr){
				$oaddr=trim($oaddr);
				if(!empty($oaddr)&&$oaddr==$addr) {
					echo $date." I2C bus: ".$bus." I2C addres: ".$oaddr." I2C device: ".$name."\n";
					read($addr,$name,$bus);
				
				}
			}
		}
	}
}



?>
