<?php
    $ms_onoff = isset($_POST['ms_onoff']) ? $_POST['ms_onoff'] : '';
    $ms_onoff1 = isset($_POST['ms_onoff1']) ? $_POST['ms_onoff1'] : '';
    if (($ms_onoff1 == "ms_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$ms_onoff' WHERE option='mail_onoff'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select value from nt_settings WHERE option='mail_onoff'");

$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
	$ms=$a["value"];
}

?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Mail</h3>
</div>
<div class="panel-body">
<p>
<form action="" method="post">
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="ms_onoff" value="on" <?php echo $ms == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="ms_onoff1" value="ms_onoff2" />
</form>
</p>
<?php include('modules/mail/html/mail.php'); ?>
</div>
</div>
