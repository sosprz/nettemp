<?php
//gpio, czas, rownasie, metoda

// logowanie do pliku


$db = new PDO('sqlite:../../dbf/nettemp.db');
$debug = isset($_GET['debug']) ? $_GET['debug'] : '';


////////////////////////////////////////////////////////
// functions

ob_start();

function timestamp($gpio,$onoff) {
	
	if (file_exists("../../db/gpio_stats_$gpio.sql")) {
		$db = new PDO("sqlite:../../db/gpio_stats_$gpio.sql") or die ("WARNING timestamp 1\n" );
	   $db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$onoff')") or die ("WARNING timestamp 2\n" );
  	}
	else {
		$db = new PDO("sqlite:../../db/gpio_stats_$gpio.sql");
   	$db->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)") or die ("WARNING timestamp 3\n" );
    	$db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$onoff')") or die ("WARNING timestamp 4\n" );
	}
}

function w_profile_check($gpio,$w_profile) {
	$day=date("D");
	$time=date("Hi");
	$db = new PDO('sqlite:../../dbf/nettemp.db');
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


function action_on($op,$sensor_name,$gpio,$rev) {
	$db = new PDO('sqlite:../../dbf/nettemp.db');
	$out="/usr/local/bin/gpio -g mode $gpio output";
	$read="/usr/local/bin/gpio -g read $gpio";
	$on="/usr/local/bin/gpio -g write $gpio 1";
	$off="/usr/local/bin/gpio -g write $gpio 0";
	exec($out);
	exec($read, $check);
	if ($rev == 'on') {
	    if ($check['0'] == '1'){ 
		 	exec($off);
		 	echo date('Y H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", SET ON\n";
	    }
	    else {
	    	echo date('Y H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", ALREADY ON\n";
	    }
	}
	else {
	    if ($check['0'] == '0'){ 
	        exec($on);
	        echo date('Y H:i:s')." GPIO ".$gpio." CHECK " .$check['0'].", SET ON\n";
	    }
	    else {
	    	echo date('Y H:i:s')." GPIO ".$gpio." CHECK " .$check['0'].", ALREADY ON\n";
	    }
	}	
	$db->exec("UPDATE gpio SET status='ON' WHERE gpio='$gpio'");
  	$onoff='1';
  	timestamp($gpio,$onoff);
 }
function action_off($op,$sensor_name,$gpio,$rev) {
	$db = new PDO('sqlite:../../dbf/nettemp.db');
	$out="/usr/local/bin/gpio -g mode $gpio output";
	$read="/usr/local/bin/gpio -g read $gpio";
	$on="/usr/local/bin/gpio -g write $gpio 1";
	$off="/usr/local/bin/gpio -g write $gpio 0";
	exec($out);
	exec($read, $check);
	if ($rev == 'on') {
	    if ($check['0'] == '0'){ 
				exec($on);
				echo date('Y H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", SET OFF\n";
	    }
	    else {
	    	echo date('Y H:i:s')." GPIO ".$gpio." CHECK" .$check['0'].", ALREADY OFF\n";
	    }
	}
	else {
	    if ($check['0'] == '1'){ 
	    	exec($off);
	    	echo date('Y H:i:s')." GPIO ".$gpio." CHECK  " .$check['0'].", SET OFF\n";
	    }
	    else {
	    	echo date('Y H:i:s')." GPIO ".$gpio." CHECK " .$check['0'].", ALREADY OFF\n";
	    }
	}
	$db->exec("UPDATE gpio SET status='OFF' WHERE gpio='$gpio'");
	$onoff='0';
	timestamp($gpio,$onoff);
}

	
// main loop
$rows = $db->query("SELECT * FROM gpio WHERE mode='temp'");
$row = $rows->fetchAll();
foreach ($row as $a) {
	$gpio=$a['gpio'];
	$rev=$a['rev']; 
		if($rev=='on') {$mode='LOW';} else {$mode='HIGH'; $rev=null;}
	$day_run=$a['day_run'];
	$state=$a['state'];
			
	$rows = $db->query("SELECT * FROM g_func WHERE gpio='$gpio' ORDER BY position ASC");
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
					echo date('Y H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." not in range.\n";
					$CHECK_OVER='tak';
					continue;
				} 
				else {
					echo date('Y H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." hit.\n";
				}
			}
			//hit in any
			elseif($w_profile!='any') {
					echo date('Y H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." not in range. Day off.\n";
					$CHECK_OVER='tak';
					continue;
				}
				else {
					echo date('Y H:i:s')." GPIO ".$gpio." Function ".$f_id." with profile ".$w_profile." hit.\n";
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
				action_off($op,$sensor_name,$gpio,$rev);
				echo date('Y H:i:s')." GPIO ".$gpio." sensor ".$sensor_name." ERROR, GOING OFF\n";
				echo date('Y H:i:s')." GPIO ".$gpio." ".$mode.", ".$sensor_name." ".$sensor_tmp.", ".$op.", ".$sensor2_name." Start:".$value.", Hyst:".$hyst.", End:".$value_max.", Action:".$onoff.", Profile:".$w_profile."\n";
				continue;
			}			
				
			//LOG
			echo date('Y H:i:s')." GPIO ".$gpio." ".$mode.", ".$sensor_name." ".$sensor_tmpadj.", ".$op.", ".$sensor2_name." ".$value.", ".$hyst.", ".$value_max.", ".$onoff.", ".$w_profile."\n";
			
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
								echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." AND not OK, NEXT\n\n";
								$and='nie';
							} else {
								echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." AND OK, NEXT\n\n";
								$and='tak';
							}
						}
					// jest AND i nie spelnionym
						elseif($map[$comparison2] && $onoff=='and') {
							echo date('Y H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison2."' in function ".$func['id']." AND not OK, NEXT\n\n";
							$and='nie';
						}
					// ENDY ok i jest spelniona
					elseif ($map[$comparison] && $onoff!='and' && $and=='tak'){					
						echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." AND OK, EXIT\n\n";
						print $funcion_p($op,$sensor_name,$gpio,$rev);
						break;
					} 
					// ENDY ok i nie jest spelniona
					elseif ($map[$comparison2] && $onoff!='and' && $and=='tak'){
						echo date('Y H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison2."' in function ".$func['id']." AND not OK, EXIT\n\n";
						$and='';
					} 
					// ENDY nie ok i jest spelniona
					elseif ($map[$comparison] && $onoff!='and' && $and=='nie' ){					
						echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']." prev END not OK, EXIT\n\n";
						$and='';
					} 
					// ENDY nie ok i nie jest spelniona
					elseif($map[$comparison2] && $onoff!='and' && $and=='nie') {
						echo date('Y H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison2."' in function ".$func['id']." prev END not OK, EXIT\n\n";
						$and='';
					}			

					/// normalna funckja
					// nie jest AND i jest spelniona
					elseif($onoff!='and') {
						if ($map[$comparison]){
							echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']."\n\n";
							print $funcion_p($op,$sensor_name,$gpio,$rev);
							break;
						}
						// nie jest AND i nie jest spelniona
						else {
							echo date('Y H:i:s')." GPIO ".$gpio." NO HIT condition '".$comparison."' in function ".$func['id']."\n\n";
						}
					}					

		} 

		//// next function
		elseif($source=='valuehyst' || $source=='sensor2hyst') {
			$CHECK_OVER='nie';
			
					if ($map[$comparison]){
						$db->exec("UPDATE gpio SET state='ON' WHERE gpio='$gpio'");
						echo date('Y H:i:s')." GPIO ".$gpio." STAGE 1 ON\n";
						echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison."' in function ".$func['id']."\n";
						if($onoff=='on') {
							action_on($op,$sensor_name,$gpio,$rev);
							} 
							else {
								action_off($op,$sensor_name,$gpio,$rev);
							}
							break;
					}
						
					elseif($map[$comparison2] && $max[$comparison] && $state == 'ON' ) {
						$db->exec("UPDATE gpio SET state='ON' WHERE gpio='$gpio'");
						echo date('Y H:i:s')." GPIO ".$gpio." STAGE 2 ON\n";
						echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison2."' in function ".$func['id']."\n";
						if($onoff=='on') {
							action_on($op,$sensor_name,$gpio,$rev);
							} 
							else {
								action_off($op,$sensor_name,$gpio,$rev);
							}
							break;
					}
										
					elseif($map[$comparison2] && $max[$comparison2]) {
						$db->exec("UPDATE gpio SET state='OFF' WHERE gpio='$gpio'");
						echo date('Y H:i:s')." GPIO ".$gpio." STAGE 3 OFF\n";
						echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison2."' in function ".$func['id']."\n";
						if($onoff=='on') {
							action_off($op,$sensor_name,$gpio,$rev);
							} 
							else {
								action_on($op,$sensor_name,$gpio,$rev);
							}
							break;
					}
					
					elseif($map[$comparison2] && $state == 'OFF') {
						$db->exec("UPDATE gpio SET state='OFF' WHERE gpio='$gpio'");
						echo date('Y H:i:s')." GPIO ".$gpio." STAGE 4 OFF\n";
						echo date('Y H:i:s')." GPIO ".$gpio." HIT condition '".$comparison2."' in function ".$func['id']."\n";
						if($onoff=='on') {
							action_off($op,$sensor_name,$gpio,$rev);
							} 
							else {
								action_on($op,$sensor_name,$gpio,$rev);
							}
							break;
					}
					else {
						echo "error\n";
					}
					
				}
		
			
	} //function
	
	if(($CHECK_OVER=='tak') && ($state=='ON')) {
		$db->exec("UPDATE gpio SET state='OFF' WHERE gpio='$gpio'");
		echo date('Y H:i:s')." GPIO ".$gpio." FORCE CLOSE HIST\n";
		action_off($op,$sensor_name,$gpio,$rev);
	}

$content = ob_get_contents();
$f = fopen("../../tmp/gpio_".$gpio."_log.txt", "a");
fwrite($f, $content);
fclose($f); 
}  //main


?>
