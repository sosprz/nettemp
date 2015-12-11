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

<?php // SQLite3 - sekcja dodawania do bazy && tworzenie baz rrd
	if(!empty($id_rom_new)) {
	$name=substr(rand(), 0, 4);
	$gpio='';
	$type='';
	$device='';
	$method='';
	$ip='';
	    
	    
	//type

	if (strpos($id_rom_new,'temp') !== false) {
	    $type='temp';
	}
	elseif (strpos($id_rom_new,'humid') !== false) {
	    $type='humid';
	}
	elseif (strpos($id_rom_new,'elec') !== false) {
	    $type='elec';
	}
	elseif (strpos($id_rom_new,'water') !== false) {
	    $type='water';
	}
	elseif (strpos($id_rom_new,'gas') !== false) {
	    $type='gas';
	}
	elseif (strpos($id_rom_new,'relay') !== false) {
	    $type='relay';
	}
	elseif (strpos($id_rom_new,'lux') !== false) {
	    $type='lux';
	}
	elseif (strpos($id_rom_new,'press') !== false) {
	    $type='press';
	}
	elseif (strpos($id_rom_new,'humid') !== false) {
	    $type='humid';
	}
	elseif (strpos($id_rom_new,'volt') !== false) {
	    $type='volt';
	}
	elseif (strpos($id_rom_new,'amps') !== false) {
	    $type='amps';
	}
	elseif (strpos($id_rom_new,'watt') !== false) {
	    $type='watt';
	}
	else {
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
        if (strpos($id_rom_new,'wireless') !== false) {
    	    $device='wireless';
	}
	if (strpos($id_rom_new,'remote_') !== false) {
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

	//DB    
	    if ($type != "relay" ) {
		$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio, device, method, ip, adj, charts, sum) VALUES ('$name','$id_rom_new', '$type', 'off', 'wait', '$gpio', '$device', '$method', '$ip', '0', 'on', '0')") or die ("cannot insert to DB" );
	    }
	    if ($type == "relay" ) {
		//relays
		$db->exec("INSERT OR IGNORE INTO relays (name, rom, ip, type) VALUES ('wifi_relay_$name','$id_rom_new','$ip', '$type'  )") or die ("cannot insert relays to DB" );
	    }

    	    if ($device == "wireless"  ) {
		//host for monitoring
		$name='host_wifi_' . $type . '_' . $name;
		$dbhost = new PDO("sqlite:dbf/hosts.db");	
		$dbhost->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type) VALUES ('$name', '$ip', 'host_$id_rom_new', 'ping')") or die ("cannot insert host to DB" );	
		$dbnew = new PDO("sqlite:db/host_$id_rom_new.sql");
    		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
	    }
	    if ($type=='elec' || $type=='water' || $type=='gas' || $type=='watt') {
		$dbnew = new PDO("sqlite:db/$id_rom_new.sql");
		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER, current INTEEGER)");
	    }
	    else {
		$dbnew = new PDO("sqlite:db/$id_rom_new.sql");
		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
	    }
	    $dbnew==NULL;

	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	 
	} ?>
<?php // SQLite3 - sekcja usuwania czujników
	//z bazy
	$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
	$usun2 = isset($_POST['usun2']) ? $_POST['usun2'] : '';
	if(!empty($rom) && ($usun2 == "usun3")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM sensors WHERE rom='$rom'") or die ($db->lastErrorMsg()); 
	unlink("db/$rom.sql");
	unlink("tmp/mail/$rom.mail");
	unlink("tmp/mail/hour/$rom.mail");
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
	unlink("tmp/mail/$rom.mail");
	unlink("tmp/mail/hour/$rom.mail");
	unlink("db/$name_rep_del_db");
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
		<button type="button" class="btn btn-primary" onclick="goBack()">Back</button>
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



?>

<?php 
    include("modules/sensors/html/sensors_settings.php"); 
    include("modules/relays/html/relays_settings.php");
    include("modules/sensors/html/sensors_new.php"); 
    include("modules/sensors/html/other.php"); 
?>

