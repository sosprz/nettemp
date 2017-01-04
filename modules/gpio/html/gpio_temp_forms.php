<script type="text/JavaScript">
function ch_source() {
		if (document.getElementById("source").value == 'value') {
		    document.getElementById("value").style.display = 'block';
		    document.getElementById("sensor2").style.display = 'none';
		    document.getElementById("hyst").style.display = 'none';
		    document.getElementById("value").required = true;
		    document.getElementById("hyst").required = false;
		    document.getElementById("actionand").style.display = 'block';
		}
		if (document.getElementById("source").value == 'sensor2') {
		    document.getElementById("value").style.display = 'none';
		    document.getElementById("sensor2").style.display = 'block';
		    document.getElementById("hyst").style.display = 'none';
		    document.getElementById("value").required = false;
		    document.getElementById("hyst").required = false;
		    document.getElementById("actionand").style.display = 'block';
		}
		if (document.getElementById("source").value == 'valuehyst') {
		    document.getElementById("value").style.display = 'block';
		    document.getElementById("sensor2").style.display = 'none';
		    document.getElementById("hyst").style.display = 'block';
		    document.getElementById("value").required = true;
		    document.getElementById("hyst").required = true;
		    document.getElementById("actionand").style.display = 'none';
		    
		}
		if (document.getElementById("source").value == 'sensor2hyst') {
		    document.getElementById("value").style.display = 'none';
		    document.getElementById("sensor2").style.display = 'block';
		    document.getElementById("hyst").style.display = 'block';
		    document.getElementById("value").required = false;
		    document.getElementById("sensor2").required = false;
		    document.getElementById("hyst").required = true;
		    document.getElementById("actionand").style.display = 'none';
		}
}

    </script>

<?php
	//change
	$sensor1_update=isset($_POST['sensor1_update']) ? $_POST['sensor1_update'] : '';
	$source_update=isset($_POST['source_update']) ? $_POST['source_update'] : '';
	$op_update=isset($_POST['op_update']) ? $_POST['op_update'] : '';
	$sensor2_update=isset($_POST['sensor2_update']) ? $_POST['sensor2_update'] : '';
	$value_update=isset($_POST['value_update']) ? $_POST['value_update'] : '';
	$hyst_update=isset($_POST['hyst_update']) ? $_POST['hyst_update'] : '';
	$onoff_update=isset($_POST['onoff_update']) ? $_POST['onoff_update'] : '';
	$day_plan_update=isset($_POST['day_plan_update']) ? $_POST['day_plan_update'] : '';
	$fid_update=isset($_POST['fid_update']) ? $_POST['fid_update'] : '';
	$fupdate=isset($_POST['fupdate']) ? $_POST['fupdate'] : '';

	if ($source_update == 'value') {
	    $sensor2_update=NULL;
	    $hyst_update=NULL;
    } elseif ($source_update == 'sensor2') {
	    $value_update=NULL;
	    $hyst_update=NULL;
    } elseif ($source_update == 'valuehyst') {
	    $sensor2_update=NULL;
    } elseif ($source_update == 'sensor2hyst') {
	    $value_update=NULL;
    }
    
	if ($fupdate == "change"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE g_func SET sensor='$sensor1_update', sensor2='$sensor2_update', onoff='$onoff_update', value='$value_update', op='$op_update', hyst='$hyst_update', w_profile='$day_plan_update' WHERE id='$fid_update'");
		$db->exec("UPDATE g_func SET w_profile='any' WHERE id='$fid_update'");

		//header("location: " . $_SERVER['REQUEST_URI']);
		//exit();
	}

	
	
	
	
	

	//update
	$sensor1=isset($_POST['sensor1']) ? $_POST['sensor1'] : '';
	$sensor2=isset($_POST['sensor2']) ? $_POST['sensor2'] : '';
	$source=isset($_POST['source']) ? $_POST['source'] : '';
	$value=isset($_POST['value']) ? $_POST['value'] : '';
	$hyst=isset($_POST['hyst']) ? $_POST['hyst'] : '';
	$onoff=isset($_POST['onoff']) ? $_POST['onoff'] : '';
	$op=isset($_POST['op']) ? $_POST['op'] : '';
	$day_plan=isset($_POST['day_plan']) ? $_POST['day_plan'] : '';
	
	$fadd=isset($_POST['fadd']) ? $_POST['fadd'] : '';
	$fdel=isset($_POST['fdel']) ? $_POST['fdel'] : '';
	$fid=isset($_POST['fid']) ? $_POST['fid'] : '';
	$down=isset($_POST['down']) ? $_POST['down'] : '';
	$up=isset($_POST['up']) ? $_POST['up'] : '';
	$fpos=isset($_POST['fpos']) ? $_POST['fpos'] : '';
	
	if ($source == 'value') {
	    $sensor2=NULL;
	    $hyst=NULL;
    } elseif ($source == 'sensor2') {
	    $value=NULL;
	    $hyst=NULL;
    } elseif ($source == 'valuehyst') {
	    $sensor2=NULL;
    } elseif ($source == 'sensor2hyst') {
	    $value=NULL;
    }
    
    if(($op=='gt' || $op=='ge') && ($source=='sensor2hyst' || $source=='valuehyst')) {
    	if ($hyst > 0) {
			$hyst=$hyst*-1;    	
    	}    	
    }
	
	if ($fadd == "add"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$sth3 = $db->prepare("SELECT position FROM g_func WHERE position = (SELECT MAX(position) FROM g_func)");
		$sth3->execute();
		$last = $sth3->fetchAll();
		 foreach ($last as $l) {
		 	$position=$l['position'];
		 }
		 if($position=='0' || $position==null) {
						 $position='1';	
		 	} else {
		 		$position=$position+1;
		 }
		
		$db->exec("INSERT OR IGNORE INTO g_func (position,sensor, sensor2, onoff, value, op, hyst, source, gpio, w_profile) VALUES ('$position','$sensor1','$sensor2', '$onoff', '$value', '$op', '$hyst', '$source', '$gpio', '$day_plan')") or die ($db->lastErrorMsg());
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	if ($fdel == "del"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("DELETE FROM g_func WHERE id='$fid'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	if ($up == "up") {
		$sth3 = $db->prepare("SELECT position FROM g_func WHERE position = (SELECT MIN(position) FROM g_func)");
			$sth3->execute();
			$last = $sth3->fetchAll();
		 	foreach ($last as $l) {
		 		$min=$l['position'];
		 	}
		 	$sth3 = $db->prepare("SELECT id FROM g_func WHERE position <= $fpos-1 ORDER BY position DESC LIMIT 1");
			$sth3->execute();
			$last = $sth3->fetchAll();
		 	foreach ($last as $l) {
		 		$already=$l['id'];
		 	}
		if ($fpos != $min){
			$db = new PDO('sqlite:dbf/nettemp.db');
			$db->exec("UPDATE g_func SET position=$fpos WHERE id='$already'");
			$db->exec("UPDATE g_func SET position=$fpos-1 WHERE id='$fid'");
			header("location: " . $_SERVER['REQUEST_URI']);
			exit();
		}
	}
	if ($down == "down"){
		$db = new PDO('sqlite:dbf/nettemp.db');
			$sth3 = $db->prepare("SELECT position FROM g_func WHERE position = (SELECT MAX(position) FROM g_func)");
			$sth3->execute();
			$last = $sth3->fetchAll();
		 	foreach ($last as $l) {
		 		$max=$l['position'];
		 	}
		 	$sth3 = $db->prepare("SELECT id FROM g_func WHERE position >= $fpos+1 ORDER BY position ASC LIMIT 1");
			$sth3->execute();
			$last = $sth3->fetchAll();
		 	foreach ($last as $l) {
		 		$already=$l['id'];
		 	}
		if ($fpos != $max){
			$db = new PDO('sqlite:dbf/nettemp.db');
			$db->exec("UPDATE g_func SET position=$fpos WHERE id='$already'");
			$db->exec("UPDATE g_func SET position=$fpos+1 WHERE id='$fid'");
			header("location: " . $_SERVER['REQUEST_URI']);
			exit();
		}
	}

	//loops
	$sth = $db->prepare("SELECT * FROM sensors");
    $sth->execute();
    $result = $sth->fetchAll(); 

	$sth1 = $db->prepare("SELECT * FROM day_plan WHERE gpio='$gpio'");
	$sth1->execute();
	$dp = $sth1->fetchAll();
	
	$sth2 = $db->prepare("SELECT * FROM g_func WHERE gpio='$gpio' ORDER BY position ASC");
	$sth2->execute();
	$func = $sth2->fetchAll();
	?>
<div class="panel panel-default">
<div class="panel-heading">Value functions</div>
<table class="table table-condensed table-hover table-striped">
<thead><tr>

<th>ID</th>
<th>Pos</th>
<th>Source</th>
<th>State</th>
<th>Mode</th>
<th>Value</th>
<th>Histeresis</th>
<th>Action</th>
<th>Week Profile</th>
<th></th>

</tr></thead>

<div class="form-group">
<tr>

<form class="form-horizontal" action="" method="post">
<td class="col-md-1">
</td>
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
	<option value="valuehyst">Value+Histeresis</option>
	<option value="value" selected="selected">Value</option>
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
    <input type="text" name="hyst" class="form-control input-sm" id="hyst" style="display: none">
</td>

<td class="col-md-1">
<select name="onoff" class="form-control input-sm">
    <option value="on">ON</option>
    <option value="off">OFF</option>
    <option value="and" id="actionand">AND</option>
</select>
</td>

<td class="col-md-2">
	<select name="day_plan" class="form-control input-sm" <?php echo $a['day_run'] != 'on' ? 'disabled="disabled"' : ''; ?>>
<?php
	foreach ($dp as $dp) {
	?>
	<option value="<?php echo $dp['name']?>"><?php echo $dp['name']?></option>
<?php 
	} 
	?>
	<option value="any" selected="selected">any</option>
	</select>
</td>

<td class="col-md-1">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="fadd" value="add" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
</td>

</form>

</tr>

<!-- lista funkcji -->
<?php 
    foreach ($func as $func) { ?>
<tr>
<td class="col-md-1">
<?php echo $func['id']; ?>
</td>
<td class="col-md-1">
<?php 
	//echo $func['position'];
?>
	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
		<input type="hidden" name="fid" value="<?php echo $func['id']; ?>"/>
		<input type="hidden" name="fpos" value="<?php echo $func['position']; ?>"/>
		<input type="hidden" name="up" value="up" />
		<button type="submit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>
	</form>
	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
		<input type="hidden" name="fid" value="<?php echo $func['id']; ?>"/>
		<input type="hidden" name="fpos" value="<?php echo $func['position']; ?>"/>
		<input type="hidden" name="down" value="down" />
		<button type="submit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-arrow-down"></span></button>
	</form>
</td>

<td class="col-md-1">
<form class="form-horizontal" action="" method="post" style="display:inline!important;">	
	<select name="sensor1_update" class="form-control input-sm">
	<?php 
    foreach ($result as $select) { ?>
		<option value="<?php echo $select['id']; ?>" <?php echo $select['id']==$func['sensor'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
	<?php 
    } 
	?>
	</select>
</td>

<td class="col-md-1">
	<select name="op_update" class="form-control input-sm">
		<option value="lt" <?php echo $func['op'] == 'lt' ? 'selected="selected"' : ''; ?>>&lt;</option>   
		<option value="le" <?php echo $func['op'] == 'le' ? 'selected="selected"' : ''; ?>>&lt;&#61;</option>     
		<option value="gt" <?php echo $func['op'] == 'gt' ? 'selected="selected"' : ''; ?>>&gt;</option>   
		<option value="ge" <?php echo $func['op'] == 'ge' ? 'selected="selected"' : ''; ?>>&gt;&#61;</option>   
	</select>
</td>

<td class="col-md-1" onclick='ch_source()'>
	<input type="hidden" name="source_update" value="<?php echo $func['source'];?>">
	<?php 
	if($func['source']=="value") { echo "value"; }
	elseif($func['source']=="valuehyst") { echo "val + hist"; }
	elseif($func['source']=="sensor2hyst") { echo "sensor2 + hist"; }
	elseif($func['source']=="sensor2") { echo "sensor2"; }
		?>
</td>

<td class="col-md-1">
<?php

if ($func['source'] == 'sensor2' || $func['source'] == 'sensor2hyst') 
{
?>
	<select name="sensor2_update" class="form-control input-sm" id="sensor2" >
	<?php
		foreach ($result as $select) { 
		?>
			<option value="<?php echo $select['id']; ?>" <?php echo $select['id'] == $func['sensor2'] ? 'selected="selected"' : ''; ?>><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php 
		} 
		?>
    </select>
<?php
} 
else { 
	?>
	<input type="text" name="value_update" class="form-control input-sm" id="value" required="" value="<?php echo $func['value'];?>">
	<?php
}
?>
</td>

<td class="col-md-1">
	<?php
	if($func['source']=="valuehyst"||$func['source']=="sensor2hyst") { 
	?>
	<input type="text" name="hyst_update" class="form-control input-sm" id="value" required="" value="<?php echo $func['hyst'];?>">
	<?php
	}
	?>
</td>

<td class="col-md-1">
	<select name="onoff_update" class="form-control input-sm">
		<option value="on"  <?php echo $func['onoff'] == 'on' ? 'selected="selected"' : ''; ?>  >ON</option>
		<option value="off" <?php echo $func['onoff'] == 'off' ? 'selected="selected"' : ''; ?>  >OFF</option>
		<option value="and"  <?php echo $func['onoff'] == 'and' ? 'selected="selected"' : ''; ?>  id="actionand">AND</option>
	</select>
</td>
<td class="col-md-2">
	<select name="day_plan_update" class="form-control input-sm" <?php echo $a['day_run'] != 'on' ? 'disabled="disabled"' : ''; ?>>
	<?php
	$sth1 = $db->prepare("SELECT * FROM day_plan WHERE gpio='$gpio'");
	$sth1->execute();
	$dpu = $sth1->fetchAll();
	foreach ($dpu as $dpu) {
	?>
	<option value="<?php echo $dpu['name']?>" <?php echo $func['w_profile'] == $dpu['name'] ? 'selected="selected"' : ''; ?>><?php echo $dpu['name']?></option>
	<?php 
	} 
	?>
	<option value="any" <?php echo $func['w_profile'] == 'any' ? 'selected="selected"' : ''; ?>>any</option>
	</select>
</td>


	
		<input type="hidden" name="fid_update" value="<?php echo $func['id']; ?>"/>
		<input type="hidden" name="fupdate" value="change" />
<td class="col-md-1">
		<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
	</form>
	<form class="form-horizontal" action="" method="post" style="display:inline!important;">
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

