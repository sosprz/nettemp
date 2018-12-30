<?php
$ROOT=dirname(dirname(dirname(__FILE__)));

include("$ROOT/common/functions.php");


var_dump($argv);
parse_str($argv[1],$interval_param);
$ninterval=$interval_param['ninterval'];


$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 
$minute=date('i');
$hour=date('H');
$nomail = 0;


	$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
	$query = $db->query("SELECT * FROM nt_settings");
    $result= $query->fetchAll();
    
    foreach($result as $s) {
		if($s['option']=='mail_onoff' && $s['value']!='on') {

			$nomail = 1 ;
		
		}
		if($s['option']=='pusho_active') {
			$pusho=$s['value'];
		}
		if($s['option']=='pusho_user_key') {
			$pushoukey=$s['value'];
		}
		if($s['option']=='pusho_api_key') {
			$pushoakey=$s['value'];
		}
		if($s['option']=='mail_onoff') {
			$mailonoff=$s['value'];
		}
		if($s['option']=='mail_topic') {
			$mail_topic=$s['value'];
		}
	}
	
	$query = $db->query("SELECT mail, tel FROM users WHERE maila='yes' ");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$get_addr[]=$s['mail'];
	}
	if(empty($get_addr)) {
		echo $date." Cannot send mail because user doesnt have email, go to settings - users.\n";
		logs($date,'Error','Cannot send mail because user doesnt have email, go to settings - users.'); 
		
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
	
	function message($notname,$notmessage,$date,$color)
	{
	$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			 <html>
			 <head>
			 <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	         <style>* { margin: 0; padding: 0; } a {text-decoration: none;} th, td {  padding: 5px;} table, th, td { border: 1px solid black;  border-collapse: collapse;} * {font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;}</style>
			 </head>
			 <body bgcolor="#ffffff" text="#000000">
			 <h4>Hi, this is notification from '.trim(shell_exec("hostname -I | cut -d' ' -f1")).'</a></br></h4><br>
			 <table border="1" style="">
			 <tr><th>Date</th><th>Message</th></tr><tr>
			 <td>'.$date.'</td><td bgcolor="'.$color.'">'.$notmessage.'</td>
			 </tr></table><br
			 </div>
			 </body>
			 </html>';
	return $body;
	}



function send_not ($nid,$nrom,$notname,$notmessage,$notsms,$notmail,$notpov,$priority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype){
	
	$ROOT=dirname(dirname(dirname(__FILE__)));
	$db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
	
	$notsentrec2 = 0;
	
	if ($notsms == 'on' && $notsent == 1) {
		
		echo "Wysyłam SMS - ".$notmessage."\n";
		send_sms($date,'Notifications',$notmessage);
		logs($date,'Notifications',$notmessage." - SMS");
		
	}else if ($nrecovery == 'on' && $notsms == 'on' && $notsentrec == 1){ //RECOVERY SMS
	
		echo "Wysyłam SMS - ".$notmessage."\n";
		send_sms($date,'Notifications',$notmessage);
		logs($date,'Notifications',$notmessage." - SMS");
		$notsentrec2 = 1;
	
	}
	
	if ($mailonoff == 'on') {
		
		
		if (($notmail == 'on' && $notsent == 1) ){ //Send Notification MAIL
			
						
						if ( mail ($addr, $mail_topic, message($notname,$notmessage,$date,"#FF0000"), $headers ) ) {
							echo "Mail send OK\n";
						} else {
						echo "Mail send problem\n";
						}					
						//echo "Wysyłam mail - ".$notmessage."\n";
						logs($date,'Notifications',$notmessage." - Mail");
						
				}else if ($nrecovery == 'on' && $notmail == 'on' && $notsentrec == 1){ //RECOVERY MAIL
				
				if ( mail ($addr, $mail_topic, message($notname,$notmessage,$date,"#00FF00"), $headers ) ) {
							echo "Mail send OK\n";
						} else {
						echo "Mail send problem\n";
						}
						$notsentrec2 = 1;
						//echo "Wysyłam mail - RECOVERY - ".$notmessage."\n";
						logs($date,'Notifications',$notmessage." - Mail");
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
						logs($date,'Notifications',$notmessage." - PushOver");
						
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
						logs($date,'Notifications',$notmessage." - PushOver");
				}
	}
	
	if ($notsent == 1){
		$db->exec("UPDATE notifications SET sent='sent' WHERE id='$nid'");
		$db->exec("UPDATE sensors SET mail='sent' WHERE rom='$nrom'");
		if ($ntype =='lupdate'){
			$db->exec("UPDATE sensors SET readerrsend='sent' WHERE rom='$nrom'");
		}
	}
	
	if ($notsentrec == 1 && $notsentrec2 == 1){
		$db->exec("UPDATE notifications SET sent='' WHERE id='$nid'");
		//$db->exec("UPDATE notifications SET fc='on' WHERE id='$nid'");
		$db->exec("UPDATE sensors SET mail='sent' WHERE rom='$nrom'");
		//if ($ntype =='lupdate'){
			//$db->exec("UPDATE sensors SET readerrsend='' WHERE rom='$nrom'");
		//}	
	}
	
	if ($notsentrec == 1 && $ntype == 'lupdate'){
		
		$db->exec("UPDATE sensors SET readerrsend='' WHERE rom='$nrom'");
		
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
	
	if ($ninterval != '0m'){
		
		$query = $db->query("SELECT * FROM notifications WHERE active='on' AND interval = '$ninterval' ");
		}else 
			{
				$query = $db->query("SELECT * FROM notifications WHERE active='on' ");
			}
	//unset($ninterval);		
	
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
		$onlyrec = '';
		//if ($ninterval == '0m'){$nsent = '';}
		
		if ($ninterval == '0m' && $nsent == 'sent'){$onlyrec = 'on';}
		
		if ($nmail == 'on' && $nomail == 1){
			
			logs($date,'Error','Cannot send mail because function is off, go to settings - notifications.'); 
			$nomail = 0 ;
			}
				
				
				
				
		$sensor = $db->query("SELECT name,tmp,current,type,time, status FROM sensors WHERE rom='$nrom'");
		$sensors = $sensor->fetchAll();
		
		foreach ($sensors as $sen) {
			
			$sname=$sen['name'];
			$stmp=$sen['tmp'];
			$scurrent=$sen['current'];
			$stype=$sen['type'];
			$stime=$sen['time'];
			$sstatus=$sen['status'];
			
			if ($stype == 'elec' || $stype == 'water' || $stype == 'gas'){
				$stmp = $scurrent;
			}
			
		}	
//check type 
 if ($ntype == 'value') {

			if ($nwhen == '1') {
				
			
				if (($stmp < $nvalue) && $onlyrec != 'on') {
					$notsent = 1;
					}elseif (($stmp >= $nvalue) && ($nsent == 'sent')) {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg." - ".$sname." - ".$stmp." [ < ".$nvalue." ]";
							
							}else {
								$message = $sname." - value is ".$stmp." [ < ".$nvalue." ]";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg." - ".$sname." - ".$stmp." [ < ".$nvalue." ]";

							
							}else {
								$message = "Recovery - ".$sname." - value is ".$stmp." [ < ".$nvalue." ]";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);
					
					
			}elseif ($nwhen == '2') {
				
				if (($stmp <= $nvalue) && $onlyrec != 'on') {
					$notsent = 1;
					}elseif (($stmp > $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
						
;					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg." - ".$sname." - ".$stmp." [ <= ".$nvalue." ]";
							
							}else {
								$message = $sname." - value is ".$stmp." [ <= ".$nvalue." ]";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg." - ".$sname." - ".$stmp." [ <= ".$nvalue." ]";
							
							}else {
								$message = "Recovery - ".$sname." - value is ".$stmp." [ <= ".$nvalue." ]";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);
				
			}elseif ($nwhen == '3') {
				
				if (($stmp > $nvalue) && $onlyrec != 'on') {
					$notsent = 1;
					}elseif (($stmp <= $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg." - ".$sname." - ".$stmp." [ > ".$nvalue." ]";
							
							}else {
								$message = $sname." - value is ".$stmp." [ > ".$nvalue." ]";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg." - ".$sname." - ".$stmp." [ > ".$nvalue." ]";
							
							}else {
								$message = "Recovery - ".$sname." - value is ".$stmp." [ > ".$nvalue." ]";		
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);
	
			}elseif ($nwhen == '4') {
				
				if (($stmp >= $nvalue) && $onlyrec != 'on') {
					$notsent = 1;
					}elseif (($stmp < $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg." - ".$sname." - ".$stmp." [ >= ".$nvalue." ]";
							
							}else {
								$message = $sname." - value is ".$stmp." [ >= ".$nvalue." ]";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg." - ".$sname." - ".$stmp." [ >= ".$nvalue." ]";
							
							}else {
								$message = "Recovery - ".$sname." - value is ".$stmp." [ >= ".$nvalue." ]";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);
				
			}elseif ($nwhen == '5') {
				
				if (($stmp == $nvalue) && $onlyrec != 'on') {
					$notsent = 1;
					}elseif (($stmp != $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg." - ".$sname." - ".$stmp." [ == ".$nvalue." ]";
							
							}else {
								$message = $sname." - value is ".$stmp." [ == ".$nvalue." ]";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg." - ".$sname." - ".$stmp." [ == ".$nvalue." ]";
							
							}else {
								$message = "Recovery - ".$sname." - value is ".$stmp." [ == ".$nvalue." ]";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);	
				
			}elseif ($nwhen == '6') {
				
				if (($stmp != $nvalue) && $onlyrec != 'on') {
					$notsent = 1;
					}elseif (($stmp == $nvalue) && $nsent == 'sent') {
						$notsentrec = 1;
					}
						if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg." - ".$sname." - ".$stmp." [ != ".$nvalue." ]";
							
							}else {
								$message = $sname." - value is ".$stmp." [ != ".$nvalue." ]";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg." - ".$sname." - ".$stmp." [!= ".$nvalue." ]";
							
							}else {
								$message = "Recovery - ".$sname." - value is ".$stmp." [ != ".$nvalue." ]";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);	
			}
 } elseif ($ntype == 'lupdate') {
	 
	 if((strtotime($stime)<(time()-($nvalue*60))) && $onlyrec != 'on') {
		 $notsent = 1;
	 }elseif ((strtotime($stime)>(time()- 60)) && $nsent == 'sent') {
		 $notsentrec = 1;
	 }
	 
		if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." - Lost communications";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg;
							
							}else {
								$message = $sname." - Recovered communications";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);	

	 
	}	elseif ($ntype == 'lhost') {
	 
	 if($sstatus == 'error' && $onlyrec != 'on') {
		 $notsent = 1;
	 }elseif ($sstatus != 'error' && $nsent == 'sent') {
		 $notsentrec = 1;
	 }
	 
		if ($notsent == 1) {
							
							if (!empty($nmsg)) {
							$message = $nmsg;
							
							}else {
								$message = $sname." - Lost connection with host";	
							}
						}
				
						if ($notsentrec == 1) {
							
							if (!empty($nmsg)) {
							$message = "Recovery - ".$nmsg;
							
							}else {
								$message = $sname." - Recovered connection with host";	
							}
						}
						send_not($nid,$nrom,$sname,$message,$nsms,$nmail,$npov,$npriority,$pusho,$mailonoff,$pushoukey,$pushoakey,$nsent,$notsent,$notsentrec,$nrecovery,$addr,$mail_topic,$date,$headers,$ntype);	

	}
	
	}
	
//try end	
} catch (Exception $e) {
    echo $date." Error\n";
    exit;
}


?>