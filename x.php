<?php

	//variables
	$state='';
	$stage='';
	$getlog='';

	$tmp=array("17","17.5","18","18.5","19","19.5","20.0","30","20.5","21","21.5","21","19.5","19","18.4");

foreach ($tmp as $tmp) {

	//gpio
	$g=array('id' => '3', 'gpio' => '18', 'name' => 'test', 'mode' => 'hist');

	//sensors
	$s=array('id' => '5','name' => 'taras', 'tmp' => 'trmparray');

	//rules
	$r=array('id' => '1','gpio' => '18', 'name' => 'test', 'value' => '20', 'op' => 'gt', 'hist' => '2', 'sensor1' => '5');

	//week


	$gpio_name=$g['name'];
	$gpio=$g['gpio'];
	$mode=$g['mode'];
	
	$op=$r['op'];
	$hist=$r['hist'];
	$value=$r['value'];
	$rule_name=$r['name'];
	
	$sensor1=$tmp;
	$value_max=$value+$hist;

	
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
	
	/*
	  stage 1 bellow min
	  stage 2 above min and bellow max
	  stage 3 above max
	*/			
	
	
	if($mode=='hist') {
		if($normal[$op]&&!$max[$op]) {
			$getlog='histon';
			$state='ON';
			$stage='1'; 
		} 
		elseif(!$normal[$op]&&$raise[$op]&&$stage!='3') {
			$getlog='histon';
			$state='ON';
			$stage='2'; 
		} 
		elseif($max[$op]) {
			$getlog='histoff';
			$state='OFF';
			$stage='3'; 
			
		}
	}



	/* LOG */

	if($mode=='temp') {
		if($normal[$op]) {
			$getlog='normalon';
		} 
		else {
			$getlog='normaloff';
		}
	}


	$log=array(
	"histon"    	=> date('Y H:i:s')." GPIO ".$gpio." Name:".$gpio_name.	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	Rule:".$rule_name."	Action: ON	state: ".$state."	Stage: ".$stage." \n",
	"histoff"   	=> date('Y H:i:s')." GPIO ".$gpio." Name:".$gpio_name.	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	Rule:".$rule_name."	Action: OFF	state: ".$state."	Stage: ".$stage." \n",
	"normalon"  	=> date('Y H:i:s')." GPIO ".$gpio." Name:".$gpio_name.	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	Rule:".$rule_name."	Action: ON	\n",
	"normaloff" 	=> date('Y H:i:s')." GPIO ".$gpio." Name:".$gpio_name.	"	Sensor1: ".$sensor1."	".$op."	Value: ".$value."	Hist: ".$hist.	"	Max: "	.$value_max.	"	Rule:".$rule_name."	Action: OFF	\n",
	"user_locked"	=> date('Y H:i:s')." GPIO ".$gpio." Name:".$gpio_name.	"	LOCKED by USER\n"
	);
	echo $log[$getlog];

	/* END LOG */



} // END test foreach tmp array

?>
