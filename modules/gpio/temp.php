<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
$debug = isset($_GET['debug']) ? $_GET['debug'] : '';
$CHECK_OVER='';
$and='';

////////////////////////////////////////////////////////
// functions


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

function w_profile_check($gpio,$w_profile) {
	global $ROOT;
	global $db;
	$day=date("D");
	$time=date("Hi");
	$rows = $db->query("SELECT * FROM day_plan WHERE name='$w_profile' AND (Mon='$day' OR Tue='$day' OR Wed='$day' OR Thu='$day' OR Fri='$day' OR Sat='$day' OR Sun='$day')");
	$row = $rows->fetchAll();
	$numRows = count($row);
 	if ( $numRows > '0' ) { 
		foreach ($row as $b) {
			
			$stime=$b['stime'];
			$stime=str_replace(':', '', $stime);
			$etime=$b['etime'];
			$etime=str_replace(':', '', $etime);
			
		}
		if($time >= $stime && $time < $etime) {
				 return true;
		}
			else {
				return false;
			}
	}
		else {
			return false;
		}
}


function action_on($op,$sensor_name,$gpio,$rev,$ip,$rom) {
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
 
function action_off($op,$sensor_name,$gpio,$rev,$ip,$rom) {
	global $db;
	global $ROOT;
	
	$content = date('Y M d H:i:s')." Mam ".$op.$sensor_name.$gpio.$rev.$ip.$rom."\n";
				logs($gpio,$ip,$content);
	
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
$rows = $db->query("SELECT * FROM gpio WHERE mode='temp'");
$row = $rows->fetchAll();
foreach ($row as $a) {
	
	$gpio=$a['gpio'];
	$ip=$a['ip'];
	$rom=$a['rom'];
	
	if($a['locked']=='user') {
		$content = date('Y M d H:i:s')." GPIO ".$a['gpio'].", name: ".$a['name'].", LOCKED by USER.\n";
		logs($gpio,$ip,$content);
		continue;
	}
	
	$rev=$a['rev']; 
	if($rev=='on') {$mode='LOW';} else {$mode='HIGH'; $rev=null;}
	$day_run=$a['day_run'];
	$state=$a['state'];
			
	$rows = $db->query("SELECT * FROM g_func WHERE gpio='$gpio' AND rom='$rom' ORDER BY position ASC");
	$func = $rows->fetchAll();
	
	//get data function for SINGLE gpio
	foreach ($func as $func) {
		   $f_id=$func['id'];
			$sens_id=$func['sensor'];
			$sens2_id=$func['sensor2'];
			$op=$func['op'];
			$onoff=$func['onoff'];
			$source=$func['source'];
			$hyst=$func['hyst'];
			$w_profile=$func['w_profile'];			
			
			//check if in week profile, if not exit, if empty or in range go forward
			if(($day_run=='on') && ($w_profile!='any')) {
				if (w_profile_check($gpio,$w_profile)===false){
					$content = date('Y M d H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." not in range.\n";
					$db->exec("UPDATE g_func SET active='off' WHERE gpio='$gpio' AND id='$f_id'  ");
					logs($gpio,$ip,$content);
					
					action_off($op,$sensor_name,$gpio,$rev,$rom);
					$content = date('Y M d H:i:s')." GPIO ".$gpio." - ".$sensor_name." - ".$rev." - ".$rom." - ".$op." Off - na active DayPlan\n";
					logs($gpio,$ip,$content);
					
					$CHECK_OVER='tak';
					continue;
				} 
				else {
					$content = date('Y M d H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." hit.\n";
					$db->exec("UPDATE g_func SET active='on' WHERE gpio='$gpio' AND id='$f_id'");	
					logs($gpio,$ip,$content);
				}
			}
			//hit in any
			elseif($w_profile!='any') {
					$content = date('Y M d H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." not in range. Day off.\n";
					logs($gpio,$ip,$content);
					$CHECK_OVER='tak';
					$db->exec("UPDATE g_func SET active='off' WHERE gpio='$gpio' AND id='$f_id'  ");
					continue;
				}
				else {
					$content = date('Y M d H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." hit.\n";
					//update active dayplan - dodać do tabeli rom
					$db->exec("UPDATE g_func SET active='on' WHERE gpio='$gpio' AND id='$f_id'");	
					logs($gpio,$ip,$content);
				}
			
						
			$rows = $db->query("SELECT * FROM sensors WHERE id='$sens_id'");
			$sens = $rows->fetchAll();
			foreach ($sens as $sens) {
				$sensor_name=$sens['name'];
				$sensor_tmp=$sens['tmp'];
				$sensor_tmpadj=$sens['tmp']+$sens['adj'];
					}
			// define what is value
			if($source == 'value' || $source == 'valuehyst') {
					$value=$func['value'];
					$value_max=$func['value']+$func['hyst'];
					$sensor2_name=null;
					$sensor2_tmp=null;
					$sensor2_tmpadj=null;
			}
			elseif($source == 'sensor2' || $source == 'sensor2hyst') {
					$rows2 = $db->query("SELECT * FROM sensors WHERE id='$sens2_id'");
					$sens2 = $rows2->fetchAll();
					foreach ($sens2 as $sens2) {
						$sensor2_name=$sens2['name'];
						$sensor2_tmp=$sens2['tmp'];
						$sensor2_tmpadj=$sens2['tmp']+$sens2['adj'];
					}
					$value=$sensor2_tmpadj;
					$value_max=$sensor2_tmpadj+$func['hyst'];
			}
			
			if($sensor_tmp=='error') {
				action_off($op,$sensor_name,$gpio,$rev,$rom);
				$content = date('Y M d H:i:s')." GPIO ".$gpio." sensor ".$sensor_name." ERROR, GOING OFF\n";
				logs($gpio,$ip,$content);
				$content = date('Y M d H:i:s')." GPIO ".$gpio." ".$mode.", ".$sensor_name." ".$sensor_tmp.", ".$op.", ".$sensor2_name." Start:".$value.", Hyst:".$hyst.", End:".$value_max.", Action:".$onoff.", Profile:".$w_profile."\n";
				logs($gpio,$ip,$content);
				continue;
			}			
				
			//LOG
			$content = date('Y M d H:i:s')." GPIO ".$gpio." ".$mode.", ".$sensor_name." ".$sensor_tmpadj.", ".$op.", ".$sensor2_name." ".$value.", ".$hyst.", ".$value_max.", ".$onoff.", ".$w_profile."\n";
			logs($gpio,$ip,$content);
			// MAP for condition
				if ($op=='gt') {
					$op='>';
					$comparison = '>';
					$comparison2 = '<';
					$map = array(
   					 ">" => $sensor_tmpadj > $value,
   					 "<" => $sensor_tmpadj < $value
					);
					$max = array(
   					 ">" => $sensor_tmpadj > $value_max,
   					 "<" => $sensor_tmpadj < $value_max
					);
					
				}
				elseif ($op=='ge') {
					$op='>=';
					$comparison = '>=';
					$comparison2 = '<=';
					$map = array(
   					 ">=" => $sensor_tmpadj >= $value,
   					 "<=" => $sensor_tmpadj <= $value
					);
					$max = array(
   					 ">=" => $sensor_tmpadj >= $value_max,
   					 "<=" => $sensor_tmpadj <= $value_max
					);
				}
				elseif ($op=='le') {
					$op='<=';
					$comparison = '<=';
					$comparison2 = '>=';
					$map = array(
   					 "<=" => $sensor_tmpadj <= $value,
   					 ">=" => $sensor_tmpadj >= $value
					);
					$max = array(
   					 "<=" => $sensor_tmpadj <= $value_max,
   					 ">=" => $sensor_tmpadj >= $value_max
					);
				}
				elseif ($op=='lt') {
					$op='<';
					$comparison = '<';
					$comparison2 = '>';
					$map = array(
   					 "<" => $sensor_tmpadj < $value,
   					 ">" => $sensor_tmpadj > $value
					);
					$max = array(
   					 "<" => $sensor_tmpadj < $value_max,
   					 ">" => $sensor_tmpadj > $value_max
					);
				}
		// END MAP FOR CONDITION			
			

		if($source=='value' || $source=='sensor2') {
			$CHECK_OVER='nie';
				$funcion_p = 'action_' . $onoff; 
		
					// jest AND spelnionym
					if($map[$comparison] && $onoff=='and') {
							if ($and == 'nie') {
								$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." AND not OK, NEXT\n\n";
								logs($gpio,$ip,$content);
								$and='nie';
							} else {
								$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." AND OK, NEXT\n\n";
								logs($gpio,$ip,$content);
								$and='tak';
							}
						}
					// jest AND i nie spelnionym
					elseif($map[$comparison2] && $onoff=='and') {
							$content = date('Y M d H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison2."' in function ".$func['id']." AND not OK, NEXT\n\n";
							logs($gpio,$ip,$content);
							$and='nie';
						}
					// ENDY ok i jest spelniona
					elseif ($map[$comparison] && $onoff!='and' && $and=='tak'){					
						$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." AND OK, EXIT\n\n";
						logs($gpio,$ip,$content);
						print $funcion_p($op,$sensor_name,$gpio,$rev,$ip,$rom);
						break;
					} 
					// ENDY ok i nie jest spelniona
					elseif ($map[$comparison2] && $onoff!='and' && $and=='tak'){
						$content = date('Y M d H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison2."' in function ".$func['id']." AND not OK, EXIT\n\n";
						logs($gpio,$ip,$content);
						$and='';
					} 
					// ENDY nie ok i jest spelniona
					elseif ($map[$comparison] && $onoff!='and' && $and=='nie' ){					
						$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." prev END not OK, EXIT\n\n";
						logs($gpio,$ip,$content);
						$and='';
					} 
					// ENDY nie ok i nie jest spelniona
					elseif($map[$comparison2] && $onoff!='and' && $and=='nie') {
						$content = date('Y M d H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison2."' in function ".$func['id']." prev END not OK, EXIT\n\n";
						logs($gpio,$ip,$content);
						$and='';
					}			

					/// normalna funckja
					// nie jest AND i jest spelniona
					elseif($onoff!='and') {
						if ($map[$comparison]){
							$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']."\n\n";
							logs($gpio,$ip,$content);
							print $funcion_p($op,$sensor_name,$gpio,$rev,$ip,$rom);
							break;
						}
						// nie jest AND i nie jest spelniona
						else {
							$content = date('Y M d H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison."' in function ".$func['id']."\n\n";
						    logs($gpio,$ip,$content);
						}
					}					

		} 

		//// next function
		elseif($source=='valuehyst' || $source=='sensor2hyst') {
			$CHECK_OVER='nie';
			
					if ($map[$comparison]){
						$db->exec("UPDATE gpio SET state='ON' WHERE gpio='$gpio' AND rom='$rom'");
						$content = date('Y M d H:i:s')." GPIO ".$gpio." STAGE 1 ON\n";
						logs($gpio,$ip,$content);
						$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']."\n";
						logs($gpio,$ip,$content);
						if($onoff=='on') {
							action_on($op,$sensor_name,$gpio,$rev,$ip,$rom);
							} 
							else {
								action_off($op,$sensor_name,$gpio,$rev,$ip,$rom);
							}
							break;
					}
						
					elseif($map[$comparison2] && $max[$comparison] && $state == 'ON' ) {
						$db->exec("UPDATE gpio SET state='ON' WHERE gpio='$gpio' AND rom='$rom'");
						$content = date('Y M d H:i:s')." GPIO ".$gpio." STAGE 2 ON\n";
						logs($gpio,$ip,$content);
						$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison2."' in function ".$func['id']."\n";
						logs($gpio,$ip,$content);
						if($onoff=='on') {
							action_on($op,$sensor_name,$gpio,$rev,$ip,$rom);
							} 
							else {
								action_off($op,$sensor_name,$gpio,$rev,$ip,$rom);
							}
							break;
					}
										
					elseif($map[$comparison2] && $max[$comparison2]) {
						$db->exec("UPDATE gpio SET state='OFF' WHERE gpio='$gpio' AND rom='$rom'");
						$content = date('Y M d H:i:s')." GPIO ".$gpio." STAGE 3 OFF\n";
						logs($gpio,$ip,$content);
						$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison2."' in function ".$func['id']."\n";
						logs($gpio,$ip,$content);
						if($onoff=='on') {
							action_off($op,$sensor_name,$gpio,$rev,$ip,$rom);
							} 
							else {
								action_on($op,$sensor_name,$gpio,$rev,$ip,$rom);
							}
							break;
					}
					
					elseif($map[$comparison2] && $state == 'OFF') {
						$db->exec("UPDATE gpio SET state='OFF' WHERE gpio='$gpio' AND rom='$rom'");
						$content = date('Y M d H:i:s')." GPIO ".$gpio." STAGE 4 OFF\n";
						logs($gpio,$ip,$content);
						$content = date('Y M d H:i:s')." GPIO ".$gpio." HIT condition '".$comparison2."' in function ".$func['id']."\n";
						logs($gpio,$ip,$content);
						if($onoff=='on') {
							action_off($op,$sensor_name,$gpio,$rev,$ip,$rom);
							} 
							else {
								action_on($op,$sensor_name,$gpio,$rev,$ip,$rom);
							}
							break;
					}
					else {
						echo "error\n";
					}
					
				}
		
			
	} //function
	
	if(($CHECK_OVER=='tak') && ($state=='ON')) {
		$db->exec("UPDATE gpio SET state='OFF' WHERE gpio='$gpio' AND rom='$rom'");
		$content = date('Y M d H:i:s')." GPIO ".$gpio." FORCE CLOSE HIST\n";
		logs($gpio,$ip,$content);
		action_off($op,$sensor_name,$gpio,$rev,$ip,$rom);
	}


}  //main


?>
