<script type="text/JavaScript">
function ch_source() {
		if (document.getElementById("source").value == 'temp') {
		    document.getElementById("value").style.display = 'block';
		    document.getElementById("sensor2").style.display = 'none';
		    document.getElementById("hyst").style.display = 'none';
		    document.getElementById("value").required = true;
		    document.getElementById("hyst").required = false;
		}
		if (document.getElementById("source").value == 'sensor2') {
		    document.getElementById("value").style.display = 'none';
		    document.getElementById("sensor2").style.display = 'block';
		    document.getElementById("hyst").style.display = 'none';
		    document.getElementById("value").required = false;
		    document.getElementById("hyst").required = false;
		}
		if (document.getElementById("source").value == 'temphyst') {
		    document.getElementById("value").style.display = 'block';
		    document.getElementById("sensor2").style.display = 'none';
		    document.getElementById("hyst").style.display = 'block';
		    document.getElementById("value").required = true;
		    document.getElementById("hyst").required = true;
		}
		if (document.getElementById("source").value == 'sensor2hyst') {
		    document.getElementById("value").style.display = 'none';
		    document.getElementById("sensor2").style.display = 'block';
		    document.getElementById("hyst").style.display = 'block';
		    document.getElementById("sensor2").required = true;
		    document.getElementById("hyst").required = true;
		}
}
	    </script>

<?php
	//update
	$sensor1=isset($_POST['sensor1']) ? $_POST['sensor1'] : '';
	$sensor2=isset($_POST['sensor2']) ? $_POST['sensor2'] : '';
	$source=isset($_POST['source']) ? $_POST['source'] : '';
	$value=isset($_POST['value']) ? $_POST['value'] : '';
	$hyst=isset($_POST['hyst']) ? $_POST['hyst'] : '';
	$onoff=isset($_POST['onoff']) ? $_POST['onoff'] : '';
	$op=isset($_POST['op']) ? $_POST['op'] : '';
	$day_plan=isset($_POST['day_plan']) ? $_POST['day_plan'] : 'allways';
	
	$fadd=isset($_POST['fadd']) ? $_POST['fadd'] : '';
	$fdel=isset($_POST['fdel']) ? $_POST['fdel'] : '';
	$fid=isset($_POST['fid']) ? $_POST['fid'] : '';
	$down=isset($_POST['down']) ? $_POST['down'] : '';
	$up=isset($_POST['up']) ? $_POST['up'] : '';
	
	 if ($source == 'temp') {
	    $sensor2=NULL;
	    $hyst=NULL;
    } elseif ($source == 'sensor2') {
	    $value=NULL;
	    $hyst=NULL;
    } elseif ($source == 'temphyst') {
	    $sensor2=NULL;
	    $onoff='on';
    } elseif ($source == 'sensor2hyst') {
	    $value=NULL;
	    $onoff='on';
    }
	
	if ($fadd == "add"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("INSERT OR IGNORE INTO g_func (sensor, sensor2, onoff, value, op, hyst, source, gpio, w_profile) VALUES ('$sensor1','$sensor2', '$onoff', '$value', '$op', '$hyst', '$source', '$gpio', '$day_plan')") or die ($db->lastErrorMsg());
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	if ($fdel == "del"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("DELETE FROM g_func WHERE id='$fid'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	if ($up == "up"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE g_func SET position=position-1 WHERE id='$fid'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	if ($down == "down"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE g_func SET position=position+1 WHERE id='$fid'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}

	//loops
	$sth = $db->prepare("SELECT * FROM sensors");
   $sth->execute();
   $result = $sth->fetchAll(); 

	$sth = $db->prepare("SELECT * FROM day_plan WHERE gpio='$gpio'");
	$sth->execute();
	$dp = $sth->fetchAll();
	
	$sth = $db->prepare("SELECT * FROM g_func WHERE gpio='$gpio' ORDER BY position ASC");
	$sth->execute();
	$func = $sth->fetchAll();
	?>
<div class="panel panel-default">
<div class="panel-heading">Value functions</div>
<table class="table table-condensed table-hover table-striped">
<thead><tr><th>Pos</th><th>Sensor1</th><th>State</th><th>Source</th><th>Value</th><th>Hysteresis</th><th>Action</th><th>Week Profile</th><th></th></tr></thead>
<div class="form-group">
<tr>

<form class="form-horizontal" action="" method="post">
<td class="col-md-1">
</td>
<td class="col-md-1">
<select name="sensor1" class="form-control input-sm">
<?php 
    foreach ($result as $select) { ?>
	<option value="<?php echo $select['id']; ?>"><?php echo $select['name']." ".$select['tmp'] ?></option>
<?php 
    } 
?>
</select>
</td>

<td class="col-md-1">
<select name="op" class="form-control input-sm">
    <option  value="lt">&lt;</option>   
    <option  value="le">&lt;&#61;</option>     
    <option  value="gt">&gt;</option>   
    <option  value="ge">&gt;&#61;</option>   
</select>
</td>

<td class="col-md-1" onclick='ch_source()'>
    <select name="source" class="form-control input-sm" id="source">
	<option value="temphyst">Temp+Histeresis</option>
	<option value="temp" selected="selected">Temp</option>
	<option value="sensor2">Sensor2</option>
	<option value="sensor2hyst">Sensor2+Histeresis</option>
    </select>
</td>

<td class="col-md-1">
   <select name="sensor2" class="form-control input-sm" id="sensor2" style="display: none">
<?php
   foreach ($result as $select) { 
   ?>
	<option value="<?php echo $select['id']; ?>"><?php echo $select['name']." ".$select['tmp'] ?></option>
<?php 
	} 
	?>
    </select>
    <input type="text" name="value" class="form-control input-sm" id="value" required="">
</td>

<td class="col-md-1">
    <input type="text" name="hyst" class="form-control input-sm" id="hyst" style="display: none" required="">
</td>

<td class="col-md-1">
<select name="onoff" class="form-control input-sm">
    <option value="on">ON</option>
    <option value="off">OFF</option>
  <!--  <option value="onoff">ON/OFF</option> -->
</select>
</td>

<td class="col-md-2">
	<select name="day_plan" class="form-control input-sm" <?php echo $a['day_run'] != 'on' ? 'disabled="disabled"' : ''; ?>
<?php
	foreach ($dp as $dp) {
	?>
	<option value="<?php echo $dp['name']?>"><?php echo $dp['name']?></option>
<?php 
	} 
	?>
	<option value="allways" selected="selected">allways</option>
	</select>
</td>

<td class="col-md-1">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="fadd" value="add" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
</td>

</form>
<!-- lista funkcji -->
</tr>
<?php 
    foreach ($func as $func) { ?>
<tr>
<td class="col-md-1">
	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
		<input type="hidden" name="fid" value="<?php echo $func['id']; ?>"/>
		<input type="hidden" name="up" value="up" />
		<button type="submit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>
	</form>
	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
		<input type="hidden" name="fid" value="<?php echo $func['id']; ?>"/>
		<input type="hidden" name="down" value="down" />
		<button type="submit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-arrow-down"></span></button>
	</form>
</td>

<td class="col-md-1">
<?php
  foreach ($result as $select) {
	if($select['id'] == $func['sensor']) {
			echo $select['name']." (".$select['tmp'].")";
		}	
	}
?>
</td>

<td class="col-md-1">
	<?php
		if($func['op']=="lt") { echo "&lt"; }  
		if($func['op']=="le") { echo "&lt;&#61;"; }
		if($func['op']=="gt") { echo "&gt"; }
		if($func['op']=="ge") { echo "&gt;&#61"; }
	?>
</td>

<td class="col-md-1" onclick='ch_source()'>
	<?php echo $func['source']
		?>
</td>

<td class="col-md-1">
<?php
if ($func['source'] == 'sensor2' || $func['source'] == 'sensor2hyst') {
 foreach ($result as $select) {
	if($select['id'] == $func['sensor2']) {
			echo $select['name']." (".$select['tmp'].")";
		}	
	}
} else {
	echo $func['value'];
}
?>
</td>

<td class="col-md-1">
    <?php echo $func['hyst']?>
</td>

<td class="col-md-1">
	<?php echo $func['onoff']?>
</td>

<td class="col-md-2">
	<?php echo $func['w_profile']?>
	</td>

<td class="col-md-1">
	<form class="form-horizontal" action="" method="post">
		<input type="hidden" name="fid" value="<?php echo $func['id']; ?>"/>
		<input type="hidden" name="fdel" value="del" />
		<button type="submit" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
	</form>
</td>


</tr>
<?php
	}
	?>

</div>
</table>
</div>

