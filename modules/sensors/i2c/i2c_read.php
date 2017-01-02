<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 

include_once("$ROOT/receiver.php");

function write($output,$index,$type,$addr,$bus){
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
			
			$output = shell_exec($cmd);
			$output= preg_split('/\s+/', trim($output));
			
			$atype=array("temp");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}
	}
	//bme280
	elseif($name=='bme280') {
			$cmd="$ROOT/modules/sensors/i2c/BME280/bme280.py $bus $addr";
			
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);
			
			$atype=array("temp","press","humid");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}
	}
	//htu21d
	elseif($name=='htu21d') {
			$cmd="$ROOT/modules/sensors/i2c/HTU21D/htu21d.py $bus $addr";
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);

			$atype=array("temp","humid");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}
	}
	//mpl3115a2
	elseif($name=='mpl3115a2') {
			$cmd="$ROOT/modules/sensors/i2c/MPL3115A2/read.py $bus $addr";
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);
			
			$atype=array("press","temp");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}
	}
	//hih6130	
	elseif($name=='hih6130') {
			$cmd="$ROOT/modules/sensors/i2c/HIH6130/read.py $bus $addr";
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);
						
			$atype=array("humid","temp");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}			
	}
	//bmp180	
	elseif($name=='bmp180') {
			$cmd="$ROOT/modules/sensors/i2c/BMP180/bmp180.py $bus $addr";
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);

			$atype=array("temp","press");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}	
	} 
	//tsl2561	
	elseif($name=='tsl2561') {
			$cmd="$ROOT/modules/sensors/i2c/TSL2561/TSL2561_i2c_$bus";
			$output = shell_exec($cmd);
			preg_match('/(\d+)/', $output, $output);

			$atype=array("lux");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
			}	

	}	
	//bh1750	
	elseif($name=='bh1750') {
			$cmd="$ROOT/modules/sensors/i2c/BH1750/bh1750.py $bus $addr";
			$output = shell_exec($cmd);
			$output = preg_split ('/$\R?^/m', $output);

			$atype=array("lux");
			foreach($atype as $index => $type){ 
				write($output,$index,$type,$addr,$bus);
				}	
	}
	elseif($name=='ds2482') {
		$dsfile = "$ROOT/tmp/ds2482";
		
		if(!file_exists("$dsfile"))
		{
			$fh = fopen($dsfile, 'w');
			fwrite($fh, "modprobe ds2482\n");
			fwrite($fh, "modprobe w1-therm strong_pullup=0\n");
			fwrite($fh, "echo ds2482 0x18 > /sys/bus/i2c/devices/i2c-$bus/new_device\n");
			fwrite($fh, "echo ds2482 0x19 > /sys/bus/i2c/devices/i2c-$bus/new_device\n");
			fwrite($fh, "echo ds2482 0x1A > /sys/bus/i2c/devices/i2c-$bus/new_device\n");
			fwrite($fh, "echo ds2482 0x1B > /sys/bus/i2c/devices/i2c-$bus/new_device\n");
			fwrite($fh, "exit 0\n");
			fclose($fh);
			shell_exec("sudo chmod +x $dsfile");
		}
		else 
		{
			echo $date." ".$dsfile." already exist\n";
		}
		
		if(!file_exists('/etc/init.d/nettemp.ds2482'))
		{
			shell_exec("sudo cp $ROOT/install/1w/nettemp.ds2482 /etc/init.d/");
			shell_exec("sudo update-rc.d nettemp.ds2482 defaults");
			shell_exec("sudo service nettemp.ds2482 start");
			shell_exec("sudo touch $ROOT/tmp/reboot");
			echo $date." copy nettemp.ds2482 to init.d done\n";
		} 
		else 
		{
			echo $date." nettemp.ds2482 already in init.d\n";
		}
		
	}

}




$bus=shell_exec("/usr/sbin/i2cdetect -l |awk {'print $1'}");
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
		$cmd="/usr/sbin/i2cdetect -y ".$bus." |sed '1d' |cut -d \" \" -f 2-";
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
