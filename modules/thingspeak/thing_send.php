<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
$date = date("Y-m-d H:i:s"); 
include("$ROOT/common/functions.php");

//var_dump($argv); logs($date,'Error','Cannot send mail because user doesnt have email, go to settings - users.'); 
parse_str($argv[1],$params);
$interval=$params['intv'];


//function logs($content){
//global $ROOT;

	//$f = fopen("$ROOT/tmp/thingspeak_log.txt", "a");

//fwrite($f, $content);
//fclose($f); 
//}

$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");

// main loop
$rows = $db->query(" SELECT t1.*,t2_1.tmp as tmp1,t2_2.tmp as tmp2,t2_3.tmp as tmp3,t2_4.tmp as tmp4,t2_5.tmp as tmp5,t2_6.tmp as tmp6,t2_7.tmp as tmp7,t2_8.tmp as tmp8 FROM thingspeak t1 LEFT JOIN sensors t2_1 ON t2_1.rom = t1.f1 LEFT JOIN sensors t2_2 ON t2_2.rom = t1.f2 LEFT JOIN sensors t2_3 ON t2_3.rom = t1.f3 LEFT JOIN sensors t2_4 ON t2_4.rom = t1.f4 LEFT JOIN sensors t2_5 ON t2_5.rom = t1.f5 LEFT JOIN sensors t2_6 ON t2_6.rom = t1.f6 LEFT JOIN sensors t2_7 ON t2_7.rom = t1.f7 LEFT JOIN sensors t2_8 ON t2_8.rom = t1.f8 WHERE active='on' AND interval='$interval' ");
$row = $rows->fetchAll();
	foreach ($row as $a) {
			
			$url = 'http://api.thingspeak.com/update';
			$ThingSpeakApiKey = $a['apikey'];
			$name = $a['name'];
			
			if ($a['tmp1'] == 'off'){$field1 = '';} else {$field1 = $a['tmp1'];}
			if ($a['tmp2'] == 'off'){$field2 = '';} else {$field2 = $a['tmp2'];}
			if ($a['tmp3'] == 'off'){$field3 = '';} else {$field3 = $a['tmp3'];}
			if ($a['tmp4'] == 'off'){$field4 = '';} else {$field4 = $a['tmp4'];}
			if ($a['tmp5'] == 'off'){$field5 = '';} else {$field5 = $a['tmp5'];}
			if ($a['tmp6'] == 'off'){$field6 = '';} else {$field6 = $a['tmp6'];}
			if ($a['tmp7'] == 'off'){$field7 = '';} else {$field7 = $a['tmp7'];}
			if ($a['tmp8'] == 'off'){$field8 = '';} else {$field8 = $a['tmp8'];}
					
			$data = 'key=' . $ThingSpeakApiKey . '&field1=' . $field1 . '&field2=' . $field2 .'&field3=' . $field3 . '&field4=' . $field4 . '&field5=' . $field5 . '&field6=' . $field6 . '&field7=' . $field7 . '&field8=' . $field8;
			
			 
			$ch = curl_init($url);
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			 
			$response = curl_exec( $ch );
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			$content = $httpcode;
			
			$content = date('Y M d H:i:s')."-".$name."-".$data." - httpcode = ".$httpcode;
			logs($date,'Info',$content);

	}

?>