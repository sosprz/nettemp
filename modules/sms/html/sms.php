<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$sms=$a["sms"];
}
?>

<?php
if ($sms == "on" ) {
?> 
	<?php include('sms_scan.php'); ?>
	<hr>
	<?php include('sms_settings.php'); ?>
	<hr>
	<?php include('sms_getallsms.php'); ?>

<?php } 
    //else { echo "OFF"; }

?>
