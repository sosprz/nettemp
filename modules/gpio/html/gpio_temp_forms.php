<script type="text/JavaScript">
	    function showtemp(n) {
	    if (document.getElementById('state' + n).value == '') {
    	    document.getElementById('inputtemp' + n).style.display = 'block';
	    document.getElementById('inputhyst' + n).style.display = 'none';
	    
	    } else {
    		document.getElementById('inputtemp' + n).style.display = 'none';
		document.getElementById('inputhyst' + n).style.display = 'block';
		}
	    }
	    </script>
<?php

	    $sth34 = $db->prepare("SELECT tempnum FROM settings WHERE id='1'");
	    $sth34->execute();
	    $result34 = $sth34->fetchAll();
	    foreach ($result34 as $a34) { 
	    $tempnum=$a34['tempnum'];
	    }


// zmienne isset
foreach (range(1, $tempnum) as $ta) {
$temp_temp='temp_temp' . $ta;
$temp_sensor='temp_sensor' . $ta;
$temp_sensor_diff='temp_sensor_diff' . $ta;
$temp_onoff='temp_onoff' . $ta;
$temp_op='temp_op' . $ta;
$temp_hyst='temp_hyst' . $ta;

$$temp_sensor= isset($_POST["temp_sensor".$ta]) ? $_POST["temp_sensor".$ta] : '';
$$temp_sensor_diff= isset($_POST["temp_sensor_diff".$ta]) ? $_POST["temp_sensor_diff".$ta] : '';
$$temp_onoff= isset($_POST["temp_onoff".$ta]) ? $_POST["temp_onoff".$ta] : '';
$$temp_op= isset($_POST["temp_op".$ta]) ? $_POST["temp_op".$ta] : '';
$$temp_temp=isset($_POST["temp_temp".$ta]) ? $_POST["temp_temp".$ta] : '';
$$temp_hyst=isset($_POST["temp_hyst".$ta]) ? $_POST["temp_hyst".$ta] : '';
}

$tempset = isset($_POST['tempset']) ? $_POST['tempset'] : '';

if ($tempset == "on") {
foreach (range(1, $tempnum) as $up) {
    $temp_temp=${'temp_temp' . $up};
    $temp_onoff=${'temp_onoff' . $up};
    $temp_sensor=${'temp_sensor' . $up};
    $temp_sensor_diff=${'temp_sensor_diff' . $up};
    $temp_op=${'temp_op' . $up};
    $temp_hyst=${'temp_hyst' . $up};
    
    $db->exec("UPDATE gpio SET temp_op$up='$temp_op',temp_sensor$up='$temp_sensor',temp_sensor_diff$up='$temp_sensor_diff',temp_onoff$up='$temp_onoff',temp_temp$up='$temp_temp',temp_hyst$up='$temp_hyst' WHERE gpio='$gpio_post'") or die("exec 1");
    }
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
}
?>


<form class="form-horizontal" action="" method="post">
<fieldset>
<legend>Temperature</legend>

<!-- Form Name -->
<div class="table-responsive">
<table class="table">
<thead><tr><th>Sensor</th><th>State</th><th>Temp</th><th>Sensor</th><th>Hysteresis</th><th>on/off</th></tr></thead>
<div class="form-group">
<?php
    foreach (range(1, $tempnum) as $v) {
?>

<tr>
<td class="col-md-2">
<select name="<?php echo temp_sensor . $v; ?>" class="form-control input-sm">
<?php $sth = $db->prepare("SELECT * FROM sensors");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $select) { ?>
	<option <?php echo $a['temp_sensor'.$v] == $select['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']} {$select['tmp']}" ?></option>
<?php 
    } 
?>
</select>
</td>

<td class="col-md-1">
<select name="<?php echo temp_op . $v ?>" class="form-control input-sm">
    <option <?php echo $a['temp_op'.$v] == 'lt' ? 'selected="selected"' : ''; ?> value="lt">&lt;</option>   
    <option <?php echo $a['temp_op'.$v] == 'le' ? 'selected="selected"' : ''; ?> value="le">&lt;&#61;</option>     
    <option <?php echo $a['temp_op'.$v] == 'gt' ? 'selected="selected"' : ''; ?> value="gt">&gt;</option>   
    <option <?php echo $a['temp_op'.$v] == 'ge' ? 'selected="selected"' : ''; ?> value="ge">&gt;&#61;</option>   
</select>
</td>

<td class="col-md-1">
<input id="<?php echo inputtemp.$v; ?>" style="display: none"  type="text" name="<?php echo temp_temp . $v ?>" value="<?php echo $a['temp_temp'.$v]; ?>" class="form-control input-sm" >
</td>

<td class="col-md-2">
<select name="<?php echo temp_sensor_diff . $v; ?>" id="<?php echo state . $v; ?>" onclick='showtemp(<?php echo $v; ?>)' class="form-control input-sm">
<?php $sth = $db->prepare("SELECT * FROM sensors");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $select) { ?>
	<option <?php echo $a['temp_sensor_diff'.$v] == $select['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']}  {$select['tmp']} {$a['temp_hyst'.$v]}" ?></option>
<?php } ?>
	<option <?php echo $a['temp_sensor_diff'.$v] == '' ? 'selected="selected"' : ''; ?> value="">custom <?php echo $a['temp_temp'.$v]; ?></option>
</select>
</td>

<td class="col-md-1">
<input id="<?php echo inputhyst.$v; ?>" style="display: none" type="text" name="<?php echo temp_hyst . $v ?>" value="<?php echo $a['temp_hyst'.$v]; ?>" class="form-control input-sm" >
</td>

<td class="col-md-1">
<select name="<?php echo temp_onoff . $v ?>" class="form-control input-sm">
    <option <?php echo $a['temp_onoff'.$v] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
    <option <?php echo $a['temp_onoff'.$v] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
</select>
</td>
</tr>


<?php
    }
?>
</div>
</table>
</div>
<div class="form-group">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempset" value="on" />
     <div class="col-md-4">
	<button type="submit" class="btn btn-xs btn-primary">SAVE</button>
    </div>
</div>
</fieldset>
</form>
</table>


