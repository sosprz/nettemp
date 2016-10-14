<?php
    $save = isset($_POST['save']) ? $_POST['save'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
    $unit2 = isset($_POST['unit2']) ? $_POST['unit2'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
	 $ico = isset($_POST['ico']) ? $_POST['ico'] : '';
    $save_id = isset($_POST['save_id']) ? $_POST['save_id'] : '';
	 $add = isset($_POST['add']) ? $_POST['add'] : '';
   	 
    if ($save == 'save1'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE types SET title='$title',unit2='$unit2',unit='$unit',type='$type',ico='$ico' WHERE id='$save_id'") or header("Location: html/errors/db_error.php");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if ($add == 'add1'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('$type','$unit','$unit2','$ico','$title')") or header("Location: html/errors/db_error.php");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if ($add == 'del1'){
    $db = new PDO('sqlite:dbf/nettemp.db');
	 $db->exec("DELETE FROM types WHERE id='$save_id'") or die ("cannot insert to DB");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if ($add == "default") { 
    $db = new PDO("sqlite:dbf/nettemp.db");	
    $db->exec("DELETE from types") or header("Location: html/errors/db_error.php");
    $db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('temp', '°C', '°F', 'media/ico/temp2-icon.png' ,'Temperature')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('heaterst', '°C', '°F', 'media/ico/heaters-icon.png' ,'Heaters_Temp')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('lux', 'lux', 'lux', 'media/ico/sun-icon.png' ,'Lux')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('humid', '%', '%', 'media/ico/rain-icon.png' ,'Humidity')");
    $db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('press', 'hPa', 'hPa', 'media/ico/Science-Pressure-icon.png' ,'Pressure')");
    $db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('water', 'm3', 'm3', 'media/ico/water-icon.png' ,'Water')");
    $db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('gas', 'm3', 'm3', 'media/ico/gas-icon.png' ,'Gas')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('elec', 'kWh', 'W', 'media/ico/Lamp-icon.png' ,'Electricity')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('watt', 'W', 'W', 'media/ico/watt.png' ,'Watt')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('volt', 'V', 'V', 'media/ico/volt.png' ,'Volt')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('amps', 'A', 'A', 'media/ico/amper.png' ,'Amps')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('dist', 'cm', 'cm', 'media/ico/Distance-icon.png' ,'Distance')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('trigger', '', '', 'media/ico/alarm-icon.png' ,'Trigger')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('rainfall', 'mm/m2', 'mm/m2', '' ,'Rainfall')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('speed', 'km/h', 'km/h', '' ,'Speed')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('wind', '°', '°', '' ,'Wind')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('uv', 'index', 'index', '' ,'UV')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('storm', 'km', 'km', '' ,'Storm')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('lightining', '', '', '' ,'Lightining')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('hosts', 'ms', 'ms', '' ,'Host')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('system', '%', 'm%', '' ,'System')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('gpio', 'H/L', 'H/L', '' ,'GPIO')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('group', '', '', '' ,'')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('relay', '', '', '' ,'')");
	$db->exec("INSERT OR IGNORE INTO types (type, unit, unit2, ico, title) VALUES ('baterry', '', '', '' ,'Baterry')");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
?>

<div class="panel panel-default">
<div class="panel-heading">Types</div>

<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">

<?php
$rows = $db->query("SELECT * FROM types ");
$row = $rows->fetchAll();
?>
<thead>
<tr>
<th></th>
<th>Type</th>
<th>Unit</th>
<th>Unit2</th>
<th>ICO</th>
<th>Title</th>
<th></th>
</tr>
</thead>


<tr>
	 <td>
	 </td>
	 <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="text" name="type" size="10" maxlength="30" value="" class="form-control input-sm"/>
    </td>
     <td class="col-md-0">
		<input type="text" name="unit" size="10" maxlength="30" value="" class="form-control input-sm"/>
    </td>
     <td class="col-md-0">
		<input type="text" name="unit2" size="10" maxlength="30" value="" class="form-control input-sm"/>
    </td>
    <td class="col-md-0">
		<input type="text" name="ico" size="25" maxlength="30" value="" class="form-control input-sm"/>
    </td>
	<td class="col-md-0">
		<input type="text" name="title" size="10" maxlength="30" value="" class="form-control input-sm"/>
    </td>
    <td class="col-md-0">
	
    </td>
    <td class="col-md-6">
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
		<input type="hidden" name="add" value="add1"/>
    </form>
    </td>
</tr>
<?php 
   foreach ($row as $a) { 	
	?>
<tr>
	 <td>
	 <?php echo $type="<img src=\"".$a['ico']."\" alt=\"\" title=\"".$a['title']."\"/>"; ?>
	 </td>
	 <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="text" name="type" size="10" maxlength="30" value="<?php echo $a['type']; ?>" class="form-control input-sm"/>
    </td>
     <td class="col-md-0">
		<input type="text" name="unit" size="10" maxlength="30" value="<?php echo $a['unit']; ?>" class="form-control input-sm"/>
    </td>
     <td class="col-md-0">
		<input type="text" name="unit2" size="10" maxlength="30" value="<?php echo $a['unit2']; ?>" class="form-control input-sm"/>
    </td>
    <td class="col-md-0">
		<input type="text" name="ico" size="25" maxlength="30" value="<?php echo $a['ico']; ?>" class="form-control input-sm"/>
    </td>
	<td class="col-md-0">
		<input type="text" name="title" size="10" maxlength="30" value="<?php echo $a['title']; ?>" class="form-control input-sm"/>
    </td>
    <td class="col-md-0">
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-save"></span> </button>
		<input type="hidden" name="save_id" value="<?php echo $a['id']; ?>" />
		<input type="hidden" name="save" value="save1"/>
    </td>
    </form>
    <td class="col-md-6">
    <form action="" method="post" style="display:inline!important;">
		<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
		<input type="hidden" name="save_id" value="<?php echo $a['id']; ?>" />
		<input type="hidden" name="add" value="del1"/>
    </form>
    </td>
</tr>
   
<?php
	}
	?>
<tr>
    <td class="col-md-0">
    </td>
    <td class="col-md-0">
    </td>
	 <td class="col-md-0">
    </td>
    <td class="col-md-0">
    </td>
    <td class="col-md-0">
    </td>
    <td class="col-md-0">
    </td>
    <td colspan="2" class="col-md-6">
	 <form action="" method="post" style="display:inline!important;">
		<button class="btn btn-xs btn-info">Reset to defaults <span class="glyphicon glyphicon-refresh"></span> </button>
		<input type="hidden" name="add" value="default"/>
    </form>
	 </td>
</tr>


</table>
</div>

