<?php
//gpio, czas, rownasie, metoda
// week list

$db = new PDO('sqlite:../../dbf/nettemp.db');
$debug = isset($_GET['debug']) ? $_GET['debug'] : '';


////////////////////////////////////////////////////////
// functions

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
			$etime=$b['etime'];
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

function action_on($op,$sensor_name,$gpio) {
	echo "GPIO ".$gpio." TRUN ON\n";
	exit();
}
function action_off($op,$sensor_name,$gpio) {
	echo "GPIO TRUN OFF\n";
	exit();
}

function temp($op,$sensor_tmpadj,$value,$sensor_name,$op,$gpio) {
	if ($op=='gt') {
			if ($sensor_tmpadj > $value){
				action_on($op,$sensor_name,$gpio);				
			}
			else {
				action_off($op,$sensor_name,$gpio);	
			}
		} 
		elseif ($op=='ge') {
			if ($sensor_tmpadj >= $value){
				action_on($op,$sensor_name,$gpio);	
			}
			else {
				 action_off($op,$sensor_name,$gpio);
			}
		} 
		elseif ($op=='le') {
			if ($sensor_tmpadj <= $value){
				action_on($op,$sensor_name,$gpio);	
			}
			else {
				 action_off($op,$sensor_name,$gpio);
			}
		} 
		elseif ($op=='lt') {
			if ($sensor_tmpadj < $value){
				action_on($op,$sensor_name,$gpio);	
			}
			else {
				 action_off($op,$sensor_name,$gpio);
			}
		}
}



		
// main loop
$rows = $db->query("SELECT * FROM gpio WHERE mode='temp'");
$row = $rows->fetchAll();
foreach ($row as $a) {
	$gpio=$a['gpio'];
	$rev=$a['rev']; //////////////////////reverse
		if($rev=='on') {$mode='LOW';} else {$mode='HIGH';}
	$day_run=$a['day_run'];	
	echo "GPIO ".$gpio.", Mode=".$mode.", ".date('l jS \of F Y H:i:s')."\n";
		
	$rows = $db->query("SELECT * FROM g_func WHERE gpio='$gpio' ORDER BY position ASC");
	$func = $rows->fetchAll();
	//get data function for gpio
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
					echo "Function ".$f_id." with profile '".$w_profile."' not in range.\n";
					continue;
				} 
				else {
					echo "Function ".$f_id." with profile '".$w_profile."' hit.\n";
				}
			}
			//hit in any
			elseif($w_profile!='any') {
					echo "Function ".$f_id." with profile '".$w_profile."' not in range. Day off.\n";
					continue;
				}
				else {
					echo "Function ".$f_id." with profile '".$w_profile."' hit.\n";
				}
			
						
			$rows = $db->query("SELECT * FROM sensors WHERE id='$sens_id'");
			$sens = $rows->fetchAll();
			foreach ($sens as $sens) {
				$sensor_name=$sens['name'];
				$sensor_tmp=$sens['tmp'];
				$sensor_tmpadj=$sens['tmp']+$sens['adj'];
					}
			// define what is value
			if($source == 'temp' || $source == 'temphyst') {
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

			if($debug=='yes') {
				echo $gpio." ".$sensor_name." ".$sensor_tmpadj." ".$op." ".$sensor2_name." ".$value." ".$hyst." ".$value_max." ".$onoff." ".$w_profile."\n";
			}
		
	
			if($source=='temp' || $source=='sensor2') {
				temp($op,$sensor_tmpadj,$value,$sensor_name,$op,$gpio);		
			} 
			elseif($source=='temphyst' || $source=='sensor2hyst') {
				// dkonczyc
				echo "";
			}
			
	} //function
}  //main
?>
