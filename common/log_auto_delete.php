
<?php
$root = "/var/www/nettemp";

$db = new PDO("sqlite:$root/dbf/nettemp.db");

$query = $db->query("SELECT * FROM nt_settings");
    $result= $query->fetchAll();
    
    foreach($result as $s) {
		
		if($s['option']=='logshis') {
			$logshistime=$s['value'];
			$logshistime="-".$logshistime." days";
		}
	}
$db->exec("DELETE FROM logs WHERE date <= datetime('now','localtime','$logshistime')") or die ($db->lastErrorMsg());


?>