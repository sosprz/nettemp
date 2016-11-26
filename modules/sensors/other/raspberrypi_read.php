<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local"); 

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Could not connect to the database.";
    exit;
}

try {
    $query = $db->query("SELECT rom FROM sensors WHERE rom='Raspberry_Pi'");
    $result= $query->fetchAll();
    if ((count($result)) >= "1") 
    {
	$output = shell_exec("/opt/vc/bin/vcgencmd measure_temp");
	$local_val = substr($output, 5, -3);
	$local_type = 'temp';
        $local_rom = 'Raspberry_Pi';
	include("$ROOT/receiver.php");
    }
} catch (Exception $e) {
    echo "Error.";
    exit;
}
//var_dump($rows->fetchAll());
?>