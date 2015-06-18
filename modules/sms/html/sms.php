<hr>
	<?php include('sms_scan.php'); ?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT default_dev FROM sms_settings WHERE default_dev='on' ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$dev=$a['default_dev'];
}

if ( $dev == "on") {
    include('sms_settings.php'); 
    include('sms_getallsms.php');
} ?>
