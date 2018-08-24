<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
define("LOCAL","local");
$date = date("Y-m-d H:i:s");

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->query("SELECT * FROM nt_settings");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
	if($a['option']=='MCP23017') {
		$MCP23017=$a['value'];
	}
	if($a['option']=='gpiodemo') {
		$gpiodemo=$a['value'];
	}

}

$wp = '/usr/local/bin/gpio';
$gpiolist=array();

if (file_exists($wp)) {
	exec("$wp -v |grep Type:", $wpout );
	$wpout=$wpout[0];
   if(strpos($wpout, 'B+') !== false) {
		$gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);  
   } elseif(strpos($wpout, 'Model B, Revision: 2') !== false) {
   	$gpiolist = array(4,17,27,22,18,23,24,25,28,29,30,31);
   } elseif(strpos($wpout, 'Model B, Revision: 1') !== false) {
   	$gpiolist = array(4,17,21,22,18,23,24,25);
   } elseif(strpos($wpout, 'Model B, Revision: 03') !== false) {
   	$gpiolist = array(4,17,27,22,18,23,24,25,28,29,30,31);
	} elseif(strpos($wpout, 'Model 2, Revision:') !== false) {
   	$gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
   } elseif(strpos($wpout, 'Pi 2, Revision:') !== false) {
   	$gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
 	} elseif(strpos($wpout, 'Pi Zero, Revision:') !== false) {
   	$gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
   } elseif(strpos($wpout, 'Pi 3, Revision') !== false) {
   	$gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
   } elseif(strpos($wpout, 'Pi 3+, Revision:') !== false) {
   	$gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
   } elseif(strpos($wpout, 'ODROID-C1/C1+, Revision: 1') !== false) {
   	$gpiolist = array(83,88,116,115,101,100,108,97,87,104,102,103,118,99,98);
   } else {
		$gpiolist = array(4,17,21,22,18,23,24,25);
   }

	if ($MCP23017 == 'on') {
	    array_push($gpiolist,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115);
	}
}

if (isset($gpiodemo) && $gpiodemo == 'on') {
		$gpiolist = array(91,92,93,94,94,95,96,97,98,99);
}


include_once("$ROOT/receiver.php");

function write($gpio){
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

    exec('/usr/local/bin/gpio -g read '.$gpio, $state);
    $local_val=$state[0];
	$local_device='gpio';
    $local_type='gpio';
    $local_gpio=$gpio;
    $local_rom="gpio_".$local_gpio;
    if($local_type!='elec' || $local_type!='water' || $local_type!='gas') { 
		echo $date." Rom:".$local_rom." GPIO:".$local_gpio." State: ".$local_val."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
	} else {
		echo $date." Counter on GPIO: ".$gpio;
	}
}

	$sth2 = $db->query("SELECT * FROM sensors WHERE type='gas' OR type='water' OR type='elec'");
	$sth2->execute();
	$row = $sth2->fetchAll();
    $counter_list=[];
    foreach($row as $cgpio){
		$counter_list[]=$cgpio['gpio'];
	}
	
	$gpio_diff = array_diff($gpiolist, $counter_list);
	

foreach($gpio_diff as $gpio){
	write($gpio);
}


?>
