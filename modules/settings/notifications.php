<?php


    $ms_onoff = isset($_POST['ms_onoff']) ? $_POST['ms_onoff'] : '';
    $ms_onoff1 = isset($_POST['ms_onoff1']) ? $_POST['ms_onoff1'] : '';
    if (($ms_onoff1 == "ms_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$ms_onoff' WHERE option='mail_onoff'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Notifications</h3></div>
<div class="panel-body">
<div class="grid">
	
<?php include('modules/mail/html/mail_settings.php'); ?>
<?php include('modules/pushover/html/pushover_settings.php'); ?>

</div>
</div>
</div>




