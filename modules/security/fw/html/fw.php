<?php
    $fw_onoff = isset($_POST['fw_onoff']) ? $_POST['fw_onoff'] : '';
    $onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
    if (($onoff == "onoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET fw='$fw_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    if ($fw_onoff != "on") {
    shell_exec("/bin/bash modules/security/fw/fw off");
    }
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
$fw=$a["fw"];

}
?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Firewall</h3>
</div>
<div class="panel-body">

<form action="" method="post">
<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="fw_onoff" value="on" <?php echo $fw == 'on' ? 'checked="checked"' : ''; ?> />
<input type="hidden" name="onoff" value="onoff" />
</form>
</div>
</div>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$fw=$a["fw"];
}
?>
<?php
    if ($fw == "on" ) { ?>
    <?php include('fw_settings.php'); ?>
    <?php include('fw_status.php'); ?>
<?php	 } ?>


