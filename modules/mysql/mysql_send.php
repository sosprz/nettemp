<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
$date = date("Y-m-d H:i:s");

$conf="$ROOT/modules/mysql/mysql_conf.php";

if(file_exists($conf)) {
	include_once($conf);
	$conn = new mysqli($IP, $USER, $PASS, $DB, $PORT);
	
	$test="SHOW TABLES";
	if ($conn->connect_error){
		echo $date." Connection to MYSQL error\n";
	} else {
		$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
		$rows = $db->query("SELECT * FROM sensors");
		$row = $rows->fetchAll();
		foreach ($row as $a) { 	
			$rom=$a['rom'];
			$tmp=$a['tmp'];
			$name=$a['name'];
			$sql="INSERT INTO `".$rom."` (value) VALUES ('$tmp')";
			if ($conn->query($sql) === TRUE) {
				echo $date." Send $tmp to $name successfully \n";
			} else {
				echo $date." Error send $tmp to $name " . $conn->error ."\n";
			}		
			$sql='';
		}
		$conn->close();
	}
} else {
	echo $date." No mysql_conf.php\n";
}

?>
