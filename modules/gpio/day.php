<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
//$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");

//***************************************************************************************************************** 

function timestamp($gpio,$onoff) {
	global $ROOT;
	
	if (file_exists("$ROOT/db/gpio_stats_$gpio.sql")) {
		$db = new PDO("sqlite:$ROOT/db/gpio_stats_$gpio.sql") or die ("WARNING timestamp 1\n" );
	    $db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$onoff')") or die ("WARNING timestamp 2\n" );
  	}
	else {
		$db = new PDO("sqlite:$ROOT/db/gpio_stats_$gpio.sql");
		$db->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)") or die ("WARNING timestamp 3\n" );
    	$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$onoff')") or die ("WARNING timestamp 4\n" );
	}
}
//***************************************************************************************************************** 
function logs($gpio,$ip,$content){
global $ROOT;


if(!empty($ip)){
	$f = fopen("$ROOT/tmp/gpio_".$gpio."_".$ip."_log.txt", "a");
}else {
	$f = fopen("$ROOT/tmp/gpio_".$gpio."_log.txt", "a");
}
fwrite($f, $content);
fclose($f); 
}
//***************************************************************************************************************** 
function action_on($gpio,$rev,$ip,$rom) {
	global $ROOT;
	global $db;
	
	if(empty($ip)){
		$out="/usr/local/bin/gpio -g mode $gpio output";
		$read="/usr/local/bin/gpio -g read $gpio";
		$on="/usr/local/bin/gpio -g write $gpio 1";
		$off="/usr/local/bin/gpio -g write $gpio 0";
		exec($out);
		exec($read, $check);
		if ($rev == 'on') {
			if ($check['0'] == '1'){ 
				exec($off);
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", SET ON\n";
				logs($gpio,$ip,$content);
			}
			else {
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", ALREADY ON\n";
				logs($gpio,$ip,$content);
			}
		}
		else {
			if ($check['0'] == '0'){ 
				exec($on);
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK " .$check['0'].", SET ON\n";
				logs($gpio,$ip,$content);
			}
			else {
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK " .$check['0'].", ALREADY ON\n";
				logs($gpio,$ip,$content);
			}
		}
	} else {
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/control?cmd=GPIO,$gpio,1",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);
		if(curl_errno($ch))
		{
			$content = date('Y M d H:i:s')." GPIO ".$gpio." IP ".$ip.", Curl error: ".curl_error($ch)."\n";
			logs($gpio,$ip,$content);
		}
		global $rom;
		$dbf = new PDO("sqlite:$ROOT/db/$rom.sql");
		$db->exec("UPDATE sensors SET tmp='1.0' WHERE rom='$rom'");
		$content = date('Y M d H:i:s')." GPIO ".$gpio." IP ".$ip.", SET ON\n";
		logs($gpio,$ip,$content);
	}
	
	$db->exec("UPDATE gpio SET status='ON' WHERE gpio='$gpio' AND rom='$rom'");
	
  	$onoff='1';
  	timestamp($gpio,$onoff);
}
//***************************************************************************************************************** 
function action_off($gpio,$rev,$ip,$rom) {
	global $db;
	global $ROOT;
	
	if(empty($ip)){
		$out="/usr/local/bin/gpio -g mode $gpio output";
		$read="/usr/local/bin/gpio -g read $gpio";
		$on="/usr/local/bin/gpio -g write $gpio 1";
		$off="/usr/local/bin/gpio -g write $gpio 0";
		exec($out);
		exec($read, $check);
		if ($rev == 'on') {
			if ($check['0'] == '0'){ 
				exec($on);
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", SET OFF\n";
				logs($gpio,$ip,$content);
			}
			else {
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", ALREADY OFF\n";
				logs($gpio,$ip,$content);
			}
		}
		else {
			if ($check['0'] == '1'){ 
				exec($off);
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK  " .$check['0'].", SET OFF\n";
				logs($gpio,$ip,$content);
			}
			else {
				$content = date('Y M d H:i:s')." GPIO ".$gpio." CHECK " .$check['0'].", ALREADY OFF\n";
				logs($gpio,$ip,$content);
			}
		}
	} 
	else {
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/control?cmd=GPIO,$gpio,0",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);
		if(curl_errno($ch))
		{
			$content = date('Y M d H:i:s')." GPIO ".$gpio." IP ".$ip.", Curl error: ".curl_error($ch)."\n";
			logs($gpio,$ip,$content);
		}
		global $rom;
		$dbf = new PDO("sqlite:$ROOT/db/$rom.sql");
		$db->exec("UPDATE sensors SET tmp='0.0' WHERE rom='$rom'");
		$content = date('Y M d H:i:s')." GPIO ".$gpio." IP ".$ip.", SET OFF\n";
		logs($gpio,$ip,$content);

	}
	
	$db->exec("UPDATE gpio SET status='OFF' WHERE gpio='$gpio' AND rom='$rom'");

	$onoff='0';
	timestamp($gpio,$onoff);
}

// main loop
$rows = $db->query("SELECT * FROM gpio WHERE mode='day' AND day_run='on'");
$row = $rows->fetchAll();
		foreach ($row as $a) {
			
			$gpio=$a['gpio'];
			$name=$a['name'];
			$ip=$a['ip'];
			$lock=$a['locked'];
			$rev=$a['rev']; 
			$rom=$a['rom'];
			if($rev=='on') {$mode='LOW';} else {$mode='HIGH'; $rev=null;}
			
// Check if Lock by User
				if ($lock=='user') {
					$db->exec("UPDATE day_plan SET active='off' WHERE rom='$rom' ");
					$content = date('Y M d H:i:s')." GPIO ".$gpio.", name: ".$name." - LOCKED by USER.\n";
					logs($gpio,$ip,$content);
				}   else {
						$day=date("D");
						$time=date("Hi");
						$rows = $db->query("SELECT * FROM day_plan WHERE gpio=$gpio  AND (Mon='$day' OR Tue='$day' OR Wed='$day' OR Thu='$day' OR Fri='$day' OR Sat='$day' OR Sun='$day')");
						$func = $rows->fetchAll();
						$numRows = count($func);
						
						if ( $numRows > '0' ) { 
							foreach ($func as $b) {
			
								$w_profile=$b['name'];
								$stime=$b['stime'];
								$stime=str_replace(':', '', $stime);
								$etime=$b['etime'];
								$etime=str_replace(':', '', $etime);
							}
						
							if($time >= $stime && $time < $etime) {
								$status='on';	
								$db->exec("UPDATE day_plan SET active='on' WHERE rom='$rom' ");	
								$content = date('Y M d H:i:s')." GPIO ".$gpio.", name: ".$name.", Day Plan: ".$w_profile.", SET: ".$status."\n";
								logs($gpio,$ip,$content);
								action_on($gpio,$rev,$ip,$rom);		
							} else {
									$status='off';
									$db->exec("UPDATE day_plan SET active='off' WHERE rom='$rom' ");									
									$content = date('Y M d H:i:s')." GPIO ".$gpio.", name: ".$name.", Day Plan: ".$w_profile.", SET: ".$status."\n";
									logs($gpio,$ip,$content);
									action_off($gpio,$rev,$ip,$rom);	
								}
						}   else {
								$db->exec("UPDATE day_plan SET active='off' WHERE rom='$rom' ");
								$content = date('Y M d H:i:s')." GPIO ".$gpio.", name: ".$name." - Nothing to do - no dayplan.\n";
								logs($gpio,$ip,$content);
								action_off($gpio,$rev,$ip,$rom);
							}
			
						}
					
}//main loop end
?>
