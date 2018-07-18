<?php
$ROOT=dirname(dirname(dirname(__FILE__)));
 
$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 
$minute=date('i');

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	$query = $db->query("SELECT * FROM nt_settings");
    $result= $query->fetchAll();
    
    foreach($result as $s) {
		if($s['option']=='mail_onoff' && $s['value']!='on') {
			echo $date." Cannot send mail bacause fucntion is off, go to settings.\n";
			exit();
		}
		if($s['option']=='mail_topic') {
			$mail_topic=$s['value'];
		}
	}

	
	$query = $db->query("SELECT mail FROM users WHERE maila='yes'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$get_addr[]=$s['mail'];
	}
	if(empty($get_addr)) {
		echo $date." Add users to nettemp settings!\n";
		exit;
	}
	
    $string = rtrim(implode(' ', $get_addr), ',');
    $addr = rtrim(implode(' ', $get_addr), ',');
    
    $cfile = '/etc/msmtprc';
	$fh = fopen($cfile, 'r');
	$theData = fread($fh, filesize($cfile));
	$cread = array();
	$my_array = explode(PHP_EOL, $theData);
	foreach($my_array as $line)
		{
			if (!empty($line)) {
				$tmp = explode(" ", $line);
				$cread[$tmp[0]] = $tmp[1];
			}
		}
	fclose($fh);
	$a=$cread;
	$headers = "From: ".$a['user']."\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	function message($name,$value,$date,$state,$color)
	{
	$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			 <html>
			 <head>
			 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	         <style>* { margin: 0; padding: 0; } a {text-decoration: none;} th, td {  padding: 5px;} table, th, td { border: 1px solid black;  border-collapse: collapse;} * {font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;}</style>
			 </head>
			 <body bgcolor="#ffffff" text="#000000">
			 <h4>Hi, this is notification from <a href="http://'.trim(shell_exec("hostname -I | cut -d' ' -f1")).'">'.trim(shell_exec("hostname -I | cut -d' ' -f1")).'</a></br></h4><br>
			 <table border="1" style="">
			 <tr><th>Name</th><th>Value</th><th>Date</th><th>Status</th></tr><tr>
			 <td>'.$name.'</td><td>'.$value.'</td><td>'.$date.'</td><td bgcolor="'.$color.'">'.$state.'</td>
			 </tr></table><br><br>
			 <a href="http://techfreak.pl/tag/nettemp"> <img src="http://techfreak.pl/wp-content/uploads/2012/12/nettemp.pl_.png" style="width:120px;height:40px;"></a><br>
			 </div>
			 </body>
			 </html>';
	return $body;
	}
	

    
    //HOST LOST 
    $query = $db->query("SELECT rom,name,mail FROM sensors WHERE alarm='on' AND status='error' AND type='host'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$rom=$s['rom'];
		$name=$s['name'];
		$mail=$s['mail'];
		if(($mail!='sent')||($minute=='00')){
		    echo $date." Sending to: ".$string."\n";
		    
			if ( mail ($addr, $mail_topic, message($name,0,$date,"Lost connecion","#FF0000"), $headers ) ) {
				echo $date." Lost cnnection with: ".$name." - Mail send OK\n";
			} else {
				echo $date." Lost cnnection with: ".$name." - Mail send problem\n";
			}
			$db->exec("UPDATE sensors SET mail='sent' WHERE rom='$rom'");
		} else {
			echo $date." Wait to full hour: ".$name."\n";
		}
	}
	
	//HOST RECOVERY
	$query = $db->query("SELECT rom,name,mail FROM sensors WHERE type='host' AND status!='error'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$rom=$s['rom'];
		$name=$s['name'];
		$mail=$s['mail'];
		if($mail=='sent'){
		    echo $date." Sending to: ".$string."\n";
			if ( mail ($addr, $mail_topic, message($name,0,$date,"Recovery","#00FF00"), $headers ) ) {
				echo $date." ".$name." recovery - Mail send OK\n";
				$db->exec("UPDATE sensors SET mail='' WHERE rom='$rom'");
			} else {
				echo $date." ".$name." recovery - Mail send problem\n";
			}
			
		} 
	}
	
	//TEMP
	$query = $db->query("SELECT name,rom,tmp,tmp_min,tmp_max,mail,type,current FROM sensors WHERE alarm='on' AND type!='host'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$tmpmin=$s['tmp_min'];
		$tmpmax=$s['tmp_max'];
		$type=$s['type'];
		
		if ($type == 'elec' || $type == 'water' || $type == 'gas' ) {
			$tmp=$s['current'];
		}else {
			$tmp=$s['tmp'];
		}
		
		$rom=$s['rom'];
		$name=$s['name'];
		$mail=$s['mail'];
	
		//MAX
		if($tmp>$tmpmax&&is_numeric($tmpmax)) {
			if(($mail!='sentmax')||($minute=='00')){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, $mail_topic, message($name,$tmp,$date,"High value","#FF0000"), $headers ) ) {
					echo $date." High value ".$name." - Mail send OK\n";
				} else {
					echo $date." High value ".$name." - Mail send problem\n";
				}
				$db->exec("UPDATE sensors SET mail='sentmax' WHERE rom='$rom'");
			} else {
				echo $date." Wait to full hour: ".$rom."\n";
			}
		}
		//MIN 
		elseif($tmp<$tmpmin&&is_numeric($tmpmin)) {
			if(($mail!='sentmin')||($minute=='00')){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, $mail_topic, message($name,$tmp,$date,"Low value","#FF0000"), $headers ) ) {
					echo $date." Low value ".$name." - Mail send OK\n";
				} else {
					echo $date." Low value ".$name." - Mail send problem\n";
				}
				$db->exec("UPDATE sensors SET mail='sentmin' WHERE rom='$rom'");
			} else {
				echo $date." Wait to full hour: ".$rom."\n";
			}
		}
		//RECOVERY 
		else {
			if(!empty($mail)){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, $mail_topic, message($name,$tmp,$date,"Recovery","#00FF00"), $headers ) ) {
					echo $date." Recovery ".$name." ".$tmp." - Mail send OK\n";
					$db->exec("UPDATE sensors SET mail='' WHERE rom='$rom'");
				} else {
					echo $date." Recovery ".$name." ".$tmp." - Mail send problem\n";
				}
			}
		}
	

	
	 
	
	// TEMP remove if empty
	if($mail=='sent' && empty($tmpmax) && empty($tmpmin)){
			echo $date." No min & max value, remove file ".$name."\n";
			$db->exec("UPDATE sensors SET mail='' WHERE rom='$rom'");
		}
		
	
	}
	
	
	 //READ ERR
    $query = $db->query("SELECT rom,name,time,readerrsend,readerr FROM sensors WHERE readerralarm='on' AND type!='host'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$rom=$s['rom'];
		$name=$s['name'];
		$readerrsend=$s['readerrsend'];
		$time=$s['time'];
		$readerr=$s['readerr'];
		
		if(strtotime($time)<(time()-($readerr*60)) && !empty($readerr)) {
		if(($readerrsend!='sent')||($minute=='00')){
		    echo $date." Sending to: ".$string."\n";
		    
			if ( mail ($addr, $mail_topic, message($name,"---",$date,"Read sensor error","#FF0000"), $headers ) ) {
				echo $date." Read error in: ".$name." - Mail send OK\n";
			} else {
				echo $date." Read error in: ".$name." - Mail send problem\n";
			}
			$db->exec("UPDATE sensors SET readerrsend='sent' WHERE rom='$rom'");
		} else {
			echo $date." Wait to full hour: ".$name."\n";
		}
		
		}
	}
	
	//READ ERR RECOVERY
	$query = $db->query("SELECT rom,name,time,readerrsend,readerr FROM sensors WHERE readerralarm='on' AND readerrsend='sent'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$rom=$s['rom'];
		$name=$s['name'];
		$readerrsend=$s['readerrsend'];
		$time=$s['time'];
		$readerr=$s['readerr'];
		
		if($readerrsend == 'sent' && strtotime($time)>(time()- 60) && !empty($readerr)){
		    echo $date." Sending to: ".$string."\n";
			if ( mail ($addr, $mail_topic, message($name,"---",$date,"Read sensor recovery","#00FF00"), $headers ) ) {
				echo $date." ".$name." Read recovery - Mail send OK\n";
				$db->exec("UPDATE sensors SET readerrsend='' WHERE rom='$rom'");
			} else {
				echo $date." ".$name." Read recovery - Mail send problem\n";
			}
			
		} 
	}
	
	
	//REMOVE if ALARM OFF
	// unlink in modules/sensors/html/sensor_settings.php
	
    
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
