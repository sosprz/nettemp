<?php
$ROOT=dirname(dirname(dirname(__FILE__)));


var_dump($argv);
parse_str($argv[1],$interval_param);
$ninterval=$interval_param['ninterval'];

$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 
$minute=date('i');
$hour=date('H');

try {
	$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
	$query = $db->query("SELECT * FROM nt_settings");
    $result= $query->fetchAll();
    
    foreach($result as $s) {
		//if($s['option']=='mail_onoff' && $s['value']!='on') {
		//	echo $date." Cannot send mail bacause fucntion is off, go to settings.\n";
		//	exit();
		//}
		if($s['option']=='pusho_active') {
			$pusho=$s['value'];
		}
		if($s['option']=='pusho_user_key') {
			$pushoukey=$s['value'];
		}
		if($s['option']=='pusho_api_key') {
			$pushoakey=$s['value'];
		}
		if($s['option']=='sensorinterval') {
			$sens_interval=$s['value'];
		}
		if($s['option']=='switchinterval') {
			$sw_interval=$s['value'];
		}
		if($s['option']=='mail_onoff') {
			$mailonoff=$s['value'];
		}
	}
	
	$query = $db->query("SELECT mail FROM users WHERE maila='yes'");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$get_addr[]=$s['mail'];
	}
	if(empty($get_addr)) {
		echo $date." Add users to nettemp settings!\n"; // dopisac obsluge bledu/logów
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
	
	
	
	
	
}catch (Exception $e) {
    echo $date." Error\n";
    exit;
}




function send_not ($nid,$nrom,$notname,$notmessage,$notsms,$notmail,$notpov,$priority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery){
	
	$ROOT=dirname(dirname(dirname(__FILE__)));
	$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
	
	//$notsent = 0;
	$notsentrec2 = 0;
	
	if ($notsms == 'on') {
		
		echo "Wysyłam SMS - ".$notmessage."\n";
		
		
	}
	
	if ($mailonoff == 'on') {
		
		
		if (($notmail == 'on' && $nsent == '') ){ //Send Notification MAIL
			
						echo "Wysyłam mail - ".$notmessage."\n";
						$db->exec("UPDATE sensors SET mail='sent' WHERE rom='$nrom'");
						//$db->exec("UPDATE notifications SET sent='sent' WHERE id='$nid'");
						//$notsent = 1;
				}else if ($notmail == 'on' && $nsent == 'sent'){ //RECOVERY MAIL
				
						echo "Wysyłam mail - RECOVERY - ".$notmessage."\n";
						$db->exec("UPDATE sensors SET mail='' WHERE rom='$nrom'");
						//$db->exec("UPDATE notifications SET sent='' WHERE id='$nid'");
						//$notsentrec = 1;
					
					
					
				}
		
		
	}
	
	if ($pusho == 'on') { //if global notification for po is on
		
				if (($notpov == 'on' && $notsent == 1) ){ //Send Notification PO
			
						curl_setopt_array($ch = curl_init(), array(
						  CURLOPT_URL => "https://api.pushover.net/1/messages.json",
						  CURLOPT_POSTFIELDS => array(
							"token" => "$pushoakey",
							"user" => "$pushoukey",
							"message" => "$notmessage",
							"priority" => "$priority",
							"retry" => "30",
							"expire" => "3600",						
						  ),
						  CURLOPT_SAFE_UPLOAD => true,
						  CURLOPT_RETURNTRANSFER => true,
						));
						curl_exec($ch);
						curl_close($ch);	
						
						echo "Wysyłam PoshOver - ".$notmessage."\n";
						
				}else if ($nrecovery == 'on' && $notpov == 'on' && $notsentrec == 1){  // RECOVERY PO
				
						curl_setopt_array($ch = curl_init(), array(
						  CURLOPT_URL => "https://api.pushover.net/1/messages.json",
						  CURLOPT_POSTFIELDS => array(
							"token" => "$pushoakey",
							"user" => "$pushoukey",
							"message" => "$notmessage",
							"priority" => "$priority",
							"retry" => "30",
							"expire" => "3600",						
						  ),
						  CURLOPT_SAFE_UPLOAD => true,
						  CURLOPT_RETURNTRANSFER => true,
						));
						curl_exec($ch);
						curl_close($ch);	
						
						$notsentrec2 = 1;

						echo "Wysyłam PoshOver - Recovery - ".$notmessage."\n";
					
				}
	}
	
	if ($notsent == 1){
		$db->exec("UPDATE notifications SET sent='sent' WHERE id='$nid'");
		echo "Robie normal\n";
	}
	
	if ($notsentrec == 1 && $notsentrec2 == 1){
		$db->exec("UPDATE notifications SET sent='' WHERE id='$nid'");
		echo "Robie recovery\n";
	}
	
	
	
		
}

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	$query = $db->query("SELECT * FROM notifications WHERE active='on' AND interval = '$ninterval'");
    $result= $query->fetchAll();
    
    foreach($result as $sn) {
		
		$nid=$sn['id'];
		$nrom=$sn['rom'];
		$ntype=$sn['type'];
		$nwhen=$sn['wheen'];
		$nvalue=$sn['value'];
		$nsms=$sn['sms'];
		$nmail=$sn['mail'];
		$npov=$sn['pov'];
		$nmsg=$sn['message'];
		$npriority=$sn['priority'];
		$niginterval=$sn['iginterval'];
		$nrecovery=$sn['recovery'];
		$nsent=$sn['sent'];
		$notsent = 0;
		$notsentrec = 0;
		$message = '';
				
		$sensor = $db->query("SELECT name,tmp,current,type FROM sensors WHERE rom='$nrom'");
		$sensors = $sensor->fetchAll();
		
		foreach ($sensors as $sen) {
			
			$sname=$sen['name'];
			$stmp=$sen['tmp'];
			$scurrent=$sen['current'];
			$stype=$sen['type'];
			
		}	
//check type 

			if ($nwhen == '1') {
				
				if (($stmp < $nvalue) && $nsent == 'sent') {
					$notsent = 1;
					}elseif (($stmp > $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." value is ".$stmp." < ".$nvalue;	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = "Recovery - ".$sname." value is ".$stmp." > ".$nvalue;	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery);
					
					
			}elseif ($nwhen == '2') {
				
				if (($stmp <= $nvalue) && $nsent == 'sent') {
					$notsent = 1;
					}elseif (($stmp >= $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." value is ".$stmp." <= ".$nvalue;	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = "Recovery - ".$sname." value is ".$stmp." >= ".$nvalue;	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery);
				
			}elseif ($nwhen == '3') {
				
				if (($stmp > $nvalue) && $nsent == 'sent') {
					$notsent = 1;
					}elseif (($stmp < $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." value is ".$stmp." > ".$nvalue;	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = "Recovery - ".$sname." value is ".$stmp." < ".$nvalue;	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery);
	
			}elseif ($nwhen == '4') {
				
				if (($stmp >= $nvalue) && $nsent == 'sent') {
					$notsent = 1;
					}elseif (($stmp <= $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." value is ".$stmp." >= ".$nvalue;	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = "Recovery - ".$sname." value is ".$stmp." <= ".$nvalue;	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery);
				
			}elseif ($nwhen == '5') {
				
				if (($stmp == $nvalue) && $nsent == 'sent') {
					$notsent = 1;
					}elseif (($stmp != $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." value is ".$stmp." == ".$nvalue;	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = "Recovery - ".$sname." value is ".$stmp." != ".$nvalue;	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery);	
				
			}elseif ($nwhen == '6') {
				
				if (($stmp != $nvalue) && $nsent == 'sent') {
					$notsent = 1;
					}elseif (($stmp == $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." value is ".$stmp." != ".$nvalue;	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = "Recovery - ".$sname." value is ".$stmp." == ".$nvalue;	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$sens_interval,$sw_interval,$nsent,$notsent,$notsentrec,$nrecovery);	
			}
	
	}
	
//try end	
} catch (Exception $e) {
    echo $date." Error\n";
    exit;
}

?>