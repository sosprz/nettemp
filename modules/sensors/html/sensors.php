<?php 
$device_group=isset($_GET['device_group']) ? $_GET['device_group'] : '';
$device_type=isset($_GET['device_type']) ? $_GET['device_type'] : '';

?>
<p>
<?php
$query = $db->query("SELECT ch_group FROM sensors ");
$result_ch_g = $query->fetchAll();
	foreach($result_ch_g as $uniq) {
		if(!empty($uniq['ch_group'])&&$uniq['ch_group']!='none'&&$uniq['ch_group']!='all') {
			$unique[]=$uniq['ch_group'];
		}
	}
	$rowu = array_unique($unique);
	foreach ($rowu as $ch_g) { 	
		?>
		<a href="index.php?id=<?php echo $id ?>&type=devices&device_group=<?php echo $ch_g?>" ><button class="btn btn-xs btn-default <?php if($device_group==$ch_g) {echo "active";} ?>"><?php echo $ch_g?></button></a>
		<?php 
	}
?>
</p>
<p>
<?php
$query = $db->query("SELECT type FROM sensors ");
$result_g = $query->fetchAll();
	foreach($result_g as $uniqg) {
		if(!empty($uniqg['type'])&&$uniqg['type']!='none'&&$uniqg['type']!='all') {
			$uniqueg[]=$uniqg['type'];
		}
	}
	$rowu = array_unique($uniqueg);
	foreach ($rowu as $t_g) { 	
		?>
		<a href="index.php?id=<?php echo $id ?>&type=devices&device_group=<?php echo $device_group?>&device_type=<?php echo $t_g?>" ><button class="btn btn-xs btn-default <?php if($device_type==$t_g) {echo "active";} ?>"><?php echo $t_g?></button></a>
		<?php 
	}
?>
</p>


<?php
$name_new = isset($_POST['name_new']) ? $_POST['name_new'] : '';

$name_id = isset($_POST['name_id']) ? $_POST['name_id'] : '';
$usun_rom_nw = isset($_POST['usun_nw']) ? $_POST['usun_nw'] : '';


$name_new2 = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$name_new=trim($name_new2);

// OK 
$new_rom = isset($_POST['new_rom']) ? $_POST['new_rom'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';



//ADD from NEWDEV 
if(!empty($new_rom)) {
	$name=substr(rand(), 0, 4);
	$map_num=substr(rand(), 0, 4);
	$map_num2=substr(rand(), 0, 4);
	
//DB    
if ($type=='elec' || $type=='water' || $type=='gas' || $type=='watt') {
	$dbnew = new PDO("sqlite:db/$new_rom.sql");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER, current INTEGER, last INTEGER)");
	$dbnew->exec("CREATE INDEX time_index ON def(time)");
}
else {
	$dbnew = new PDO("sqlite:db/$new_rom.sql");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
	$dbnew->exec("CREATE INDEX time_index ON def(time)");
}
//check if file exist before insert to db 
if(file_exists("db/".$new_rom.".sql")&&filesize("db/".$new_rom.".sql")!=0){
	//SENOSRS ALL
	$db->exec("INSERT INTO sensors (rom,type,device,ip,gpio,i2c,usb,name) SELECT rom,type,device,ip,gpio,i2c,usb,name FROM newdev WHERE rom='$new_rom'");
	$db->exec("UPDATE sensors SET alarm='off', tmp='wait', adj='0', charts='on', sum='0', position='1', status='on', ch_group='sensors',position_group='1' WHERE rom='$new_rom'");

	//maps settings
	$inserted=$db->query("SELECT id FROM sensors WHERE rom='$new_rom'");
	$inserted_id=$inserted->fetchAll();
	$inserted_id=$inserted_id[0];
	$db->exec("INSERT OR IGNORE INTO maps (type, map_pos, map_num,map_on,element_id) VALUES ('sensors','{left:0,top:0}','$map_num','on','$inserted_id[id]')");
}
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}






//DEL z bazy
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
} 
// SQLite3 - sekcja usuwanie nie wykrytych czujnikow
$usun_nw2 = isset($_POST['usun_nw2']) ? $_POST['usun_nw2'] : '';
if(!empty($usun_rom_nw) && ($usun_nw2 == "usun_nw3")) {   // 2x post aby potwierdzic multiple submit
	//z bazy
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM sensors WHERE rom='$usun_rom_nw'") or die ($db->lastErrorMsg());
	//plik rrd
	$rep_del_db = str_replace(" ", "_", $usun_rom_nw);
	$name_rep_del_db = "$rep_del_db.rrd";
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

