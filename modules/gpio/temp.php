<?php
//gpio, czas, rownasie, metoda

$db = new PDO('sqlite:../../dbf/nettemp.db');
$debug = isset($_GET['debug']) ? $_GET['debug'] : '';


////////////////////////////////////////////////////////
// functions

function w_profile($gpio,$w_profile) {
	$day=date("D");
	$time='';
	$db = new PDO('sqlite:../../dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM day_plan WHERE name='$w_profile' AND (Mon='$day' OR Tue='$day' OR Wed='$day' OR Thu='$day' OR Fri='$day' OR Sat='$day' OR Sun='$day')");
	$row = $rows->fetchAll();
		foreach ($row as $b) {
			$stime=$b['stime'];
			$etime=$b['etime'];
		}
		if($time >= $stimec && $time < $etimec) {
				echo "onnnnnnnn\n";
		}
			else {
				echo "offff\n";
			}
		
}

function action_on($op,$sensor_name) {
	echo $sensor_name." on\n";
}
function action_off($op,$sensor_name) {
	echo $sensor_name." off\n";
}


function temp($op,$sensor_tmpadj,$value,$sensor_name,$op) {
	if ($op=='gt') {
			if ($sensor_tmpadj > $value){
				action_on($op,$sensor_name);				
			}
			else {
				action_off($op,$sensor_name);	
			}
		} 
		elseif ($op=='ge') {
			if ($sensor_tmpadj >= $value){
				action_on($op,$sensor_name);	
			}
			else {
				 action_off($op,$sensor_name);
			}
		} 
		elseif ($op=='le') {
			if ($sensor_tmpadj <= $value){
				action_on($op,$sensor_name);	
			}
			else {
				 action_off($op,$sensor_name);
			}
		} 
		elseif ($op=='lt') {
			if ($sensor_tmpadj < $value){
				action_on($op,$sensor_name);	
			}
			else {
				 action_off($op,$sensor_name);
			}
		}
}
		
// main loop
$rows = $db->query("SELECT * FROM gpio");
$row = $rows->fetchAll()
foreach ($row as $a) {
	$gpio=$a['gpio'];
	$day_run=$a['day_run'];	
		
	$rows = $db->query("SELECT * FROM g_func WHERE gpio='$gpio' ORDER BY position ASC");
	$func = $rows->fetchAll();
	//get data function for gpio
	foreach ($func as $func) {
			$sens_id=$func['sensor'];
			$sens2_id=$func['sensor2'];
			$op=$func['op'];
			$onoff=$func['onoff'];
			$source=$func['source'];
			$hyst=$func['hyst'];
			$w_profile=$func['w_profile'];
			
			//check if in week profile, if not exit, if empty or in range go forward
			if($day_run=='on') && ($w_profile !='always') {
				w_profile($gpio,$w_profile);
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
				temp($op,$sensor_tmpadj,$value,$sensor_name,$op);		
			} 
			elseif($source=='temphyst' || $source=='sensor2hyst') {
				// dkonczyc
				echo "";
			}
	} //function
}  //main
?>
