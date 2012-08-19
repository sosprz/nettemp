<?php
include('conf.php');
session_start();
	   include('include/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 

$usun_czujniki = $_POST["usun_czujniki"]; //sql
$name_new = $_POST["name_new"]; //sql
$name_id = $_POST["name_id"]; //sql
$usun_rom_nw = $_POST["usun_nw"]; //new 

$id_rom_new2 = $_POST["id_rom_new"]; 
$id_rom_new=trim($id_rom_new2);
$add_graf = $_POST["add_graf"];
$del_graf = $_POST["del_graf"];
$name_new2 = $_POST["name_new"];
$name_new=trim($name_new2);



?>
<?php include("include/delete_graph.php"); ?>




<?php //sekcja generowania grafu
if ($_POST['add_graf1'] == "add_graf2") {
	// kasuje zawartosc przed wygenerowaniem nowego
   $mask = "img/instant/*.png";
   array_map( "unlink", glob( $mask ) );
	//$db = new SQLite3('dbf/nettemp.db');
	//$r = $db->query("select * from sensors WHERE rom='$add_graf'");
	//while ($a = $r->fetchArray()) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db1->prepare("select * from sensors WHERE rom='$add_graf'");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) { 
	$name=$a["name"];
$rep_add_graf = str_replace(" ", "_", $add_graf);
system ("rrdtool graph img/instant/$rep_add_graf\_hour.png \
--imgformat PNG \
--title=\"$name\" \
--width 894 --height 140 \
--vertical-label=\"Degrees C\" \
-s -1hour \
DEF:temp=db/$rep_add_graf\.rrd:temp:AVERAGE \
AREA:temp#0066FF \
LINE2:temp#0000ff:\"$name\" \
\"COMMENT:\\n\" \
GPRINT:temp:LAST:\"cur %2.2lf C \"  \
\"COMMENT:\\n\" \
GPRINT:temp:MIN:\"min %2.2lf C \" \
\"COMMENT:\\n\" \
GPRINT:temp:MAX:\"max %2.2lf C  \" \
\"COMMENT:\\n\" \
GPRINT:temp:AVERAGE:\"ave %2.2lf C \" ");
} //while
system ("chmod 777 img/instant/$rep_add_graf\_hour.png");
      header("location: " . $_SERVER['REQUEST_URI']);
  	   exit();
} 
?>
<?php // SQLite3 - sekcja dodawania do bazy && tworzenie baz rrd
	if(!empty($id_rom_new)) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO sensors (name, rom, tmp, tmp_min, tmp_max, alarm) 
	VALUES ('new_sensor', '$id_rom_new', '', '', '', 'off')") or die ($db->lastErrorMsg());
	//tworzenie rrd
	$rep_add_db = str_replace(" ", "_", $id_rom_new);
	$cmd="cd db && /usr/bin/rrdtool create $rep_add_db.rrd -s 600 DS:temp:GAUGE:700:-50:50 RRA:AVERAGE:0.5:1:48384 RRA:MAX:0.5:1:48384 
	RRA:MIN:0.5:1:48384 RRA:LAST:0.5:1:48384";
	system($cmd); 	
	system("cd db && chmod 777 $rep_add_db.rrd ");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	 
	} ?>
<?php // SQLite3 - sekcja usuwania czujników
	//z bazy
	if(!empty($usun_czujniki) && ($_POST['usun2'] == "usun3")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	//$db->busyTimeout(100);
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
if(!empty($usun_rom_nw) && ($_POST['usun_nw2'] == "usun_nw3")) {   // 2x post aby potwierdzic multiple submit
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
	if (!empty($name_new) && !empty($name_id) && ($_POST['id_name2'] == "id_name3")){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET name='$name_new' WHERE id='$name_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?> 

<?php	// skanowanie generowanie nowego .digitemprc
	if ($_POST['scan'] == "Scan"){
	 exec("sh $global_dir/scripts/scan");	
	 system("chmod 777 $global_dir/scripts/tmp/.digitemprc");
	 header("location: " . $_SERVER['REQUEST_URI']);
	 exit();
	 } 
	 ?>	 
	 
	 
<?php 	//wczytanie digitemrc
	$file_digi = "$global_dir/scripts/tmp/.digitemprc";
	$file_digi2 = file($file_digi);
	foreach($file_digi2 as $line_digi) {
	if(strstr($line_digi,"ROM")) { 
	$trim_line_digi=trim($line_digi);
	list($rom, $nr, $id1, $id2, $id3, $id4, $id5, $id6, $id7, $id8 ) = explode(" ", $trim_line_digi);
	$id0 = "$id1 $id2 $id3 $id4 $id5 $id6 $id7 $id8";
	$digitemprc[] = $id0; 
			}
	}
?>
<?php include("include/sensors_settings.php"); ?>
<?php include("include/sensors_not_detected.php"); ?>
<?php include("include/sensors_new.php"); ?>
<?php include("include/sensors_preview.php"); ?>

	

<?php }
else { 
  	  header("Location: diened");
    }; 
