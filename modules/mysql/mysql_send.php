<?php

include_once('../../modules/mysql/mysql_conf.php');
$conn = new mysqli($IP, $USER, $PASS, $DB, $PORT);

$db = new PDO('sqlite:../../dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
foreach ($row as $a) { 	

$rom=$a['rom'];
$tmp=$a['tmp'];
$name=$a['name'];

$sql="INSERT INTO `".$rom."` (value) VALUES ('$tmp')";


if ($conn->query($sql) === TRUE) {
    	echo "Send $tmp to $name successfully\n";
	} else {
   	 echo "Error send $tmp to $name\n" . $conn->error;
	}		
	
	
	$sql='';
}
$conn->close();
?>