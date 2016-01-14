<?php
    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $gpio_onoff1 = isset($_POST['gpio_onoff1']) ? $_POST['gpio_onoff1'] : '';
    if (($gpio_onoff1 == "gpio_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET gpio='$gpio_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    echo $gpio_onoff;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $MCP23017_onoff = isset($_POST['MCP23017_onoff']) ? $_POST['MCP23017_onoff'] : '';
    $MCP23017_onoff1 = isset($_POST['MCP23017_onoff1']) ? $_POST['MCP23017_onoff1'] : '';
    if (($MCP23017_onoff1 == "MCP23017_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET MCP23017='$MCP23017_onoff' WHERE id='1'");
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
$MCP23017=$a["MCP23017"];


}
?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO RPI</h3>
</div>
<div class="panel-body"> 
<form action="" method="post">
  <input type="hidden" name="gpio_onoff1" value="gpio_onoff2"  />
  <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="gpio_onoff" value="on"  <?php echo $gpio == 'on' ? 'checked="checked"' : ''; ?> >
</form>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO MCP23017</h3>
</div>
<div class="panel-body">
<form action="" method="post">
  <input type="hidden" name="MCP23017_onoff1" value="MCP23017_onoff2"  />
  <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="MCP23017_onoff" value="on"  <?php echo $MCP23017 == 'on' ? 'checked="checked"' : ''; ?> >
</form>
</div>
</div>

