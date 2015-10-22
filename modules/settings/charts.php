<?php
    $rrd_onoff = isset($_POST['rrd_onoff']) ? $_POST['rrd_onoff'] : '';
    $rrd_onoff1 = isset($_POST['rrd_onoff1']) ? $_POST['rrd_onoff1'] : '';
    if (($rrd_onoff1 == "rrd_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET rrd='$rrd_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $lcd = isset($_POST['lcd']) ? $_POST['lcd'] : '';
    $lcdon = isset($_POST['lcdon']) ? $_POST['lcdon'] : '';
    
    if (($lcd == "lcd") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET lcd='$lcdon' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $gpio_onoff1 = isset($_POST['gpio_onoff1']) ? $_POST['gpio_onoff1'] : '';
    if (($gpio_onoff1 == "gpio_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET gpio='$gpio_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    $hc_onoff = isset($_POST['hc_onoff']) ? $_POST['hc_onoff'] : '';
    $hc_onoff1 = isset($_POST['hc_onoff1']) ? $_POST['hc_onoff1'] : '';
    if (($hc_onoff1 == "hc_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET highcharts='$hc_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $ss_onoff = isset($_POST['ss_onoff']) ? $_POST['ss_onoff'] : '';
    $ss_onoff1 = isset($_POST['ss_onoff1']) ? $_POST['ss_onoff1'] : '';
    if (($ss_onoff1 == "ss_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET sms='$ss_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $ms_onoff = isset($_POST['ms_onoff']) ? $_POST['ms_onoff'] : '';
    $ms_onoff1 = isset($_POST['ms_onoff1']) ? $_POST['ms_onoff1'] : '';
    if (($ms_onoff1 == "ms_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET mail='$ms_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$rrd=$a["rrd"];
$hc=$a["highcharts"];


}
?>

<div class="panel panel-default">
  <div class="panel-heading">Charts settings</div>
  <div class="panel-body">
    <table>
<!--    <tr>	
    <form action="" method="post">
    <td>RRD</td>
    <td><input type="checkbox" name="rrd_onoff" value="on" <?php echo $rrd == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="rrd_onoff1" value="rrd_onoff2" />
    </form>
    </tr> --> 
    <tr>
	<td>


    <td>Highcharts </td>
	<td>
	<form action="" method="post">
	<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="hc_onoff" value="on" <?php echo $hc == 'on' ? 'checked="checked"' : ''; ?>  />
	<input type="hidden" name="hc_onoff1" value="hc_onoff2" />
	</form>
	</td>
    </tr> 
    </table>
</div></div>


