<?php
    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $gpio_onoff1 = isset($_POST['gpio_onoff1']) ? $_POST['gpio_onoff1'] : '';
    if (($gpio_onoff1 == "gpio_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET gpio='$gpio_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
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
<h3 class="panel-title">GPIO</h3>
</div>
<div class="panel-body">
    <table>
    <form action="settings" method="post">
    <td>Gpio on/off</td>
    <td><input type="checkbox" name="gpio_onoff" value="on" <?php echo $gpio == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio_onoff1" value="gpio_onoff2" />
    </form>
    </table>
<?php if ($gpio == "on" ) { 
    include('gpio_options.php');
 } 
?>
</div>
</div>
