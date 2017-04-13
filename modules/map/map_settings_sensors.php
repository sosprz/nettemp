<?php
	//display name on map
	$name_on_map = isset($_POST['name_on_map']) ? $_POST['name_on_map'] : '';
    $name_on_maponoff = isset($_POST['name_on_maponoff']) ? $_POST['name_on_maponoff'] : '';
    $name_on_mapon = isset($_POST['name_on_mapon']) ? $_POST['name_on_mapon'] : '';
    if (($name_on_maponoff == "onoff")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET display_name='$name_on_mapon' WHERE element_id='$name_on_map' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//transparent background
	$transparent_name_on_map = isset($_POST['transparent_name_on_map']) ? $_POST['transparent_name_on_map'] : '';
    $transparent_name_on_maponoff = isset($_POST['transparent_name_on_maponoff']) ? $_POST['transparent_name_on_maponoff'] : '';
    $transparent_name_on_mapon = isset($_POST['transparent_name_on_mapon']) ? $_POST['transparent_name_on_mapon'] : '';
    if (($transparent_name_on_maponoff == "onoff")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET transparent_bkg='$transparent_name_on_mapon' WHERE element_id='$transparent_name_on_map' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//background_color
	$background_color = isset($_POST['background_color']) ? $_POST['background_color'] : '';
    $background_color_value = isset($_POST['background_color_value']) ? $_POST['background_color_value'] : '';
    $background_color_set = isset($_POST['background_color_set']) ? $_POST['background_color_set'] : '';
    if (($background_color_set == "set")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET background_color='$background_color_value' WHERE element_id='$background_color' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//background_low
	$low_color = isset($_POST['low_color']) ? $_POST['low_color'] : '';
    $low_color_value = isset($_POST['low_color_value']) ? $_POST['low_color_value'] : '';
    $low_color_set = isset($_POST['low_color_set']) ? $_POST['low_color_set'] : '';
    if (($low_color_set == "set")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET background_low='$low_color_value' WHERE element_id='$low_color' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//background_high
	$high_color = isset($_POST['high_color']) ? $_POST['high_color'] : '';
    $high_color_value = isset($_POST['high_color_value']) ? $_POST['high_color_value'] : '';
    $high_color_set = isset($_POST['high_color_set']) ? $_POST['high_color_set'] : '';
    if (($high_color_set == "set")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET background_high='$high_color_value' WHERE element_id='$high_color' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//font_color
	$font_color = isset($_POST['font_color']) ? $_POST['font_color'] : '';
    $font_color_value = isset($_POST['font_color_value']) ? $_POST['font_color_value'] : '';
    $font_color_set = isset($_POST['font_color_set']) ? $_POST['font_color_set'] : '';
    if (($font_color_set == "set")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET font_color='$font_color_value' WHERE element_id='$font_color' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//font_size
	$font_size = isset($_POST['font_size']) ? $_POST['font_size'] : '';
    $font_size_value = isset($_POST['font_size_value']) ? $_POST['font_size_value'] : '';
    $font_size_set = isset($_POST['font_size_set']) ? $_POST['font_size_set'] : '';
    if (($font_size_set == "set")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET font_size='$font_size_value' WHERE element_id='$font_size' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	$reset_map_id=isset($_POST['reset_map_id']) ? $_POST['reset_map_id'] : '';
	$reset_map_settings=isset($_POST['reset_map_settings']) ? $_POST['reset_map_settings'] : '';
	$reset_map_settings_default=isset($_POST['reset_map_settings_default']) ? $_POST['reset_map_settings_default'] : '';
	if (($reset_map_settings == "reset") && ($reset_map_settings_default=='default'))
	{
		$dbmaps = new PDO('sqlite:dbf/nettemp.db');
		$dbmaps->exec("UPDATE maps SET display_name='on' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
		$dbmaps->exec("UPDATE maps SET transparent_bkg='' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
		$dbmaps->exec("UPDATE maps SET background_color='' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
		$dbmaps->exec("UPDATE maps SET background_low='' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
		$dbmaps->exec("UPDATE maps SET background_high='' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
		$dbmaps->exec("UPDATE maps SET font_color='' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
		$dbmaps->exec("UPDATE maps SET font_size='' WHERE element_id='$reset_map_id' AND type='sensors'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
    exit();
   }
	//MAP ON/OFF
    $map = isset($_POST['map']) ? $_POST['map'] : '';
    $maponoff = isset($_POST['maponoff']) ? $_POST['maponoff'] : '';
    $mapon = isset($_POST['mapon']) ? $_POST['mapon'] : '';
    if ($maponoff == "onoff"){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE maps SET map_on='$mapon' WHERE element_id='$map' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?> 


<div class="panel panel-default">
<div class="panel-heading">Sensors</div>

<div class="table-responsive">
<script>
	$(document).ready(function(){
		$("button").click(function(event){$("#" + event.target.id + "-row").toggle();});
	});
</script>
<table class="table table-hover table-condensed small" border="0">

<?php
$counters=array("gas","water","elec");
$db = new PDO('sqlite:dbf/nettemp.db');
$dbmaps = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors ORDER BY position ASC");

$row = $rows->fetchAll();
?>
<thead>
<tr>
		<th>Name</th>
	   <th class="col-md-1 map-settings">View</th>
		<th class="col-md-1 map-settings">Name view</th>
		<th class="col-md-1 map-settings">Transparent</th>
		<th class="col-md-1 map-settings">Background</th>
		<th class="col-md-1 map-settings">Low</th>
		<th class="col-md-1 map-settings">High</th>
		<th class="col-md-1 map-settings">Font</th>
		<th class="col-md-1 map-settings">Font[%]</th>
		<th class="col-md-1 map-settings"></th>
		<th class="col-md-3 map-settings"></th>
</tr>
</thead>



<?php 
    foreach ($row as $a) { 	
		$rows_maps = $dbmaps->query("SELECT * FROM maps WHERE element_id='$a[id]' AND type='sensors'");
		$row_maps=$rows_maps->fetchAll();
		$row_maps=$row_maps[0];
?>
<tr>
	
    <td class="col-md-1">
		<?php echo $a["name"]; ?>
    </td>

    
	<td class="col-md-1">
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="map" value="<?php echo $row_maps["element_id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="mapon" value="on" <?php echo $row_maps["map_on"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="maponoff" value="onoff" />
    </form>
    </td>
	<td class="col-md-1">
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="name_on_map" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="name_on_mapon" value="on" <?php echo $row_maps["display_name"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="name_on_maponoff" value="onoff" />
		</form>
	</td>
	<td class="col-md-1"><!-- transparent background only for sensors-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="transparent_name_on_map" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="transparent_name_on_mapon" value="on" <?php echo $row_maps["transparent_bkg"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="transparent_name_on_maponoff" value="onoff" />
		</form>
	</td>
	<td class="col-md-1"><!-- Background color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="background_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="background_color_value" value="<?php echo $row_maps['background_color']?  $row_maps['background_color']: '#5cb85c'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="background_color_set" value="set" />
		</form>
	</td>
	<td class="col-md-1"><!-- Low color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="low_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="low_color_value" value="<?php echo $row_maps['background_low'] ?  $row_maps['background_low']: '#337ab7'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="low_color_set" value="set" />
		</form>
	</td>
	<td class="col-md-1"><!-- High color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="high_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="high_color_value" value="<?php echo $row_maps['background_high'] ? $row_maps['background_high']: '#d9534f'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="high_color_set" value="set" />
		</form>
	</td>
	<td class="col-md-1"><!-- Font color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="font_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="font_color_value" value="<?php echo $row_maps['font_color'] ? $row_maps['font_color']: '#ffffff'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="font_color_set" value="set" />
		</form>
	</td>
	<td class="col-md-1"><!-- Font size-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="font_size" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="text" size="3"  name="font_size_value" value="<?php echo $row_maps['font_size'] ? $row_maps['font_size']: '75'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="font_size_set" value="set" />
		</form>
	</td>
	<td class="col-md-1"><!-- Reset to default -->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="reset_map_id" value="<?php echo $row_maps["element_id"]; ?>" />
		<button class="btn btn-xs btn-danger"  name="reset_map_settings" value="reset" onchange="this.form.submit()">
		<span class="glyphicon glyphicon-refresh"></span> Reset</button>
		<input type="hidden" name="reset_map_settings_default" value="default" />
		</form>
	</td>
	<td class="col-md-2"></td>

</tr>

<?php 

}  

?>
</table>
</div>
</div>

    
