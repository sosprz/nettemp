<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
define("LOCAL","local");


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}


try {
	include("$ROOT/receiver.php");
	
	
	

    for i in $(ls /mnt/1wire/ |grep ^[1-9]..)

		val=$(cat /mnt/1wire/$i/temperature)
		
		rom=$(echo $i |sed 's/\./-/g'| sed -e 's/\(.*\)/\L\1/')
		
		
		php-cgi -f $dir/receiver.php key=$skey type=temp value=$val 




	} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}


?>

