<?php

    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $position_id = isset($_POST['position_id']) ? $_POST['position_id'] : '';
    if (!empty($position_id) && ($_POST['positionok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET position='$position' WHERE id='$position_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
   
	
    $gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
    $tmp_min_new = isset($_POST['tmp_min_new']) ? $_POST['tmp_min_new'] : '';
    $tmp_max_new = isset($_POST['tmp_max_new']) ? $_POST['tmp_max_new'] : '';
    $tmp_id = isset($_POST['tmp_id']) ? $_POST['tmp_id'] : '';
	
    if (!empty($tmp_id) && ($_POST['ok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET tmp_min='$tmp_min_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE sensors SET tmp_max='$tmp_max_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 

    $alarmonoff= isset($_POST['alarmonoff']) ? $_POST['alarmonoff'] : '';
    $alarm = isset($_POST['alarm']) ? $_POST['alarm'] : '';
    $rom = isset($_POST['rom']) ? $_POST['rom'] : '';
    if ( !empty($alarm) && ($alarmonoff == "onoff")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='$alarm' WHERE rom='$rom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
    elseif (empty($alarm) && ($alarmonoff == "onoff")){
    $db->exec("UPDATE sensors SET alarm='' WHERE rom='$rom'") or die ($db->lastErrorMsg());
    unlink("tmp/mail/$rom.mail");
    unlink("tmp/mail/hour/$rom.mail");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $charts = isset($_POST['charts']) ? $_POST['charts'] : '';
    $chartsonoff = isset($_POST['chartsonoff']) ? $_POST['chartsonoff'] : '';
    $chartson = isset($_POST['chartson']) ? $_POST['chartson'] : '';
    if ($chartsonoff == "onoff"){
    $db->exec("UPDATE sensors SET charts='$chartson' WHERE id='$charts'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $remote = isset($_POST['remote']) ? $_POST['remote'] : '';
    $remoteonoff = isset($_POST['remoteonoff']) ? $_POST['remoteonoff'] : '';
    $remoteon = isset($_POST['remoteon']) ? $_POST['remoteon'] : '';
    if (($remoteonoff == "onoff")){
    $db->exec("UPDATE sensors SET remote='$remoteon' WHERE id='$remote'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $minmax = isset($_POST['minmax']) ? $_POST['minmax'] : '';
    $minmaxonoff = isset($_POST['minmaxonoff']) ? $_POST['minmaxonoff'] : '';
    $minmaxon = isset($_POST['minmaxon']) ? $_POST['minmaxon'] : '';
    if (($minmaxonoff == "onoff")){
    $db->exec("UPDATE sensors SET minmax='$minmaxon' WHERE id='$minmax'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $adj = isset($_POST['adj']) ? $_POST['adj'] : '';
    $adj1 = isset($_POST['adj1']) ? $_POST['adj1'] : '';
    if ($adj1 == 'adj2'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET adj='$adj' WHERE id='$name_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 

    $sum = isset($_POST['sum']) ? $_POST['sum'] : '';
    $sum1 = isset($_POST['sum1']) ? $_POST['sum1'] : '';
    if ($sum1 == 'sum2'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET sum='$sum' WHERE id='$name_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $map = isset($_POST['map']) ? $_POST['map'] : '';
    $maponoff = isset($_POST['maponoff']) ? $_POST['maponoff'] : '';
    $mapon = isset($_POST['mapon']) ? $_POST['mapon'] : '';
    if (($maponoff == "onoff")){
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
    $dbmaps->exec("UPDATE maps SET map_on='$mapon' WHERE element_id='$map' AND type='sensors'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    $ch_group = isset($_POST['ch_group']) ? $_POST['ch_group'] : '';
    $ch_grouponoff = isset($_POST['ch_grouponoff']) ? $_POST['ch_grouponoff'] : '';
    $ch_groupon = isset($_POST['ch_groupon']) ? $_POST['ch_groupon'] : '';
    if (($ch_grouponoff == "onoff")){
    $db->exec("UPDATE sensors SET ch_group='$ch_groupon' WHERE id='$ch_group'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
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
<th>Pos</th>	
<th>Name</th>
<th>DB</th>
<th>Adjust</th>
<th>Counters</th>
<th>Alarm</th>
<th>Min/Max</th>
<th>Group</th>
<th>LCD</th>
<th>Charts</th>
<th>Node</th>
<th>MinMax</th>
<th>Map</th>
<th></th>
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
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="position_id" value="<?php echo $a["id"]; ?>" />
	<input type="text" name="position" size="1" maxlength="3" value="<?php echo $a['position']; ?>" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="positionok" value="ok" />
    </form>
    </td>
    
	
    <td class="col-md-2">
<!-- 	<img src="media/ico/TO-220-icon.png"/> -->
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="name_new" size="6" maxlength="30" value="<?php echo $a["name"]; ?>" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="id_name2" value="id_name3"/>
    </form>
    </td>
<?php
	$id_rom3 = str_replace(" ", "_", $a["rom"]);
	$id_rom2 = "$id_rom3.sql";
	$file3 =  "db/$id_rom2";
	if (file_exists($file3) && ( 0 != filesize($file3)))
	{
?>
<td class="col-md-4">
    <span class="label label-success" title="Last update: <?php echo $a["time"] ?>">ok</span>
    <span class="label label-default"><?php $filesize = (filesize("$file3") * .0009765625) * .0009765625; echo round($filesize, 3)."MB" ?></span>
    <span class="label label-default">
	<?php 
	    $rom=$a["rom"];
	    if (strpos($rom,'0x') !== false) {
		$part = explode("0x", $rom);
		 echo strtolower($part[1].'-'.$part[7].''.$part[6].''.$part[5].''.$part[4].''.$part[3].''.$part[2]);
	    } else {
		echo $rom; 
	    }
	?>
    </span>
</td>

<?php  }
else { ?> 
<td class="col-md-1">Error - no sql base</td>
<?php } ?>

<!-- <td class="col-md-1">
    <span class="label label-default">    
	<?php echo  $a["tmp"];?>
    </span>    
</td> -->

    <td class="col-md-1">
    <?php if ($a["device"] != 'remote') { ?>
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="adj" size="2" maxlength="30" value="<?php echo $a["adj"]; ?>" required="" <?php echo $a["device"] == 'remote' ? 'disabled' : ''; ?> />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="adj1" value="adj2"/>
    </form>
    <?php
	}
    ?>
    </td>
    <td class="col-md-1"">
    <?php if (in_array($a['type'], $counters)) { ?>
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="sum" size="2" maxlength="30" value="<?php echo $a["sum"]; ?>" required=""/>
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="sum1" value="sum2"/>
    </form>
    <?php
	}
    ?>
    </td>


    <td >
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="rom" value="<?php echo $a["rom"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="alarm" value="on" <?php echo $a["alarm"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="alarmonoff" value="onoff" />
    </form>
    </td>
    <td class="col-md-2">
    <form action="" method="post" style="display:inline!important;"> 
	<input type="hidden" name="tmp_id" value="<?php echo $a['id']; ?>" />
	<input type="text" name="tmp_min_new" size="3" value="<?php echo $a['tmp_min']; ?>" />
	<input type="text" name="tmp_max_new" size="3" value="<?php echo $a['tmp_max']; ?>" />
	<input type="hidden" name="ok" value="ok" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
    </td>
    <td class="col-md-1">
    <form action="" method="post">
    <select name="ch_groupon" class="form-control input-sm small" onchange="this.form.submit()">
	    <option value="1"  <?php echo $a['ch_group'] == 1 ? 'selected="selected"' : ''; ?>  >1</option>
	    <option value="2"  <?php echo $a['ch_group'] == 2 ? 'selected="selected"' : ''; ?>  >2</option>
	    <option value="3"  <?php echo $a['ch_group'] == 3 ? 'selected="selected"' : ''; ?>  >3</option>
	    <option value="0"  <?php echo $a['ch_group'] == 0 ? 'selected="selected"' : ''; ?>  >none</option>
    </select>
    <input type="hidden" name="ch_grouponoff" value="onoff" />
    <input type="hidden" name="ch_group" value="<?php echo $a['id']; ?>" />
    </form>
    </td>
    <td >
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="lcdid" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="lcdon" value="on" <?php echo $a["lcd"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="lcd" value="lcd" />
    </form>
    </td>

    <td >
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="charts" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="chartson" value="on" <?php echo $a["charts"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="chartsonoff" value="onoff" />
    </form>
    </td>
    <td >
    <?php if ($a["device"] != 'remote') { ?>
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="remote" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="remoteon" value="on" <?php echo $a["remote"] == 'on' ? 'checked="checked"' : ''; ?>   onchange="this.form.submit()" />
	<input type="hidden" name="remoteonoff" value="onoff" />
    </form>
    <?php 
	}
    ?>
    </td>
    <td >
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="minmax" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="minmaxon" value="on" <?php echo $a["minmax"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="minmaxonoff" value="onoff" />
    </form>
    </td>
    
	<td>
	<button class="btn btn-xs btn-success" id="settings-on-map-<?php echo $a['id']; ?>">
		<span class="glypicon glyphicon-plus"></span>
	</button>
	</td>
	<td>
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="rom" value="<?php echo $a["rom"]; ?>" />
	<input type="hidden" name="usun2" value="usun3" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
    </td>
	</tr>
	<!-- display name on map -->
	<tr id="settings-on-map-<?php echo $a['id']; ?>-row" style="display:none">
	<td colspan="15">
	<table>
	<tr>
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
	<tr>
	<td>
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="map" value="<?php echo $row_maps["element_id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="mapon" value="on" <?php echo $row_maps["map_on"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="maponoff" value="onoff" />
    </form>
    </td>
	<td>
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="name_on_map" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="name_on_mapon" value="on" <?php echo $row_maps["display_name"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="name_on_maponoff" value="onoff" />
		</form>
	</td>
	<td><!-- transparent background only for sensors-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="transparent_name_on_map" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="transparent_name_on_mapon" value="on" <?php echo $row_maps["transparent_bkg"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="transparent_name_on_maponoff" value="onoff" />
		</form>
	</td>
	<td><!-- Background color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="background_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="background_color_value" value="<?php echo $row_maps['background_color']?  $row_maps['background_color']: '#5cb85c'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="background_color_set" value="set" />
		</form>
	</td>
	<td><!-- Low color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="low_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="low_color_value" value="<?php echo $row_maps['background_low'] ?  $row_maps['background_low']: '#337ab7'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="low_color_set" value="set" />
		</form>
	</td>
	<td><!-- High color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="high_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="high_color_value" value="<?php echo $row_maps['background_high'] ? $row_maps['background_high']: '#d9534f'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="high_color_set" value="set" />
		</form>
	</td>
	<td><!-- Font color-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="font_color" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="color" data-size="mini"  name="font_color_value" value="<?php echo $row_maps['font_color'] ? $row_maps['font_color']: '#ffffff'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="font_color_set" value="set" />
		</form>
	</td>
	<td><!-- Font size-->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="font_size" value="<?php echo $row_maps["element_id"]; ?>" />
		<input type="text" size="3"  name="font_size_value" value="<?php echo $row_maps['font_size'] ? $row_maps['font_size']: '75'; ?>" onchange="this.form.submit()" />
		<input type="hidden" name="font_size_set" value="set" />
		</form>
	</td>
	<td><!-- Reset to default -->
		<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="reset_map_id" value="<?php echo $row_maps["element_id"]; ?>" />
		<button class="btn btn-xs btn-danger"  name="reset_map_settings" value="reset" onchange="this.form.submit()">
		<span class="glyphicon glyphicon-refresh"></span> Reset</button>
		<input type="hidden" name="reset_map_settings_default" value="default" />
		</form>
	</td>
	<td></td>
	</tr>
	</table>
    </td>
	<!-- koniec -->
</tr>

<?php 

}  

?>
</table>
</div>
</div>
