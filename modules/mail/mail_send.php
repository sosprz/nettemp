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
	$query = $db->query("SELECT mail FROM users WHERE maila='yes'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$get_addr[]=$s['mail'];
	}
	if(empty($get_addr)) {
		echo "Add users to nettemp!\n";
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
    
    //HOST LOST 
    $query = $db->query("SELECT rom,name FROM hosts WHERE alarm='on' AND (status='error' OR last='0')");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$rom=$s['rom'];
		$name=$s['name'];
		if(!file_exists("$ROOT/tmp/mail/hour/$rom.mail")||($minute=='00')){
		    echo $date." Sending to: ".$string."\n";
			if ( mail ($addr, 'Mail from nettemp device', "Lost connection with $name", $headers ) ) {
				echo $date." Lost cnnection with: ".$name." - Mail send OK\n";
			} else {
				echo $date." Lost cnnection with: ".$name." - Mail send problem\n";
			}
			fopen("$ROOT/tmp/mail/hour/$rom.mail", "w");
		} else {
			echo $date." Wait to full hour: ".$name."\n";
		}
	}
	
	//HOST RECOVERY
	$query = $db->query("SELECT rom,name FROM hosts WHERE status='ok'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$rom=$s['rom'];
		$name=$s['name'];
		if(file_exists("$ROOT/tmp/mail/hour/$rom.mail")){
		    echo $date." Sending to: ".$string."\n";
			if ( mail ($addr, 'Mail from nettemp device', "Recovery connection with $name", $headers ) ) {
				echo $date." ".$name." recovery - Mail send OK\n";
				unlink("$ROOT/tmp/mail/hour/$rom.mail");
			} else {
				echo $date." ".$name." recovery - Mail send problem\n";
			}
			
		} 
	}
	
	//TEMP
	$query = $db->query("SELECT name,rom,tmp,tmp_min,tmp_max FROM sensors WHERE alarm='on'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$tmpmin=$s['tmp_min'];
		$tmpmax=$s['tmp_max'];
		$tmp=$s['tmp'];
		$rom=$s['rom'];
		$name=$s['name'];
	
	//TEMP MAX
	if(!empty($tmpmax)) {
		if($tmp>$tmpmax) {
			if(!file_exists("$ROOT/tmp/mail/hour/$rom.mail")||($minute=='00')){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, 'Mail from nettemp device', "High value in $name $tmp", $headers ) ) {
					echo $date." High value ".$name." - Mail send OK\n";
				} else {
					echo $date." High value ".$name." - Mail send problem\n";
				}
				fopen("$ROOT/tmp/mail/hour/$rom.mail", "w");
			} else {
				echo $date." Wait to full hour: ".$rom."\n";
			}
			
		} else {
			if(file_exists("$ROOT/tmp/mail/hour/$rom.mail")){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, 'Mail from nettemp device', "Recovery ".$name." ".$tmp, $headers ) ) {
					echo $date." Recovery ".$name." ".$tmp." - Mail send OK\n";
					unlink("$ROOT/tmp/mail/hour/$rom.mail");
				} else {
					echo $date." Recovery ".$name." ".$tmp." - Mail send problem\n";
				}
			}
		}
	} 
		
	//TEMP MIN	
	if(!empty($tmpmin)) {
		if($tmp<$tmpmin) {
			if(!file_exists("$ROOT/tmp/mail/hour/$rom.mail")||($minute=='00')){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, 'Mail from nettemp device', "Low value in ".$name." ".$tmp, $headers ) ) {
					echo $date." Low value ".$name." - Mail send OK\n";
				} else {
					echo $date." Low value ".$name." - Mail send problem\n";
				}
				fopen("$ROOT/tmp/mail/hour/$rom.mail", "w");
			} else {
				echo $date." Wait to full hour: ".$rom."\n";
			}
		} else {
			if(file_exists("$ROOT/tmp/mail/hour/$rom.mail")){
				echo $date." Sending to: ".$string."\n";
				if ( mail ($addr, 'Mail from nettemp device', "Recovery ".$name." ".$tmp, $headers ) ) {
					echo $date." Recovery ".$name." ".$tmp." - Mail send OK\n";
					unlink("$ROOT/tmp/mail/hour/$rom.mail");
				} else {
					echo $date." Recovery ".$name." ".$tmp." - Mail send problem\n";
				}
			}
		}
	} 
	
	// TEMP remove if empty
	if(file_exists("$ROOT/tmp/mail/hour/$rom.mail") && empty($tmpmax) && empty($tmpmin)){
			echo $date." No min & max value, remove file ".$name."\n";
			unlink("$ROOT/tmp/mail/hour/$rom.mail");
		}
		
	
	}//for
	
	//REMOVE if ALARM OFF
	
    
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
