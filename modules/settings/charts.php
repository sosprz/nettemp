<?php
    $hc_onoff = isset($_POST['hc_onoff']) ? $_POST['hc_onoff'] : '';
    $hc_onoff1 = isset($_POST['hc_onoff1']) ? $_POST['hc_onoff1'] : '';
    if (($hc_onoff1 == "hc_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET highcharts='$hc_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $hcs_onoff = isset($_POST['hcs_onoff']) ? $_POST['hcs_onoff'] : '';
    $hcs_onoff1 = isset($_POST['hcs_onoff1']) ? $_POST['hcs_onoff1'] : '';
    if (($hcs_onoff1 == "hcs_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET charts_system='$hcs_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $hcg_onoff = isset($_POST['hcg_onoff']) ? $_POST['hcg_onoff'] : '';
    $hcg_onoff1 = isset($_POST['hcg_onoff1']) ? $_POST['hcg_onoff1'] : '';
    if (($hcg_onoff1 == "hcg_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET charts_gpio='$hcg_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $hch_onoff = isset($_POST['hch_onoff']) ? $_POST['hch_onoff'] : '';
    $hch_onoff1 = isset($_POST['hch_onoff1']) ? $_POST['hch_onoff1'] : '';
    if (($hch_onoff1 == "hch_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET charts_hosts='$hch_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
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
$hcs=$a["charts_system"];
$hcg=$a["charts_gpio"];
$hch=$a["charts_hosts"];
$hc=$a["highcharts"];
$hch=$a["charts_min"];

}
?>

<div class="panel panel-default">
  <div class="panel-heading">Charts settings</div>
  <div class="panel-body">
<!--
    <table>
    <tr>
    <td>Highcharts </td>
	<td>
		<form action="" method="post">
	    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="hc_onoff" value="on" <?php echo $hc == 'on' ? 'checked="checked"' : ''; ?>  />
	    <input type="hidden" name="hc_onoff1" value="hc_onoff2" />
	    </form>
	</td>
    </tr>
<?php 
    if ($hc == 'on') {
?> 
    <tr>
    <td>System</td>
	<td>
		<form action="" method="post">
	    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="hcs_onoff" value="on" <?php echo $hcs == 'on' ? 'checked="checked"' : ''; ?>  />
	    <input type="hidden" name="hcs_onoff1" value="hcs_onoff2" />
	    </form>
	</td>
    </tr>
    
    <tr>
    <td>GPIO </td>
	<td>
		<form action="" method="post">
	    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="hcg_onoff" value="on" <?php echo $hcg == 'on' ? 'checked="checked"' : ''; ?>  />
	    <input type="hidden" name="hcg_onoff1" value="hcg_onoff2" />
	    </form>
	</td>
    </tr>
    
    <tr>
    <td>Host Monitoring</td>
	<td>
		<form action="" method="post">
	    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="hch_onoff" value="on" <?php echo $hch == 'on' ? 'checked="checked"' : ''; ?>  />
	    <input type="hidden" name="hch_onoff1" value="hch_onoff2" />
	    </form>
	</td>
    </tr>
<?php 
    }
?> 

    </table>
-->


<?php
    $chmin = isset($_POST['chmin']) ? $_POST['chmin'] : '';
    $set_chmin = isset($_POST['set_chmin']) ? $_POST['set_chmin'] : '';
    if  ($set_chmin == "set_chmin") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET charts_min='$chmin' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $chtheme = isset($_POST['chtheme']) ? $_POST['chtheme'] : '';
    $set_chtheme = isset($_POST['set_chtheme']) ? $_POST['set_chtheme'] : '';
    if  ($set_chtheme == "set_chtheme") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET charts_theme='$chtheme' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Sensors base update interval</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chmin" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("1","2","5","10", "15");
     foreach ($ar as $num) { ?>
        <option <?php echo $a['charts_min'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?> min</option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chmin" value="set_chmin" />
</form>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Theme</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chtheme" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("white","black","sand","grid");
     foreach ($ar as $num) { ?>
        <option <?php echo $a['charts_theme'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chtheme" value="set_chtheme" />
</form>




<?php
}
?>




</div></div>


