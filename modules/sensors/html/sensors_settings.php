<?php

$name_new = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$name_id = isset($_POST['name_id']) ? $_POST['name_id'] : '';
$usun_rom_nw = isset($_POST['usun_nw']) ? $_POST['usun_nw'] : '';
$name_new2 = isset($_POST['name_new']) ? $_POST['name_new'] : '';
$name_new=trim($name_new2);


// OK
$gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$new_rom = isset($_POST['new_rom']) ? $_POST['new_rom'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$ip = isset($_POST['ip']) ? $_POST['ip'] : '';



//DEL z bazy
$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
$usun2 = isset($_POST['usun2']) ? $_POST['usun2'] : '';

if(!empty($rom) && ($usun2 == "usun3")) { 
	$db = new PDO('sqlite:dbf/nettemp.db');
	
	//maps settings - first delete
	$to_delete=$db->query("SELECT id FROM sensors WHERE rom='$rom'");
	$to_delete_id=$to_delete->fetchAll();
	$to_delete_id=$to_delete_id[0];
	$db->exec("DELETE FROM maps WHERE element_id='$to_delete_id[id]' AND type='sensors' OR type='gpio'");
	$db->exec("DELETE FROM hosts WHERE rom='$rom'");
	$db->exec("DELETE FROM sensors WHERE rom='$rom'");
	if (file_exists("db/$rom.sql")) {
        unlink("db/$rom.sql");
	}
	//gpio
	if($type='gpio'){
		$db->exec("DELETE FROM gpio WHERE gpio='$gpio' AND rom='$rom'");
	}
	
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();	
} 

// SQLite3 - sekcja usuwanie nie wykrytych czujnikow
$usun_nw2 = isset($_POST['usun_nw2']) ? $_POST['usun_nw2'] : '';
if(!empty($usun_rom_nw) && ($usun_nw2 == "usun_nw3")) {   // 2x post aby potwierdzic multiple submit
	//z bazy
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM sensors WHERE rom='$usun_rom_nw'") or die ($db->lastErrorMsg());
	//plik rrd
	$rep_del_db = str_replace(" ", "_", $usun_rom_nw);
	$name_rep_del_db = "$rep_del_db.rrd";
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
	
	
	
// SQLite - sekcja zmiany nazwy
if (!empty($name_new) && !empty($name_id) && ($_POST['id_name2'] == "id_name3") ){
	$rep = str_replace(" ", "_", $name_new);
	$db = new PDO('sqlite:dbf/nettemp.db');
    $rows = $db->query("SELECT * FROM sensors WHERE name='$rep'") or header("Location: html/errors/db_error.php");
    $row = $rows->fetchAll();
    $c = count($row);
    if ( $c >= "1") { ?>
		<div class="panel panel-warning">
			<div class="panel-heading">Name <?php echo $rep; ?> already exist in database.</div>
			<div class="panel-body">
			<button type="button" class="btn btn-success" onclick="goBack()">Back</button>
			</div>
	    </div>
		<script>
		function goBack() {
			window.history.back();
		}
		</script>
		<?php 
		exit();
		} 
	else {
		$db->exec("UPDATE sensors SET name='$rep' WHERE id='$name_id'") or die ($db->lastErrorMsg());
		if($type='gpio'){
			$db->exec("UPDATE gpio SET name='$rep' WHERE gpio='$gpio'");
		}

	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
} 

$lcd = isset($_POST['lcd']) ? $_POST['lcd'] : '';
$lcdon = isset($_POST['lcdon']) ? $_POST['lcdon'] : '';
$lcdid = isset($_POST['lcdid']) ? $_POST['lcdid'] : '';

if ( $lcd == "lcd"){

    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET lcd='$lcdon' WHERE id='$lcdid'") ;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
} 



	 $del_all = isset($_POST['del_all']) ? $_POST['del_all'] : '';
	 $add_all = isset($_POST['add_all']) ? $_POST['add_all'] : '';
	 
    if (!empty($add_all)) {
    	$db = new PDO('sqlite:dbf/nettemp.db');
    	$db->exec("UPDATE sensors SET '$add_all'='on'") or die ($db->lastErrorMsg());
    	header("location: " . $_SERVER['REQUEST_URI']);
    	exit();
    } 
    
    if (!empty($del_all)){
    	$db = new PDO('sqlite:dbf/nettemp.db');
    	$db->exec("UPDATE sensors SET '$del_all'=''") or die ($db->lastErrorMsg());
    	header("location: " . $_SERVER['REQUEST_URI']);
    	exit();
    }
    
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
    $db->exec("UPDATE sensors SET mail='' WHERE rom='$rom'");
    
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

    $temp_scale = isset($_POST['temp_scale']) ? $_POST['temp_scale'] : '';
    $temp_scaleonoff = isset($_POST['temp_scaleonoff']) ? $_POST['temp_scaleonoff'] : '';
    $temp_scaleon = isset($_POST['temp_scaleon']) ? $_POST['temp_scaleon'] : '';
    if (($temp_scaleonoff == "onoff")){
    	if(empty($temp_scaleon)) {
    		$temp_scaleon='C';
    	}
    $db->exec("UPDATE nt_settings SET value='$temp_scaleon' WHERE option='temp_scale'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    //################
    $minmax_mode = isset($_POST['minmax_mode']) ? $_POST['minmax_mode'] : '';
    $minmax_mode_on = isset($_POST['minmax_mode_on']) ? $_POST['minmax_mode_on'] : '';
    if (($minmax_mode == "onoff")){
    	if(empty($minmax_mode_on)) {
    		$minmax_mode_on='2';
    	}
    $db->exec("UPDATE nt_settings SET value='$minmax_mode_on' WHERE option='minmax_mode'") or die ($db->lastErrorMsg());
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
    //ADD GROUP
    $addch_group = isset($_POST['addch_group']) ? $_POST['addch_group'] : '';
    $addch_grouponoff = isset($_POST['addch_grouponoff']) ? $_POST['addch_grouponoff'] : '';
    $addch_groupon = isset($_POST['addch_groupon']) ? $_POST['addch_groupon'] : '';
    $position_group = isset($_POST['position_group']) ? $_POST['position_group'] : '';
     
    if (($addch_grouponoff == "onoff")){
	$addch_groupon=trim($addch_groupon);
	$name = str_replace(' ', '_', $addch_groupon);
    $db->exec("UPDATE sensors SET ch_group='$name' WHERE id='$addch_group'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE sensors SET position_group='$position_group' WHERE ch_group='$name'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $jg = isset($_POST['jg']) ? $_POST['jg'] : '';
    $jgid = isset($_POST['jgid']) ? $_POST['jgid'] : '';
    $jgon = isset($_POST['jgon']) ? $_POST['jgon'] : '';
    if (($jg == "jg")){
    $db->exec("UPDATE sensors SET jg='$jgon' WHERE id='$jgid'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
?> 


<div class="panel panel-default">
<div class="panel-heading">Sensors
<?php
$atypes=array();
$rows = $db->query("SELECT type FROM types");
$row = $rows->fetchAll();
foreach($row as $types) {
	$atypes[]=$types['type'];
}
?>

<form action="" method="post" style="display:inline!important;"> 	
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="temp_scaleon" data-on="&deg;F" data-off="&deg;C"  value="F" <?php echo $nts_temp_scale == 'F' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="temp_scaleonoff" value="onoff" />
</form>
MinMax mode:
<form action="" method="post" style="display:inline!important;"> 	
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="minmax_mode_on" data-on="min/max" data-off="difference"  value="1" <?php echo $nts_minmax_mode == '1' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="minmax_mode" value="onoff" />
</form>
</div>

<div class="table-responsive">
<script>
	$(document).ready(function(){
		$("button").click(function(event){$("#" + event.target.id + "-row").toggle();});
	});
</script>
<table class="table table-hover table-condensed small" border="0">

<?php
if(!empty($device_type)&&!empty($device_group)) {
	$rows = $db->query("SELECT * FROM sensors WHERE type='$device_type' AND ch_group='$device_group' ORDER BY position ASC");
}
elseif(!empty($device_group)) {
	$rows = $db->query("SELECT * FROM sensors WHERE ch_group='$device_group' ORDER BY position ASC");
}
elseif(!empty($device_type)) {
	$rows = $db->query("SELECT * FROM sensors WHERE type='$device_type' ORDER BY position ASC");
}
elseif(!empty($device_id)) {
	$rows = $db->query("SELECT * FROM sensors WHERE id='$device_id'");
}
else {
	$rows = $db->query("SELECT * FROM sensors ORDER BY position ASC");
}
	
$row = $rows->fetchAll();
?>
<thead>
<tr>
<th>Pos</th>	
<th>Name</th>
<th>DB</th>
<th>Type</th>
<th>Adjust</th>
<th>Alarm / Min / Max</th>
<th>New group</th>
<th>Group</th>
<th>Charts

	 <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="charts" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="charts" />
		<button class="btn btn-xs btn-info "><span class="glyphicon glyphicon-minus"></span> </button>
    </form>

</th>
<th>Node

    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="remote" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="remote" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-minus"></span> </button>
    </form>


</th>
<th>Status Min/Max

    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="minmax" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="minmax" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-minus"></span> </button>
    </form>



</th>
<th>LCD/OLED

 	<form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="lcd" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="lcd" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-minus"></span> </button>
    </form>


</th>
<th>JustGage

 	<form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="jg" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="jg" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-minus"></span> </button>
    </form>

</th>


<th></th>
</tr>
</thead>



<?php 
    foreach ($row as $a) { 	
		$rows_maps = $db->query("SELECT * FROM maps WHERE element_id='$a[id]' AND type='sensors'");
		$row_maps=$rows_maps->fetchAll();
		$row_maps=$row_maps[0];
?>
<tr>
	
	<td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="position_id" value="<?php echo $a["id"]; ?>" />
	<input type="text" name="position" size="1" maxlength="3" value="<?php echo $a['position']; ?>" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="positionok" value="ok" />
    </form>
    </td>
	
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="text" name="name_new" size="10" maxlength="30" value="<?php echo $a["name"]; ?>" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="gpio" value="<?php echo $a["gpio"]; ?>" />
		<input type="hidden" name="type" value="<?php echo $a["type"]; ?>" />
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
	<td class="col-md-0">
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
	<?php  
	}
	else { ?> 
		<td class="col-md-0">Error - no sql base</td>
		<?php } ?>

	<td class="col-md-0">
		<?php if($a['type']=='gpio') { 
			?>
			<a href="index.php?id=device&type=gpio&gpios=<?php echo $a['gpio']?>" class="label label-default" title="<?php if(!empty($a['ip'])){echo "Last IP: ".$a['ip']." GPIO: ".$a['gpio'];} else {echo "GPIO: ".$a['gpio'];}?>"><?php echo $a['type']?></a>
			<?php 
		} else {
			?>
			<span class="label label-default"><?php echo $a['type']?></span>
			<?php 
		}
		?>
	</td>
    
    <td class="col-md-0">
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
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="rom" value="<?php echo $a['rom']; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="alarm" value="on" <?php echo $a["alarm"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="alarmonoff" value="onoff" />
    </form>

    <form action="" method="post" style="display:inline!important;"> 
		<input type="hidden" name="tmp_id" value="<?php echo $a['id']; ?>" />
		<input type="text" name="tmp_min_new" size="3" value="<?php echo $a['tmp_min']; ?>" />
		<input type="text" name="tmp_max_new" size="3" value="<?php echo $a['tmp_max']; ?>" />
		<input type="hidden" name="ok" value="ok" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
    </td>
       
    <!--NEW GROUP-->
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="text" name="position_group" size="1" value="<?php echo $a['position_group']; ?>" />
		<input type="text" name="addch_groupon" size="10" maxlength="30" value="<?php echo $a["ch_group"]; ?>" />
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		<input type="hidden" name="addch_group" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="addch_grouponoff" value="onoff"/>
    </form>
    </td>
    
    
    <td class="col-md-0">
    <form action="" method="post"  class="form-inline">
    <select name="ch_groupon" class="form-control input-sm small" onchange="this.form.submit()" style="width: 100px;" >
		<?php
			$unique1=array();
			$unique1[]='sensors';
			$unique1[]=$a['type'];
				
			$rows2 = $db->query("SELECT ch_group FROM sensors");
			$row2 = $rows2->fetchAll();
			foreach($row2 as $uniq) {
				if(!empty($uniq['ch_group'])&&!in_array($uniq['ch_group'], $atypes)&&$uniq['ch_group']!='none') {
					$unique1[]=$uniq['ch_group'];
				}
			}
			
			$rowu = array_unique($unique1);
			
			foreach ($rowu as $ch_g) { 	
				?>
					<option value="<?php echo $ch_g?>"  <?php echo $ch_g == $a["ch_group"] ? 'selected="selected"' : ''; ?>  ><?php echo $ch_g ?></option>
				<?php 

			}
		?>
		<option value="none"  <?php echo $a['ch_group'] == 'none' ? 'selected="selected"' : ''; ?>  >none</option>
    </select>
    <input type="hidden" name="ch_grouponoff" value="onoff" />
    <input type="hidden" name="ch_group" value="<?php echo $a['id']; ?>" />
    </form>
    </td>

    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;" > 	
		<input type="hidden" name="charts" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="chartson" value="<?php echo $a["charts"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["charts"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["charts"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="chartsonoff" value="onoff" />
    </form>
    </td>
    
    <td class="col-md-0">
    <?php if ($a["device"] != 'remote' && $a["device"] != 'gpio') { ?>
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="remote" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="remoteon" value="<?php echo $a["remote"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["remote"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["remote"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="remoteonoff" value="onoff" />
    </form>
    <?php 
	}
    ?>
    </td>
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="minmax" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="minmaxon" value="<?php echo $a["minmax"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["minmax"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["minmax"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="minmaxonoff" value="onoff" />
    </form>
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="minmax" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="minmaxon" value="<?php echo $a["minmax"] == 'lite' ? 'off' : 'light'; ?>" <?php echo $a["minmax"] == 'light' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["minmax"] == 'lite' ? 'Light' : 'Light'; ?></button>
		<input type="hidden" name="minmaxonoff" value="onoff" />
    </form>
    </td>

    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="lcdid" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="lcdon" value="<?php echo $a["lcd"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["lcd"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["lcd"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="lcd" value="lcd" />
    </form>
    </td>
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="jgid" value="<?php echo $a["id"]; ?>" />
		<button type="submit" name="jgon" value="<?php echo $a["jg"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["jg"] == 'on' ? 'class="btn btn-xs btn-primary"' : 'class="btn btn-xs btn-default"'; ?>>
	    <?php echo $a["jg"] == 'on' ? 'ON' : 'OFF'; ?></button>
		<input type="hidden" name="jg" value="jg" />
    </form>
    </td>
    
	<td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="rom" value="<?php echo $a["rom"]; ?>" />
		<input type="hidden" name="type" value="<?php echo $a["type"]; ?>" />
		<input type="hidden" name="gpio" value="<?php echo $a["gpio"]; ?>" />
		<input type="hidden" name="usun2" value="usun3" />
		<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
    </td>
    
	</tr>

</tr>

<?php 

}  

?>

</table>
</div>
</div>
