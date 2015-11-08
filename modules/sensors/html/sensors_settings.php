<?php	
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

    $alarm = isset($_POST['alarm']) ? $_POST['alarm'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    if ( !empty($alarm) && ($_POST['alarmonoff'] == "onoff")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='$alarm' WHERE name='$name'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
    elseif (empty($alarm) && ($_POST['alarmonoff'] == "onoff")){
    $db->exec("UPDATE sensors SET alarm='' WHERE name='$name'") or die ($db->lastErrorMsg());
    unlink("tmp/mail/$name.mail");
    unlink("tmp/mail/hour/$name.mail");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $charts = isset($_POST['charts']) ? $_POST['charts'] : '';
    $chartsonoff = isset($_POST['chartsonoff']) ? $_POST['chartsonoff'] : '';
    $chartson = isset($_POST['chartson']) ? $_POST['chartson'] : '';
    if (($_POST['chartsonoff'] == "onoff")){
    $db->exec("UPDATE sensors SET charts='$chartson' WHERE id='$charts'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?> 


<div class="panel panel-info">
<div class="panel-heading">Sensors</div>

<div class="table-responsive">
<table class="table table-hover">

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
?>
<thead>
<tr>
<th>Name</th>
<th>id</th>
<th>Size</th>
<th>Status</th>
<th>Value</th>
<th>Adjust</th>
<th>Alarm</th>
<th>Min/Max</th>
<th>LCD</th>
<th>Charts</th>
<th></th>
</tr>
</thead>



<?php 
    foreach ($row as $a) { 	
?>
<tr>
    <td class="col-md-3">
	<img src="media/ico/TO-220-icon.png" />
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="name_new" size="12" maxlength="30" value="<?php echo $a["name"]; ?>" />
	<button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="id_name2" value="id_name3"/>
    </form>
    </td>

    <td class="col-md-1">
	<?php echo  $a["rom"] ;?>
    </td>

<?php
	$id_rom3 = str_replace(" ", "_", $a["rom"]);
	$id_rom2 = "$id_rom3.sql";
	$file3 =  "db/$id_rom2";
	if (file_exists($file3) && ( 0 != filesize($file3)))
	{
?>
<td class="col-md-1"><?php $filesize = (filesize("$file3") * .0009765625) * .0009765625; echo round($filesize, 3) ?>MB</td>
<td class="col-md-1"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-ok"></span> </button></td>

<?php   }
else { ?> 
<td class="col-md-1">Error - no sql base</td>
<?php } ?>

    <td class="col-md-1">
	<?php echo  $a["tmp"];?>
    </td>

    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;">
	<input type="text" name="adj" size="2" maxlength="30" value="<?php echo $a["adj"]; ?>" required="" />
	<button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button>
	<input type="hidden" name="name_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="adj1" value="adj2"/>
    </form>
    </td>

    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="name" value="<?php echo $a["name"]; ?>" />
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
	<button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
    </td>

    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="lcdid" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="lcdon" value="on" <?php echo $a["lcd"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="lcd" value="lcd" />
    </form>
    </td>

    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;"> 	
	<input type="hidden" name="charts" value="<?php echo $a["id"]; ?>" />
	<input type="checkbox" data-toggle="toggle" data-size="mini"  name="chartson" value="on" <?php echo $a["charts"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	<input type="hidden" name="chartsonoff" value="onoff" />
    </form>
    </td>

    <td class="col-md-1">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="usun_czujniki" value="<?php echo $a["rom"]; ?>" />
	<input type="hidden" name="usun2" value="usun3" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
    </td>
</tr>
<?php 

}  

?>
</table>
</div>
</div>
