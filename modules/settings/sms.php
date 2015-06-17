<?php
    $ss_onoff = isset($_POST['ss_onoff']) ? $_POST['ss_onoff'] : '';
    $ss_onoff1 = isset($_POST['ss_onoff1']) ? $_POST['ss_onoff1'] : '';
    if (($ss_onoff1 == "ss_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET sms='$ss_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$rrd=$a["rrd"];
$hc=$a["highcharts"];
$ss=$a["sms"];
$ms=$a["mail"];
$gpio=$a["gpio"];
$lcd=$a["lcd"];


}
?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">SMS</h3>
</div>
<div class="panel-body">
    <form action="" method="post">
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="ss_onoff" value="on" <?php echo $ss == 'on' ? 'checked="checked"' : ''; ?> />
    <input type="hidden" name="ss_onoff1" value="ss_onoff2" />
    </form>
<?php include('modules/sms/html/sms.php'); ?>
</div>
</div>

