<?php

/*

# IP IP/device/name/type
192.168.0.1/gpio/18

# localhost IP/device/addr/name/type
localhost/gpio/18/dht22/humid 
localhost/gpio/18/dht22/temp
localhost/i2c/55/BMP/temp
localhost/1wire/rom/temp

*/


$ROOT=(dirname(dirname(dirname(__FILE__))));
require("phpMQTT.php");
include("$ROOT/receiver.php");
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 


$server = "localhost";     // change if necessary
$port = 1883;                     // change if necessary
$username = "";                   // set your username
$password = "";                   // set your password
$client_id = "phpMQTT-subscriber"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

$topics['#'] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);

while($mqtt->proc()){
		
}

$mqtt->close();


function procmsg($topic, $msg){
		echo "Msg Recieved:\n";
		echo "Topic: {$topic}\n\n";
	//	echo "\t$msg\n\n";


    $ttp=(explode("/",$topic));
    foreach($ttp as $p) {
	$arr[]=$p;
    }

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

    $output = trim($msg);

    $gpio='';
    $local_gpio='';
    
    if ($arr['3']=='gpio') {
		
	$ip=$arr['1'];
	$name=$arr['2'];
	$type=$arr['3'];
	$gpio=$arr['4'];
    
	$local_device	=	'ip_mqtt';
	$local_type	=	$type;
	$local_val	=	$output;
	$local_name	=	$name;
	$local_ip	=	$ip;
	$local_gpio	=	$gpio;
	$local_rom=$local_device."_".$local_name."_".$local_type."_".$local_gpio;
    }
    else {
	$ip=$arr['1'];
	$name=$arr['2'];
	$type=$arr['3'];
    
    $local_device	=	'ip_mqtt';
	$local_type	=	$type;
	$local_val	=	$output;
	$local_name	=	$name;
	$local_ip	=	$ip;
	$local_rom=$local_device."_".$local_name."_".$local_type;
    }
    echo $date." Rom:".$local_rom." Name: ".$local_name." Value: ".$output." IP: ".$local_ip." GPIO: ".$local_gpio."\n";
    db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

}
