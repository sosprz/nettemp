<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
$date = date("Y-m-d H:i:s"); 
define("LOCAL","local");

$cmd="sensors |grep -E 'temp[0-9]|Core [0-9]'";
$temp=shell_exec($cmd);
$out = preg_split ('/$\R?^/m', $temp);
foreach($out as $lin){
	$lin=strstr($lin, '°C', true);
	$lin=str_replace("+","",$lin);
	$li[] = explode(":", $lin);
}

include("$ROOT/receiver.php");
foreach($li as $da) {
	$local_rom=trim("lmsensors_".str_replace(' ', '', $da[0])."_temp");
	$local_val=trim($da[1]);
	$local_type='temp';
	$device='';
	$current='';
	echo $date." Rom:".$local_rom." Value:".$local_val."\n";
	db($local_rom,$local_val,$local_type,$device,$current);
}


