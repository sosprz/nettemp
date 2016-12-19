<?php

$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
 
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 
$block='';

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	include("$ROOT/receiver.php");
    $query = $db->query("SELECT i2c FROM device WHERE id='1'");
    $result= $query->fetchAll();
    foreach($result as $r) {
	$i2c=$r['i2c'];
    }
    if(($i2c=='i2c-0')||($i2c=='i2c-1')||($i2c=='i2c-2')||($i2c=='i2c-3')||($i2c=='i2c-4')){
	$bus=substr($i2c, -1, 1);
	echo "I2C BUS: $bus\n";
	$qname = $db->query("SELECT DISTINCT name FROM i2c");
	$resname= $qname->fetchAll();
	    foreach($resname as $rn) {
	    $name=$rn['name'];
	    $qaddr = $db->query("SELECT addr FROM i2c WHERE name='$name'");
	    $resaddr= $qaddr->fetchAll();
		    foreach($resaddr as $qa) {
		    $rom="i2c_".$qa['addr']."_";
		    $qrom = $db->query("SELECT * FROM sensors WHERE rom LIKE '$rom%' ");
		    $resrom= $qrom->fetchAll();
			foreach($resrom as $rr) {
			    $addr=$qa['addr'];
			    //tmp102
			    if($name=='tmp102') {
					if($block!='yes') {
						$cmd="$ROOT/modules/sensors/i2c/TMP102/read.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						$output = trim($output);
					}
					$block='yes';
				//bme280
			    } elseif($name=='bme280') {
					if($block!=$addr) {
						$block=$addr;
						$cmd="$ROOT/modules/sensors/i2c/BME280/bme280.py $bus $addr";
						echo $date." Running: ".$cmd."\n";
						$output = shell_exec($cmd);
						$output = preg_split ('/$\R?^/m', $output);
						//temp,press,humid
						//var_dump($output);
						$output0 = trim($output[0]);
						$output1 = trim($output[1]);
						$output2 = trim($output[2]);
						$output = '';
					}
					if($rr['type']=='temp') {
						$output = $output0;
						$output0 = '';
					} elseif ($rr['type']=='press') {
						$output = $output1;
						$output1 = '';
					} elseif ($rr['type']=='humid') {
						$output = $output2;
						$output2 = '';
					}
				//htu21d	
			    } elseif($name=='htu21d') {
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
						//$output = preg_split ('/$\R?^/m', $output);
						//$output = preg_replace('/\D/', '', $output);
						//lux
						//var_dump($output);
						//$output0 = trim($output[0]);
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
				$local_current='';
				echo $date." Name:".$rr['name']." Rom:".$rr['rom']." Addr:".$qa['addr']." Bus:".$bus." Value:".$output."\n";
				db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
				unset($output);
			    
			}
		    }
	    }
    }
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
