<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$dbmaps = new PDO('sqlite:dbf/maps.db') or die("cannot open the database");
$dir="modules/gpio/";
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';

$position = isset($_POST['position']) ? $_POST['position'] : '';
    $position_id = isset($_POST['position_id']) ? $_POST['position_id'] : '';
    if (!empty($position_id) && ($_POST['positionok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE gpio SET position='$position' WHERE id='$position_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
	//view on map
	$map = isset($_POST['map']) ? $_POST['map'] : '';
    $maponoff = isset($_POST['maponoff']) ? $_POST['maponoff'] : '';
    $mapon = isset($_POST['mapon']) ? $_POST['mapon'] : '';
    if (($maponoff == "onoff")){
	$dbmaps = new PDO('sqlite:dbf/maps.db');
    $dbmaps->exec("UPDATE maps SET map_on='$mapon' WHERE element_id='$map' AND type='gpio'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//display name on map
	$name_on_map = isset($_POST['name_on_map']) ? $_POST['name_on_map'] : '';
    $name_on_maponoff = isset($_POST['name_on_maponoff']) ? $_POST['name_on_maponoff'] : '';
    $name_on_mapon = isset($_POST['name_on_mapon']) ? $_POST['name_on_mapon'] : '';
    if (($name_on_maponoff == "onoff")){
	$rows=$db->query("SELECT id FROM gpio WHERE gpio='$name_on_map'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
    $dbmaps->exec("UPDATE maps SET display_name='$name_on_mapon' WHERE element_id='$a[id]' AND type='gpio'") or die ($db->lastErrorMsg());
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
    $dbmaps->exec("UPDATE maps SET control_on_map='$control_on_mapon' WHERE element_id='$a[id]' AND type='gpio'") or die ($db->lastErrorMsg());
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
    $dbmaps->exec("UPDATE maps SET icon='$icon_on_map_name' WHERE element_id='$a[id]' AND type='gpio'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading">Status</div>
<div class="table-responsive">
<script>
	$(document).ready(function(){
		$("button").click(function(event){$("#" + event.target.id + "-row").toggle();});
	});
</script>
<table class="table table-hover table-condensed small" border="0">


<?php 
$db = new PDO('sqlite:dbf/nettemp.db'); 
$dbmaps = new PDO('sqlite:dbf/maps.db') or die("cannot open the database");
$rows = $db->query("SELECT * FROM gpio ORDER BY position ASC"); 
$row = $rows->fetchAll();

?>

<thead>
<tr>
<th>Pos</th>
<th>Settings</th>
<th>Name</th>
<th>Function</th>
<th>Status</th>
<th>Map</th>
<th></th>
</tr>
</thead>

<?php foreach ($row as $b) {
	$rows=$dbmaps->query("SELECT * FROM maps WHERE element_id='$b[id]' AND type='gpio'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
	?>

<tr>
	<td class="col-md-2">
    		<form action="" method="post" style="display:inline!important;">
        	<input type="hidden" name="position_id" value="<?php echo $b["id"]; ?>" />
        	<input type="text" name="position" size="1" maxlength="3" value="<?php echo $b['position']; ?>" />
        	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
        	<input type="hidden" name="positionok" value="ok" />
    		</form>
	</td>
	<td class="col-md-2">
		<a href="index.php?id=devices&type=gpio&gpios=<?php echo $b['gpio']?>" class="btn btn-xs btn-success ">GPIO <?php echo $b['gpio']?></a>
	</td>
	<td class="col-md-2">
                <span class="label label-default"><?php echo $b["name"]; ?></span>
        </td>


	<td class="col-md-2">
                <span class="label label-default"><?php echo $b["mode"]; ?></span>
        </td>

	<td class="col-md-2"> 
		<?php
		    if (strpos($b['status'],'ON') !== false) {
		?>
			<span class="label label-success">
			<?php
			} else {
			?> <span class="label label-danger">

 		<?php }?>
			<?php
			echo $b['status']; ?> </span>
	</td>
	<td class="col-md-1">
	<button class="btn btn-xs btn-success" id="settings-on-map-<?php echo $b['id']; ?>">
		<span class="glypicon glyphicon-plus"></span>
	</button>
	</td>
</tr>
<tr id="settings-on-map-<?php echo $b['id']; ?>-row" style="display:none">
	<td colspan="7">
		<table>
			<thead>
				<tr>
					<th class="col-md-1 map-settings">View</th>
					<th class="col-md-1 map-settings" title='View name on map'>Name on map</th>
					<th class="col-md-1 map-settings" title='Control on map'>Control</th>
					<th class="col-md-1 map-settings">Icon</th>
				</tr>
			</thead>
			<tr>
				<td>
					<form action="" method="post" style="display:inline!important;"> 	
					<input type="hidden" name="map" value="<?php echo $a["element_id"]; ?>" />
					<input type="checkbox" data-toggle="toggle" data-size="mini"  name="mapon" value="on" <?php echo $a["map_on"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
					<input type="hidden" name="maponoff" value="onoff" />
					</form>
				</td>
			<!-- name on map  !!!not valid for humid and dist -->
				<td class="col-md-1">
					<?php if($b['mode'] != 'dist' && $b['mode'] != 'humid') : ?>
					<form action="" method="post" style="display:inline!important;"> 	
					<input type="hidden" name="name_on_map" value="<?php echo $b["gpio"]; ?>" />
					<input type="checkbox" data-toggle="toggle" data-size="mini"  name="name_on_mapon" value="on" <?php echo $a["display_name"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
					<input type="hidden" name="name_on_maponoff" value="onoff" />
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
				<td class="col-md-1">
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
				</td>
					</form>
					<?php //endif; ?>
			</tr>
		</table>
	</td>
</tr>

<?php } ?>

</table> </div> </div>

