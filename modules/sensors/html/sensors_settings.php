<?php

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
    $db->exec("UPDATE settings SET temp_scale='$temp_scaleon' WHERE id='1'") or die ($db->lastErrorMsg());
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
    $db->exec("UPDATE minmax SET state='$minmax_mode_on' WHERE name='mode'") or die ($db->lastErrorMsg());
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
    //ADD GROUP
    $addch_group = isset($_POST['addch_group']) ? $_POST['addch_group'] : '';
    $addch_grouponoff = isset($_POST['addch_grouponoff']) ? $_POST['addch_grouponoff'] : '';
    $addch_groupon = isset($_POST['addch_groupon']) ? $_POST['addch_groupon'] : '';
    if (($addch_grouponoff == "onoff")){
	$addch_groupon=trim($addch_groupon);
	$name = str_replace(' ', '_', $addch_groupon);
    $db->exec("UPDATE sensors SET ch_group='$name' WHERE id='$addch_group'") or die ($db->lastErrorMsg());
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
    
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $statusid = isset($_POST['statusid']) ? $_POST['statusid'] : '';
    $statuson = isset($_POST['statuson']) ? $_POST['statuson'] : '';
    if (($status == "status")){
    $db->exec("UPDATE sensors SET status='$statuson' WHERE id='$statusid'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?> 


<div class="panel panel-default">
<div class="panel-heading">Sensors
<?php
//$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM settings WHERE id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) { 	
    $temp_scale=$a['temp_scale'];
}
$mm = $db->query("SELECT * FROM minmax");
$mm1 = $mm->fetchAll();
foreach($mm1 as $ms){
       if($ms['name']=='mode') {
       	$mm_mode=$ms['state'];
       }
}
?>

<form action="" method="post" style="display:inline!important;"> 	
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="temp_scaleon" data-on="&deg;F" data-off="&deg;C"  value="F" <?php echo $temp_scale == 'F' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="temp_scaleonoff" value="onoff" />
</form>
MinMax mode:
<form action="" method="post" style="display:inline!important;"> 	
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="minmax_mode_on" data-on="min/max" data-off="difference"  value="1" <?php echo $mm_mode == '1' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
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
$counters=array("gas","water","elec");
$rows = $db->query("SELECT * FROM sensors ORDER BY position ASC");
$row = $rows->fetchAll();
?>
<thead>
<tr>
<th>Pos</th>	
<th>Name</th>
<th>DB</th>
<th>Type</th>
<th>Adjust</th>
<th>Counters</th>
<th>Alarm / Min / Max</th>
<th>Charts

	 <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="charts" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="charts" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-minus"></span> </button>
    </form>

</th>
<th>New group</th>
<th>Group</th>
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
<th>LCD

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
<th>Sensors

 	<form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="add_all" value="status" />
		<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="del_all" value="status" />
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

	<?php  }
	else { ?> 
	<td class="col-md-0">Error - no sql base</td>
	<?php } ?>

	<td class="col-md-0"><span class="label label-default"><?php echo $a['type']?></span></td>

	
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
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;" > 	
		<input type="hidden" name="charts" value="<?php echo $a["id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="chartson" value="on" <?php echo $a["charts"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="chartsonoff" value="onoff" />
    </form>
    </td>
    
    
    <!--NEW GROUP-->
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
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
			$rows = $db->query("SELECT ch_group FROM sensors");
			$row = $rows->fetchAll();
			foreach($row as $uniq) {
				if(!empty($uniq['ch_group'])&&$uniq['ch_group']!='none') {
					$unique[]=$uniq['ch_group'];
				}
			}
			$rowu = array_unique($unique);
			foreach ($rowu as $ch_g) { 	
				?>
				    <option value="<?php echo $ch_g?>"  <?php echo $ch_g == $a["ch_group"] ? 'selected="selected"' : ''; ?>  ><?php echo $ch_g ?></option>
				<?php 

			}
			?>
				<option value=""  <?php echo $a['ch_group'] == '' ? 'selected="selected"' : ''; ?>  >none</option>
    </select>
    <input type="hidden" name="ch_grouponoff" value="onoff" />
    <input type="hidden" name="ch_group" value="<?php echo $a['id']; ?>" />
    </form>
    </td>


    
    <td class="col-md-0">
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
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="minmax" value="<?php echo $a["id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="minmaxon" value="on" <?php echo $a["minmax"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="minmaxonoff" value="onoff" />
    </form>
    </td>

    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="lcdid" value="<?php echo $a["id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="lcdon" value="on" <?php echo $a["lcd"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="lcd" value="lcd" />
    </form>
    </td>
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="jgid" value="<?php echo $a["id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="jgon" value="on" <?php echo $a["jg"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="jg" value="jg" />
    </form>
    </td>
    
    <td class="col-md-0">
    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="statusid" value="<?php echo $a["id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="statuson" value="on" <?php echo $a["status"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" />
		<input type="hidden" name="status" value="status" />
    </form>
    </td>  
    
	<td class="col-md-0">
    <form action="" method="post" style="display:inline!important;">
		<input type="hidden" name="rom" value="<?php echo $a["rom"]; ?>" />
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
