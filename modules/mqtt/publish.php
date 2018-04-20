<?php

$ROOT=(dirname(dirname(dirname(__FILE__))));
require("phpMQTT.php");

$server = "localhost";     // change if necessary
$port = 1883;                     // change if necessary
$username = "";                   // set your username
$password = "";                   // set your password
$client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish("/192.168.50.104/Kominek/LED/gpio/13", "1" , 1);
	$mqtt->close();
} else {
    echo "Time out!\n";
}
