<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 
$local_device='i2c';


function read($addr,$name,$bus) {
	include("$ROOT/receiver.php");
	$block='';
	
	function write($output,$index,$type,$addr){
			$output = trim($output[$index]);
			$local_type=$type;
			$local_val=$output;
			$local_i2c=$addr;
			$local_rom="i2c_".$i2c."_".$type;
			echo $date." Rom:".$local_rom." Addr:".$local_addr." Bus:".$bus." Value:".$output."\n";
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			unset($output);
	}
	
	
	
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

	//htu21d	
	elseif($name=='htu21d') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/HTU21D/htu21d.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						$output = preg_split ('/$\R?^/m', $output);
						//temp,humid
						//var_dump($output);
						$output0 = trim($output[0]);
						$output1 = trim($output[1]);
						$output = '';
					}
					if($rr['type']=='temp') {
						$output = $output0;
						$output0 = '';
					} elseif ($rr['type']=='humid') {
						$output = $output1;
						$output1 = '';
					}
				//mpl3115a2	
			    } elseif($name=='mpl3115a2') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/MPL3115A2/read.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						$output = preg_split ('/$\R?^/m', $output);
						//temp,press
						//var_dump($output);
						$output0 = trim($output[0]);
						$output1 = trim($output[1]);
						$output = '';
					}
					if($rr['type']=='temp') {
						$output = $output0;
						$output0 = '';
					} elseif ($rr['type']=='press') {
						$output = $output1;
						$output1 = '';
					}
				//hih6130	
			    } elseif($name=='hih6130') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/HIH6130/read.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						//humid, temp
						$output = preg_split ('/$\R?^/m', $output);
						//var_dump($output);
						$output0 = trim($output[0]);
						$output1 = trim($output[1]);
						$output = '';
					}
					if($rr['type']=='temp') {
						$output = $output1;
						$output0 = '';
					} elseif ($rr['type']=='humid') {
						$output = $output0;
						$output1 = '';
					}
				//bmp180	
			    } elseif($name=='bmp180') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/BMP180/bmp180.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						$output = preg_split ('/$\R?^/m', $output);
						//temp,press
						//var_dump($output);
						$output0 = trim($output[0]);
						$output1 = trim($output[1]);
						$output = '';
					}
					if($rr['type']=='temp') {
						$output = $output0;
						$output0 = '';
					} elseif ($rr['type']=='press') {
						$output = $output1;
						$output1 = '';
					}
				//tsl2561	
			    } elseif($name=='tsl2561') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/TSL2561/TSL2561_i2c_$bus";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						preg_match('/(\d+)/', $output, $output);
						$output0=$output[1];
						$output = '';
					}
					if($rr['type']=='lux') {
						$output = $output0;
						$output0 = '';
					} 
				//bh1750	
			    } elseif($name=='bh1750') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/BH1750/bh1750.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						$output = preg_split ('/$\R?^/m', $output);
						//lux
						var_dump($output);
						$output0 = trim($output[0]);
						$output = '';
					}
					if($rr['type']=='lux') {
						$output = $output0;
						$output0 = '';
					}
				}
				
				$local_rom=$rr['rom'];
				$local_type=$rr['type'];
				$local_val=$output;
				$local_device='i2c';
				$local_i2c=$addr;
				echo $date." Name:".$rr['name']." Rom:".$rr['rom']." Addr:".$qa['addr']." Bus:".$bus." Value:".$output."\n";
				db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
				unset($output);
	
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

foreach($bus as $id => $key) {
	$a=array();
	if(file_exists("/dev/i2c-$id")){
		$cmd="i2cdetect -y ".$id." |sed '1d' |cut -d \" \" -f 2-";
		$out=shell_exec($cmd);
		$out=str_replace("--","",$out);
		$out = array_filter(explode(' ', $out));
		foreach($ai2c as $addr => $name){
			foreach($out as $oaddr){
				$oaddr=trim($oaddr);
				if(!empty($oaddr)&&$oaddr==$addr) {
					echo $key." ".$oaddr." ".$name."\n";
				
				}
			}
		}
	}
}



?>
