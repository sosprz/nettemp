<?php
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
		
		?>
<div id="left">

<?php
    $ss = $_POST["ss"];
    if (($_POST['ss1'] == "ss2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET sms='$ss'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();

    }
?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$sms=$a["sms"];
}
?>
<span class="belka">&nbsp SMS<span class="okno">

<?php
if ($sms == "on" ) {
?> 
	<?php include('sms_scan.php'); ?>
	<hr>
	<?php include("sms_settings.php"); ?>
	<hr>
	<?php include('sms_getallsms.php'); ?>

<?php } 
    else { echo "OFF"; }

?>
</span></span>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
