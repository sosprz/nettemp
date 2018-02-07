<div class="panel panel-default">
<div class="panel-heading">Thing Speak
<span>
	<form action="" method="post" style="display:inline!important;">
		<button class="btn btn-xs btn-danger"><span>Add new channel</span> </button>
		<input type="hidden" name="addthc" value="addthc"/>
	</form>
</span>
</div>

<?php
// chanel update
$f1=isset($_POST['f1']) ? $_POST['f1'] : '';
$f2=isset($_POST['f2']) ? $_POST['f2'] : '';
$f3=isset($_POST['f3']) ? $_POST['f3'] : '';
$f4=isset($_POST['f4']) ? $_POST['f4'] : '';
$f5=isset($_POST['f5']) ? $_POST['f5'] : '';
$f6=isset($_POST['f6']) ? $_POST['f6'] : '';
$f7=isset($_POST['f7']) ? $_POST['f7'] : '';
$f8=isset($_POST['f8']) ? $_POST['f8'] : '';
$interval=isset($_POST['interval']) ? $_POST['interval'] : '';
$ch_update=isset($_POST['ch_update']) ? $_POST['ch_update'] : '';
$ch_update_id=isset($_POST['ch_update_id']) ? $_POST['ch_update_id'] : '';

if(!empty($ch_update_id) && ($ch_update == "ch_update")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE thingspeak SET f1='$f1',f2='$f2',f3='$f3',f4='$f4',f5='$f5',f6='$f6',f7='$f7',f8='$f8',interval='$interval' WHERE id='$ch_update_id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}


// add thingspeak chanell
$addthc = isset($_POST['addthc']) ? $_POST['addthc'] : '';
if(!empty($addthc) && ($addthc == "addthc")) { 
	
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT INTO thingspeak ('name', 'apikey', 'active', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'interval') VALUES ('My new chanell','API KEY', 'off', 'off', 'off', 'off', 'off', 'off', 'off', 'off', 'off', '1')");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}

//name
$name_new = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$name_id = isset($_POST['name_id']) ? $_POST['name_id'] : '';
$name_th = isset($_POST['name_th']) ? $_POST['name_th'] : '';
if(!empty($name_id) && !empty($name_new) && ($name_th == "name_th")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE thingspeak SET name='$name_new' WHERE id='$name_id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}

//api key
$api_new = isset($_POST['api_new']) ? $_POST['api_new'] : '';
$api_id = isset($_POST['api_id']) ? $_POST['api_id'] : '';
$api_th = isset($_POST['api_th']) ? $_POST['api_th'] : '';
if(!empty($api_id) && !empty($api_new) && ($api_th == "api_th")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE thingspeak SET apikey='$api_new' WHERE id='$api_id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}

// active
$active_id = isset($_POST['active_id']) ? $_POST['active_id'] : '';
$active_on = isset($_POST['active_on']) ? $_POST['active_on'] : '';
$th_active = isset($_POST['th_active']) ? $_POST['th_active'] : '';
    if ($th_active == "th_active"){
    $db->exec("UPDATE thingspeak SET active='$active_on' WHERE id='$active_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

//del from base
$del= isset($_POST['del']) ? $_POST['del'] : '';
$del_id = isset($_POST['del_id']) ? $_POST['del_id'] : '';
if(!empty($del_id) && !empty($del) && ($del == "delete")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM thingspeak WHERE id='$del_id'");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
}
//select sensors for field
$sth = $db->prepare("SELECT * FROM sensors WHERE thing='on'");
$sth->execute();
$result = $sth->fetchAll(); 

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM thingspeak");
$row = $rows->fetchAll();
$count = count($row);
if ($count >= "1") {
?>
<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">
<thead>
<th>Channel Name</th>
<th>Write API Key</th>
<th>F1</th>
<th>F2</th>
<th>F3</th>
<th>F4</th>
<th>F5</th>
<th>F6</th>
<th>F7</th>
<th>F8</th>
<th>Interval</th>
<th>Submit</th>
<th>Active</th>
</thead>
<?php
foreach ($row as $a) { 	
?>

<tr>
    <td class="col-md-0">
	<form class="form-horizontal" action="" method="post" style="display:inline!important;">	
			<input type="text" name="name_new" size="10" maxlength="30" value="<?php echo $a["name"]; ?>" />
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
			<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
			<input type="hidden" name="name_th" value="name_th"/>
	</form>
	</td>
	
	<td class="col-md-0">
	<form action="" method="post" style="display:inline!important;">
			<input type="text" name="api_new" size="10" maxlength="35" value="<?php echo $a["apikey"]; ?>" />
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
			<input type="hidden" name="api_id" value="<?php echo $a["id"]; ?>" />
			<input type="hidden" name="api_th" value="api_th"/>
	</form>
	</td>
	
	<td class="col-md-0">
	<form class="form-horizontal" action="" method="post" style="display:inline!important;">	
		<select name="f1" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
		
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f1'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
			
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f2" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f2'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f3" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f3'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f4" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f4'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f5" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f5'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f6" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f6'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f7" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f7'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="f8" class="form-control input-sm">
		<option value="off">off</option>
		<?php 
			foreach ($result as $select) { ?>
			<option value="<?php echo $select['rom']; ?>" <?php echo $select['rom']==$a['f8'] ? 'selected="selected"' : ''; ?> ><?php echo $select['name']." ".$select['tmp'] ?></option>
		<?php } ?>
		</select>
	</td>
	
	<td class="col-md-0">
		<select name="interval" class="form-control input-sm">
		<option value="1" <?php echo $a['interval'] == '1' ? 'selected="selected"' : ''; ?>>1 min</option>
		<option value="2" <?php echo $a['interval'] == '2' ? 'selected="selected"' : ''; ?>>2 min</option>
		<option value="5" <?php echo $a['interval'] == '5' ? 'selected="selected"' : ''; ?>>5 min</option>
		<option value="10" <?php echo $a['interval'] == '10' ? 'selected="selected"' : ''; ?>>10 min</option>
		<option value="30" <?php echo $a['interval'] == '30' ? 'selected="selected"' : ''; ?>>30 min</option>
		<option value="60" <?php echo $a['interval'] == '60' ? 'selected="selected"' : ''; ?>>60 min</option>
		</select>
	</td>
	
	<td class="col-md-0">
		<input type="hidden" name="ch_update_id" value="<?php echo $a['id']; ?>"/>
		<input type="hidden" name="ch_update" value="ch_update" />
		<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
		</form>
	</td>
	
	<td class="col-md-0">
		<form action="" method="post" style="display:inline!important;" > 	
		<input type="hidden" name="active_id" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="active_on" value="<?php echo $a["active"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["active"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["active"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="th_active" value="th_active" />
    </form>

	<form action="" method="post" style="display:inline!important;">
		<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
		<input type="hidden" name="del_id" value="<?php echo $a['id']; ?>" />
		<input type="hidden" name="del" value="delete"/>
	</form>
	</td>
</tr>
<?php
	}
?>
</table>


<?php
	} 
?>
</div>
</div>
<div class="panel-footer">

	

		<span id="helpBlock" class="help-block">
			ThingSpeak is available as a free service for small non-commercial home projects - 3 million messages/year. <br>
			Recommended maximum daily usage capacity:  8 219 messages. <br>
			For questions about exceeding suggested daily usage rate or for purchasing new units,
			see the
			<a href="https://thingspeak.com/pages/license_faq" target="_blank">Licensing FAQ</a>
		
		</span>

</div>