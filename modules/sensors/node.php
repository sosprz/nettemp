<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
 
$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}
try {
	$query = $db->query("SELECT * FROM settings where id='1'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$client_ip=$s['client_ip'];
		$client_key=$s['client_key'];
		$client_on=$s['client_on'];
		$cauth_on=$s['cauth_on'];
		$cauth_pass=$s['cauth_pass'];
    }
    if(!empty($client_ip)&&!empty($client_key)&&!empty($client_on)){
		$query = $db->query("SELECT * FROM sensors WHERE remote='on'");
		$result= $query->fetchAll();
		foreach($result as $s) {
			$rom=$s['rom'];
			$rom2=$hostname."_".$rom;
			$value=$s['tmp'];
			$type=$s['type'];
			$name=$s['name'];
			$URL="http://".$client_ip."/receiver.php?key=".$client_key."&type=".$type."&rom=".$rom2."&value=".$value."&device=ip";
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "admin:" . $cauth_pass);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $date." Name:".$name." Rom:".$rom." Value:".$value."\n";
			echo $server_output;
		}
    }


} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>

