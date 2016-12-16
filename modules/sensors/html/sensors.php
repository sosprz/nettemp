<?php

$name_new = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$color = isset($_POST['color']) ? $_POST['color'] : '';

$name_id = isset($_POST['name_id']) ? $_POST['name_id'] : '';
$usun_rom_nw = isset($_POST['usun_nw']) ? $_POST['usun_nw'] : '';

$id_rom_new2 = isset($_POST['id_rom_new']) ? $_POST['id_rom_new'] : '';
$id_rom_new=trim($id_rom_new2);
$add_graf = isset($_POST['add_graf']) ? $_POST['add_graf'] : '';
$del_graf = isset($_POST['del_graf']) ? $_POST['del_graf'] : '';
$name_new2 = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$name_new=trim($name_new2);

?>

<?php 
	if(!empty($id_rom_new)) {
	$name=substr(rand(), 0, 4);
	$gpio='';
	$type='';
	$device='';
	$method='';
	$ip='';
	$map_num=substr(rand(), 0, 4);
	$map_num2=substr(rand(), 0, 4);
	
	//types
	$query = $db->query("SELECT * FROM types");
	$result_t = $query->fetchAll();

	foreach($result_t as $ty){
   	if (strpos($id_rom_new,$ty['type']) !== false) {
	   	$type=$ty['type'];
	   	break;
	   } elseif (substr($id_rom_new, 0, 4 ) === "0x26") {
			$type='humid';
			break;
	   } 
	}
	   
	if(empty($type)){
		$type='temp';
	}


	//method
	//ip
	if (strpos($id_rom_new, ".") !== false) {
	    $pieces = explode("_", $id_rom_new);
	    $ip=$pieces[1];
	    $method='post';
	}

	//dev
	if (strpos($id_rom_new,'ip') !== false) {
		 $device='ip';
	}
	elseif (strpos($id_rom_new,'wireless') !== false) {
		 $device='wireless';
	} 
	elseif (strpos($id_rom_new,'remote_') !== false) {
    	  $device='remote';
	}
	elseif (strpos($id_rom_new,'gpio') !== false) {
	    $device='gpio';
	    $rest1=str_replace("_humid", "", "$id_rom_new");
	    $rest2=str_replace("_temp", "", "$rest1");
	    $gpio=str_replace("gpio_", "", "$rest2");    
	}
	elseif (strpos($id_rom_new,'i2c') !== false) {
	    $device='i2c';
	}
	elseif (strpos($id_rom_new,'usb') !== false) {
	    $device='usb';
	}
	elseif (strpos($id_rom_new,'Raspberry_Pi') !== false) {
	    $device='rpi';
	}
	elseif (strpos($id_rom_new,'Banana_Pi') !== false) {
	    $device='banana';
	}
	elseif (strpos($id_rom_new,'host') !== false) {
	    $device='ip';
	}

	
	//DB    
	if ($type=='elec' || $type=='water' || $type=='gas' || $type=='watt') {
		$dbnew = new PDO("sqlite:db/$id_rom_new.sql");
		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER, current INTEGER, last INTEGER)");
		$dbnew->exec("CREATE INDEX time_index ON def(time)");
	}
	else {
		$dbnew = new PDO("sqlite:db/$id_rom_new.sql");
		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
		$dbnew->exec("CREATE INDEX time_index ON def(time)");
	}
		
	//SENOSRS ALL
	if ($type != "relay" ) {
		$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio, device, method, ip, adj, charts, sum, map_pos, map_num, position, map, status) VALUES ('$name','$id_rom_new', '$type', 'off', 'wait', '$gpio', '$device', '$method', '$ip', '0', 'on', '0', '{left:0,top:0}', '$map_num', '1', 'on', 'on')") or die ("cannot insert to DB" );
		//maps settings
		$inserted=$db->query("SELECT id FROM sensors WHERE rom='$id_rom_new'");
		$inserted_id=$inserted->fetchAll();
		$inserted_id=$inserted_id[0];
		$db->exec("INSERT OR IGNORE INTO maps (type, map_pos, map_num,map_on,element_id) VALUES ('sensors','{left:0,top:0}','$map_num','on','$inserted_id[id]')");
		
	}
	//RELAYS
	if ($type == "relay" ) {
		$db->exec("INSERT OR IGNORE INTO relays (name, rom, ip, type) VALUES ('wifi_relay_$name','$id_rom_new','$ip', '$type'  )") or die ("cannot insert relays to DB" );
	}

	// ADD HOST MONITORING
	if ($device == "wireless" || $device == "ip") {
		$name="host_".$id_rom_new;
		$rom="host_".$ip;
		//ADD TO HOSTS
		$db->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type, map_pos, map_num, map, position) VALUES ('$rom', '$ip', '$rom', 'ping', '{left:0,top:0}', '$map_num', 'on', '1')");
		//ADD TO SENSORS
		$db->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
		$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, device, alarm, tmp, ip, adj, charts, sum, map_pos, map_num, position, map, status) VALUES ('$name','$rom', 'host', 'ip','off', 'wait', '$ip', '0', 'on', '0', '{left:0,top:0}', '$map_num', '1', 'on', 'on')");
		//ADD TO MAPS
		$inserted=$db->query("SELECT id FROM sensors WHERE rom='$rom'");
		$inserted_id=$inserted->fetchAll();
		$inserted_id=$inserted_id[0];
		$db->exec("INSERT OR IGNORE INTO maps (element_id, type, map_pos, map_num, map_on) VALUES ('$inserted_id[id]','sensors','{left:0,top:0}','$map_num','on')");
		//ADD DB
		$dbnew = new PDO("sqlite:db/$rom.sql");
		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
		$dbnew->exec("CREATE INDEX time_index ON def(time)");
		//header("location: " . $_SERVER['REQUEST_URI']);
		//exit();
	}
	
	}

	//z bazy
	$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
	$usun2 = isset($_POST['usun2']) ? $_POST['usun2'] : '';
	if(!empty($rom) && ($usun2 == "usun3")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	
	//maps settings - first delete
	$to_delete=$db->query("SELECT id FROM sensors WHERE rom='$rom'");
	$to_delete_id=$to_delete->fetchAll();
	$to_delete_id=$to_delete_id[0];
	$db->exec("DELETE FROM maps WHERE element_id='$to_delete_id[id]' AND type='sensors'");
	$db->exec("DELETE FROM hosts WHERE rom='$rom'");
	$db->exec("DELETE FROM sensors WHERE rom='$rom'");
	if (file_exists("db/$rom.sql")) {
        unlink("db/$rom.sql");
	}
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
   } ?>	   
<?php	// SQLite3 - sekcja usuwanie nie wykrytych czujnikow
$usun_nw2 = isset($_POST['usun_nw2']) ? $_POST['usun_nw2'] : '';
if(!empty($usun_rom_nw) && ($usun_nw2 == "usun_nw3")) {   // 2x post aby potwierdzic multiple submit
	//z bazy
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM sensors WHERE rom='$usun_rom_nw'") or die ($db->lastErrorMsg());
	//plik rrd
	$rep_del_db = str_replace(" ", "_", $usun_rom_nw);
	$name_rep_del_db = "$rep_del_db.rrd";
	if (file_exists("tmp/mail/$rom.mail")) {
        unlink("tmp/mail/$rom.mail");
   }
   if (file_exists("tmp/mail/hour/$rom.mail")) {
        unlink("tmp/mail/hour/$rom.mail");
   }
   if (file_exists("db/$name_rep_del_db")) {
        unlink("db/$name_rep_del_db");
   }
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
	} ?>      
<?php	// SQLite - sekcja zmiany nazwy
	if (!empty($name_new) && !empty($name_id) && ($_POST['id_name2'] == "id_name3") ){
	$rep = str_replace(" ", "_", $name_new);
	$db = new PDO('sqlite:dbf/nettemp.db');
        $rows = $db->query("SELECT * FROM sensors WHERE name='$rep'") or header("Location: html/errors/db_error.php");
        $row = $rows->fetchAll();
        $c = count($row);
        if ( $c >= "1") { ?>
	<div class="panel panel-warning">
	    <div class="panel-heading">Name <?php echo $rep; ?> already exist in database.</div>
	    <div class="panel-body">
		<button type="button" class="btn btn-success" onclick="goBack()">Back</button>
	    </div>
	    
	</div>
	<script>
	function goBack() {
	    window.history.back();
	}
	</script>
	
	<?php 
	exit();
	} 
	else {
	$db->exec("UPDATE sensors SET name='$rep' WHERE id='$name_id'") or die ($db->lastErrorMsg());
	if (!empty($color)) {
	    $db->exec("UPDATE sensors SET color='$color' WHERE id='$name_id'") or die ($db->lastErrorMsg());
	}
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	} 
	?> 


<?php 	//read  digitemrc file and 1-wire bus
foreach (glob("tmp/.digitemp*") as $file_digi) {
	//$file_digi = "tmp/.digitemprc";
	$file_digi2 = file($file_digi);
	foreach($file_digi2 as $line_digi) {
		if(strstr($line_digi,"ROM")) { 
			$trim_line_digi=trim($line_digi);
			list($rom, $nr, $id1, $id2, $id3, $id4, $id5, $id6, $id7, $id8 ) = explode(" ", $trim_line_digi);
			$id0 = "$id1$id2$id3$id4$id5$id6$id7$id8";
			$digitemprc[] = $id0; 
			}
	}
}
	
	//$f_one_wire = "tmp/onewire";
	//$one_wire = file($f_one_wire);
	$db23 = new PDO('sqlite:dbf/nettemp.db');
	$sth23 = $db23->prepare("select * from newdev");
	$sth23->execute();
	$one_wire = $sth23->fetchAll();
	foreach($one_wire as $line_one_wire) {
		if (!empty($line_one_wire['list'])) {
		$line_one_wire2=trim($line_one_wire['list']);
		$digitemprc[] = $line_one_wire2; }
 	
	}

	
?>

<?php
$hour = isset($_POST['hour']) ? $_POST['hour'] : '';
$day = isset($_POST['day']) ? $_POST['day'] : '';
$week = isset($_POST['week']) ? $_POST['week'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$ss = isset($_POST['ss']) ? $_POST['ss'] : '';

$lcd = isset($_POST['lcd']) ? $_POST['lcd'] : '';
$lcdon = isset($_POST['lcdon']) ? $_POST['lcdon'] : '';
$lcdid = isset($_POST['lcdid']) ? $_POST['lcdid'] : '';

$ss1 = isset($_POST['ss1']) ? $_POST['ss1'] : '';
// SQLite - graph view update 
if ( $ss1 == "ss2"){

    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET hour='$hour' WHERE id='$ss'") ;
    $db->exec("UPDATE sensors SET day='$day' WHERE id='$ss'") ;
    $db->exec("UPDATE sensors SET week='$week' WHERE id='$ss'") ;
    $db->exec("UPDATE sensors SET month='$month' WHERE id='$ss'") ;
    $db->exec("UPDATE sensors SET year='$year' WHERE id='$ss'") ;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
} 

if ( $lcd == "lcd"){

    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET lcd='$lcdon' WHERE id='$lcdid'") ;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
} 


    include("modules/sensors/html/sensors_settings.php"); 
    include("modules/relays/html/relays_settings.php");
    include("modules/sensors/html/sensors_new.php"); 
    //include("modules/sensors/html/other.php"); 
?>

