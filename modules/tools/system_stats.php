<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
$date = date("Y-m-d H:i:s"); 


function get_server_cpu_usage(){
 
	$load = sys_getloadavg();
	return $load[0];
 
}

$cpu=get_server_cpu_usage();

function get_server_memory_usage(){
 
	$free = shell_exec('free');
	$free = (string)trim($free);
	$free_arr = explode("\n", $free);
	$mem = explode(" ", $free_arr[1]);
	$mem = array_filter($mem);
	$mem = array_merge($mem);
	$memory_usage = $mem[2]/$mem[1]*100;
 
	return $memory_usage;
}

$mem=round(get_server_memory_usage(),2);

$system=array("system_cpu","system_memory");
//var_dump($system);
foreach($system as $file) {
	try {
		if(!file_exists("$ROOT/db/$file.sql")){
			$db = new PDO("sqlite:$ROOT/db/$file.sql");
			$db->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
			echo $date." New database for system_cpu created.\n";
		}
		$db = new PDO("sqlite:$ROOT/db/$file.sql");
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		if($file=='system_cpu'){ 
			$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$cpu')");
			echo $date." Insert to ".$file." ".$cpu.".\n";
		} 
		if($file=='system_memory'){ 
			$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$mem')");
			echo $date." Insert to ".$file." ".$mem.".\n";
		} 
		
	} catch (Exception $e) {
		echo $date." Error.\n";
		echo $e;
		exit;
	}
}




?>
