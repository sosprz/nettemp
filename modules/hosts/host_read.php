<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
 
$hostname=gethostname(); 
$minute=date('i');
define("LOCAL","local");


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo date("Y-m-d H:i:s")." Could not connect to the database.\n";
    exit;
}

try {
	include("$ROOT/receiver.php");
	//PING
	$query = $db->query("SELECT ip,name,rom FROM hosts WHERE type='ping'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$local_ip=$s['ip'];
		$name=$s['name'];
		$local_rom=$s['rom'];
		$rom=$s['rom'];
		$cmd="fping -e $local_ip";
		$output=shell_exec($cmd);
		if (strpos($output, 'alive') !== false) {
			echo date("Y-m-d H:i:s")." Connection is OK with: ".$name."\n";
			preg_match('/\((\d+\,?\.?\d+)[ ms]+\)/m', $output, $out);
			$output=$out[1];
			$local_val=trim($output);
			$local_type='host';
			echo date("Y-m-d H:i:s")." Name: ".$name." Value:".$output."\n";
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

		} else {
			echo date("Y-m-d H:i:s")." Connection lost with: ".$name."\n";
			$local_val='error';
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

		}
		
	}
	
	//HTTPPING
	$query = $db->query("SELECT ip,name,rom FROM hosts WHERE type='httpping'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$local_ip=$s['ip'];
		$name=$s['name'];
		$local_rom=$s['rom'];
		$local_type='host';
		$rom=$s['rom'];
		$cmd="httping -N x $local_ip -c 1 -t 1 |awk -F= '{print $2}'";
		$output=shell_exec($cmd);
		$out=str_replace(",",".",$output);
		$out=trim($out);
		if(!empty($out)){
			$out=number_format($out, 1, '.', ',');
		}
		if (!empty($out)) {
			echo date("Y-m-d H:i:s")." Connection is OK with: ".$name."\n";           
			$local_val=$out;
			echo date("Y-m-d H:i:s")." Name:".$name." Value:".$out."\n";
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

		} else {
			echo date("Y-m-d H:i:s")." Connection lost with: ".$name."\n";
			$local_val='error';
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

		}
		
	}
	
	
	
	
	} catch (Exception $e) {
    echo date("Y-m-d H:i:s")." Error.\n";
    echo $e;
    exit;
}


?>
