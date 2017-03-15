<?php

//ideal
//$sensor=array("19","19.5","20.0","20.5","21","21.5","21","19.5","19");
//one shot
$sensor=array("18","18.6","19","19.5","20.0","30","20.5","21","21.5","21","19.5","19","18.4");

$a=array('gpio' => '18', 'name' => 'test');
$func=array('id' => '1');
$value="20";


$STATE='';
$STAGE='';
$op='gt';
$getlog='';

$mode='temp';
$hist='';
$value_max='';

//$mode='hist';
//$hist="1";
//$value_max=$value+$hist;

foreach ($sensor as $sensor1) {
	
	/* MAP for condition */
	if ($op=='gt') {
		$op='>';
	}
	elseif ($op=='ge') {
		$op='>=';
	}
	elseif ($op=='le') {
		$op='<=';
	}
	elseif ($op=='lt') {
		$op='<';
	}
					
	$normal = array(
	 "<" => $sensor1 < $value,		//lt
	 "<=" => $sensor1 <= $value,    //le	
	 ">" => $sensor1 > $value,		//gt
	 ">=" => $sensor1 >= $value,	//ge
	);
	$raise = array(
	 "<" => $sensor1 < $value_max,   //lt
	 "<=" => $sensor1 <= $value_max, //le
	 ">" => $sensor1 > $value_max,   //gt
	 ">=" => $sensor1 >= $value_max, //ge
	);
	$max= array(
	 "<" => $sensor1 >= $value_max,  //lt
	 "<=" => $sensor1 >= $value_max, //le
	 ">" => $sensor1 <= $value_max,  //gt
	 ">=" => $sensor1 <= $value_max, //ge
	);
	
				
	
	
if($mode=='hist') {
	if($normal[$op]) {
		if($STATE=='OFF') {
			$STATE='ON';
		}
		$getlog='histon';
		$STAGE='1'; 

	} 
	else {
		if($raise[$op]&&($STATE=='ON')) {
			$getlog='histon';
			$STAGE='2'; 
		} elseif($max[$op]) {
			$STATE='OFF';
			$STAGE='3'; 
			$getlog='histoff';
		}
		else {
			$STAGE='4'; 
			$getlog='histoff';
		}
	}
}

if($mode=='temp') {
	if($normal[$op]) {
		$getlog='normalon';
	} 
	else {
		$getlog='normaloff';
	}

}


	$log=array(
	"histon"    	=> date('Y H:i:s')." GPIO ".$a['gpio']." Name:".$a['name'].	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	F:".$func['id']."	Action: ON	State: ".$STATE."	Stage: ".$STAGE." \n",
	"histoff"   	=> date('Y H:i:s')." GPIO ".$a['gpio']." Name:".$a['name'].	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	F:".$func['id']."	Action: OFF	State: ".$STATE."	Stage: ".$STAGE." \n",
	"normalon"  	=> date('Y H:i:s')." GPIO ".$a['gpio']." Name:".$a['name'].	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	F:".$func['id']."	Action: ON	\n",
	"normaloff" 	=> date('Y H:i:s')." GPIO ".$a['gpio']." Name:".$a['name'].	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	F:".$func['id']."	Action: OFF	\n",
	"user_locked"	=> date('Y H:i:s')." GPIO ".$a['gpio']." Name:".$a['name'].	"	LOCKED by USER\n"
	);
	echo $log[$getlog];

}








?>
