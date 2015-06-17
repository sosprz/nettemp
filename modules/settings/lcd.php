<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">LCD </h3>
</div>
<div class="panel-body">
<?php
    $lcd = isset($_POST['lcd']) ? $_POST['lcd'] : '';
    $lcdon = isset($_POST['lcdon']) ? $_POST['lcdon'] : '';
    
    if (($lcd == "lcd") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET lcd='$lcdon' WHERE id='1'") or die ($db->lastErrorMsg());
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
    <form action="" method="post">
    
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="lcdon" value="on" <?php echo $lcd == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="lcd" value="lcd" />
    </form>
LCD 1602 HD44780 PCF8574 I2C
</div>
</div>
