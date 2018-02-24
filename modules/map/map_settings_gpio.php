<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$dir="modules/gpio/";
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';

	//view on map
	$g_map = isset($_POST['g_map']) ? $_POST['g_map'] : '';
    $g_maponoff = isset($_POST['g_maponoff']) ? $_POST['g_maponoff'] : '';
    $g_mapon = isset($_POST['g_mapon']) ? $_POST['g_mapon'] : '';
    if (($g_maponoff == "onoff")){
	 $db->exec("UPDATE maps SET map_on='$g_mapon' WHERE element_id='$g_map'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//display name on map
	$g_name_on_map = isset($_POST['g_name_on_map']) ? $_POST['g_name_on_map'] : '';
    $g_name_on_maponoff = isset($_POST['g_name_on_maponoff']) ? $_POST['g_name_on_maponoff'] : '';
    $g_name_on_mapon = isset($_POST['g_name_on_mapon']) ? $_POST['g_name_on_mapon'] : '';
    if (($g_name_on_maponoff == "onoff")){
	$rows=$db->query("SELECT id FROM gpio WHERE gpio='$g_name_on_map'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
    $dbmaps->exec("UPDATE maps SET display_name='$g_name_on_mapon' WHERE element_id='$a[id]'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//control on map
	$control_on_map = isset($_POST['control_on_map']) ? $_POST['control_on_map'] : '';
    $control_on_maponoff = isset($_POST['control_on_maponoff']) ? $_POST['control_on_maponoff'] : '';
    $control_on_mapon = isset($_POST['control_on_mapon']) ? $_POST['control_on_mapon'] : '';
    if (($control_on_maponoff == "onoff")){
	$rows=$db->query("SELECT id FROM gpio WHERE gpio='$control_on_map'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
    $dbmaps->exec("UPDATE maps SET control_on_map='$control_on_mapon' WHERE element_id='$a[id]'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//icon on map
	$icon_on_map = isset($_POST['icon_on_map']) ? $_POST['icon_on_map'] : '';
    $icon_on_map_name = isset($_POST['icon_on_map_name']) ? $_POST['icon_on_map_name'] : '';
    $icon_on_map_set = isset($_POST['icon_on_map_set']) ? $_POST['icon_on_map_set'] : '';
    if (($icon_on_map_set == "set")){
	$rows=$db->query("SELECT id FROM gpio WHERE gpio='$icon_on_map'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
    $dbmaps->exec("UPDATE maps SET icon='$icon_on_map_name' WHERE element_id='$a[id]'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading">GPIO</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">


<?php 
$db = new PDO('sqlite:dbf/nettemp.db'); 
$dbmaps = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$rows = $db->query("SELECT * FROM gpio ORDER BY position ASC"); 
$row = $rows->fetchAll();


//SELECT * FROM sensors WHERE type='gpio' ORDER BY position ASC"); 

?>

<thead>
<tr>
<th>Name</th>
<th class="col-md-1 map-settings">View</th>
<th class="col-md-1 map-settings" title='View name on map'>Name view</th>
<th class="col-md-1 map-settings" title='Control on map'>Control</th>
<th class="col-md-1 map-settings">Icon</th>
</tr>
</thead>

<?php foreach ($row as $b) {
	$rows=$dbmaps->query("SELECT * FROM maps WHERE element_id='$b[id]'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
	
	$rows=$db->query("SELECT * FROM sensors WHERE type='gpio' AND rom='$b[rom]'");//always one record
	$c=$rows->fetchAll();
	$c=$c[0];//extracting from array
	?>

<tr>
	
	<td class="col-md-1">
		<?php echo $b["name"]." (".$b['gpio'].")" ?>
	</td>
	<td class="col-md-1">
		<form action="" method="post" style="display:inline!important;"> 	
			<input type="hidden" name="g_map" value="<?php echo $c['id']; ?>" />
			<input type="text" name="position_group" size="1" value="<?php echo $c['id']; ?>" />
			<input type="checkbox" data-toggle="toggle" data-size="mini"  name="g_mapon" value="<?php echo $a['map_on'] == 'on'  ? '' : 'on'; ?>" <?php echo $a['map_on'] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
			<input type="hidden" name="g_maponoff" value="onoff" />
		</form>
	</td>
	<!-- name on map  !!!not valid for humid and dist -->
	<td class="col-md-1">
					<?php if($b['mode'] != 'dist' && $b['mode'] != 'humid') : ?>
					<form action="" method="post" style="display:inline!important;"> 	
					<input type="hidden" name="g_name_on_map" value="<?php echo $b["gpio"]; ?>" />
					<input type="checkbox" data-toggle="toggle" data-size="mini"  name="g_name_on_mapon" value="on" <?php echo $a["display_name"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
					<input type="hidden" name="g_name_on_maponoff" value="onoff" />
					</form>
					<?php endif; ?>
	</td>
				<!-- control valid for [simple, moment, time, control] -->
	<td class="col-md-1">
					<?php if($b['mode'] == 'simple' || $b['mode'] == 'time' || $b['mode'] == 'moment' || $b['mode'] == 'control') : ?>
					<form action="" method="post" style="display:inline!important;"> 	
					<input type="hidden" name="control_on_map" value="<?php echo $b["gpio"]; ?>" />
					<input type="checkbox" data-toggle="toggle" data-size="mini"  name="control_on_mapon" value="on" <?php echo $a["control_on_map"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
					<input type="hidden" name="control_on_maponoff" value="onoff" />
					</form>
					<?php endif; ?>
				</td>
				<!-- icons for gpio -->
	<td class="col-md-8">
		<?php //if($b['mode'] == 'simple' || $b['mode'] == 'time' || $b['mode'] == 'moment' || $b['mode'] == 'control') : ?>
		<form action="" method="post" style="display:inline!important;"> 	
			<input type="hidden" name="icon_on_map" value="<?php echo $b["gpio"]; ?>" />
			<input type="hidden" name="icon_on_map_set" value="set" />
				<select id="icon_on_map_name" data-size="mini" name="icon_on_map_name" onchange="this.form.submit()">
						<option value='' <?php echo $a['icon'] == '' ? 'selected="selected"' : ''; ?>>default</option>
						<option value='Light' <?php echo $a['icon'] == 'Light' ? 'selected="selected"' : ''; ?>>Lights</option>
						<option value='Socket' <?php echo $a['icon'] == 'Socket' ? 'selected="selected"' : ''; ?>>Socket</option>
						<option value='Switch' <?php echo $a['icon'] == 'Switch' ? 'selected="selected"' : ''; ?>>Switch</option>
				</select>
		</form>
				
	</td>
					

</tr>

<?php } ?>

</table> </div> </div>

