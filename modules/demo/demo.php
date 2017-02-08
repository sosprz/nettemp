<?php
$ROOT=dirname(dirname(dirname(__FILE__)));

include("$ROOT/receiver.php");

$demo_device=array("ip", "wireless", "remote", "gpio", "i2c", "usb");
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM types");
$row = $rows->fetchAll();
$loop=10;
for ($x = 0; $x <= $loop; $x++) {
	foreach($row as $t) {
		foreach($demo_device as $d){
			$local_type=$t['type'];
			$local_val=substr(rand(), 0, 1);
			$local_device=$d;
			$local_rom=$local_device."_demo_".$local_type;
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			//echo $local_rom." ".$local_val."\n";
			
			//add db and insert to sensors
			$dbnew = new PDO("sqlite:db/$local_rom.sql");
			$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
			$dbnew->exec("CREATE INDEX time_index ON def(time)");
			
			if(file_exists("$ROOT/db/".$local_rom.".sql")&&filesize("db/".$local_rom.".sql")!=0){
				$db->exec("INSERT INTO sensors (rom,type,device,ip,gpio,i2c,usb,name) SELECT rom,type,device,ip,gpio,i2c,usb,name FROM newdev WHERE rom='$local_rom'");
			}
		}
	}

	//Multi type
	shell_exec("php-cgi -f ".$ROOT."/receiver.php key=admin type=\"temp;humid\" value=\"".substr(rand(), 0, 1).";".substr(rand(), 0, 1)."\"  device=ip  name=MultiType  id=100 ip=\"172.18.10.100\"");
	//Multi ID
	shell_exec("php-cgi -f ".$ROOT."/receiver.php key=admin type=\"temp;humid\" value=\"".substr(rand(), 0, 1).";".substr(rand(), 0, 1)."\"  device=ip  name=MultiID  id=\"101;102\" ip=\"172.18.10.101\"");
	//ONE ID
	shell_exec("php-cgi -f ".$ROOT."/receiver.php key=admin type=\"temp\" value=\"".substr(rand(), 0, 1).";".substr(rand(), 0, 1)."\"  device=ip  name=OneID id=103 gpio=5 ip=\"172.18.10.102\"");
	//ONE ID switch
	shell_exec("php-cgi -f ".$ROOT."/receiver.php key=admin type=\"switch\" value=\"".substr(rand(), 0, 1).";".substr(rand(), 0, 1)."\"  device=ip  name=OneIDswitch  id=104 gpio=6 ip=\"172.18.10.103\"");

	
	echo "loop".$x."\n";
	
}
				
?>
