<?php
session_start();
	   include('include/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
		
		
		
$tmp_id = $_POST["tmp_id"]; 				//sql
$tmp_min_new = $_POST["tmp_min_new"];  //sql
$tmp_max_new = $_POST["tmp_max_new"];  //sql
$add_alarm = $_POST["add_alarm"];  //sql
$del_alarm = $_POST["del_alarm"];  //sql
?>
<?php	// SQLite - dodawania alarmu
	if (!empty($add_alarm) && ($_POST['add_alarm1'] == "add_alarm2")){
	//$db = new SQLite3('dbf/nettemp.db');
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET alarm='on' WHERE id='$add_alarm'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?> 
<?php	// SQLite - usuwanie alarmu
	if (!empty($del_alarm) && ($_POST['del_alarm1'] == "del_alarm2")){
	//$db = new SQLite3('dbf/nettemp.db');
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET alarm='off' WHERE id='$del_alarm'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?> 
<?php	// SQLite - zmiana alarmow
	if (!empty($tmp_id) && ($_POST['ok'] == "ok")){
	//$db = new SQLite3('dbf/nettemp.db');
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET tmp_min='$tmp_min_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE sensors SET tmp_max='$tmp_max_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?> 

<div id="left">
	 <?php include("modules/alarms/html/alarms_settings.php"); ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>