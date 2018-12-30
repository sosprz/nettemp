<?php
$froot = "/var/www/nettemp";

$db = new PDO("sqlite:$froot/dbf/nettemp.db");
	$query = $db->query("SELECT * FROM nt_settings");
    $result= $query->fetchAll();
    
    foreach($result as $s) {
		
		if($s['option']=='logs') {
			$logsonoff=$s['value'];
		}
	}


function logs($date,$type,$message)
	{
		global $logsonoff;
		
	if ($logsonoff == 'on') {
		
		$froot = "/var/www/nettemp";	
		$db = new PDO("sqlite:$froot/dbf/nettemp.db") or die ("cannot open database");
		$db->exec("INSERT INTO logs ('date', 'type', 'message') VALUES ('$date', '$type', '$message')");
		}
	}

// SEND SMS Function

function send_sms($date,$type,$message)

{
	$arg1 = array('ą', 'Ą', 'ć', 'Ć', 'ę', 'Ę', 'ł', 'Ł', 'ń', 'Ń', 'ó', 'Ó', 'ś', 'Ś', 'ź', 'Ź', 'ż', 'Ż' );
	$arg2 = array('a', 'a', 'c', 'c', 'e', 'e', 'l', 'l', 'n', 'n', 'o', 'o', 's', 's', 'z', 'z', 'z', 'z' );
	$message = str_replace ( $arg1, $arg2, $message );


	$froot = "/var/www/nettemp";	
	
	 if(!is_dir("$froot/tmp/sms")) {
		 
		 mkdir("$froot/tmp/sms");
	 }
	$dbr = new PDO("sqlite:$froot/dbf/nettemp.db") or die ("cannot open database");
    $sthr = $dbr->query("SELECT tel FROM users WHERE smsa='yes' AND tel != '' ");
    $row = $sthr->fetchAll();
	
	$numRows = count($row);
	if ($numRows == 0 ) {
		
		logs($date,'Error','User doesnt have phone number - go to settings - users');
			
	}else {
	
    foreach($row as $row) {
		$smsto[]=$row['tel'];
    }
	
			for ($x = 0, $cnt = count($smsto); $x < $cnt; $x++){
			$random=substr(rand(), 0, 4);
			
			$sms = "To: ".$smsto[$x]."\n\n".$message;
			$filepath = $froot."/tmp/sms/message_".$date."_".$random.".sms";
			$fsms = fopen($filepath, 'a+');
			fwrite($fsms, $sms);
			fclose($fsms);
			$ftosend = "/var/spool/sms/outgoing/message_".$date."_".$random.".sms";
	
			if (!copy($filepath, $ftosend)) {
			echo "Send failed.\n";
			logs($date,'Error',$message." - Unable to send SMS message - check configurations ");
			} else {
				echo "Send OK.\n";
				logs($date,'Info',$message." - SMS was sent.");
			}
			unlink($filepath);
			}
			
}
}

?>
