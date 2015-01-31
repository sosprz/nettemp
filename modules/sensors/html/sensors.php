<?php
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 

$usun_czujniki = isset($_POST['usun_czujniki']) ? $_POST['usun_czujniki'] : '';
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
	system("modules/sensors/temp_add_sensor $id_rom_new ");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	 
	} ?>
<?php // SQLite3 - sekcja usuwania czujników
	//z bazy
	$usun2 = isset($_POST['usun2']) ? $_POST['usun2'] : '';
	if(!empty($usun_czujniki) && ($usun2 == "usun3")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM sensors WHERE rom='$usun_czujniki'") or die ($db->lastErrorMsg()); 
	//plik rrd
	$rep_del_db = str_replace(" ", "_", $usun_czujniki);
	$name_rep_del_db = "$rep_del_db.rrd";
	//echo $name_rep_del_db;    
	unlink("db/$name_rep_del_db");
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
	//echo $name_rep_del_db;    
	unlink("db/$name_rep_del_db");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
	} ?>      
<?php	// SQLite - sekcja zmiany nazwy
	if (!empty($name_new) && !empty($name_id) && ($_POST['id_name2'] == "id_name3") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET name='$name_new' WHERE id='$name_id'") or die ($db->lastErrorMsg());
	if (!empty($color)) {
	$db->exec("UPDATE sensors SET color='$color' WHERE id='$name_id'") or die ($db->lastErrorMsg());
	}
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
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
	
	$f_one_wire = "tmp/onewire";
	$one_wire = file($f_one_wire);
	foreach($one_wire as $line_one_wire) {
		if (!empty($line_one_wire)) {
		$line_one_wire2=trim($line_one_wire);
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

<?php include("modules/sensors/html/sensors_settings.php"); ?>
<?php include("modules/sensors/html/sensors_new.php"); ?>
<?php include("modules/sensors/html/sensors_device.php"); ?>
	

<?php }
else { 
  	  header("Location: denied");
    }; 
