<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
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
	//display name on map
	$name_on_map = isset($_POST['name_on_map']) ? $_POST['name_on_map'] : '';
    $name_on_maponoff = isset($_POST['name_on_maponoff']) ? $_POST['name_on_maponoff'] : '';
    $name_on_mapon = isset($_POST['name_on_mapon']) ? $_POST['name_on_mapon'] : '';
    if (($name_on_maponoff == "onoff")){
    $db->exec("UPDATE gpio SET display_name='$name_on_mapon' WHERE gpio='$name_on_map'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	//control on map
	$control_on_map = isset($_POST['control_on_map']) ? $_POST['control_on_map'] : '';
    $control_on_maponoff = isset($_POST['control_on_maponoff']) ? $_POST['control_on_maponoff'] : '';
    $control_on_mapon = isset($_POST['control_on_mapon']) ? $_POST['control_on_mapon'] : '';
    if (($control_on_maponoff == "onoff")){
    $db->exec("UPDATE gpio SET control_on_map='$control_on_mapon' WHERE gpio='$control_on_map'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading">Status</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">


<?php 
$db = new PDO('sqlite:dbf/nettemp.db'); 
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
<th title='View name on map'>Name on map</th>
<th title='Control on map'>Control</th>
</tr>
</thead>

<?php foreach ($row as $b) {?>

<tr>

	
	<td class="col-md-1">
    		<form action="" method="post" style="display:inline!important;">
        	<input type="hidden" name="position_id" value="<?php echo $b["id"]; ?>" />
        	<input type="text" name="position" size="1" maxlength="3" value="<?php echo $b['position']; ?>" />
        	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
        	<input type="hidden" name="positionok" value="ok" />
    		</form>
	</td>
	<td class="col-md-1">
		<a href="index.php?id=devices&type=gpio&gpios=<?php echo $b['gpio']?>" class="btn btn-xs btn-success ">GPIO <?php echo $b['gpio']?></a>
	</td>
	<td class="col-md-1">
                <span class="label label-default"><?php echo $b["name"]; ?></span>
        </td>


	<td class="col-md-1">
                <span class="label label-default"><?php echo $b["mode"]; ?></span>
        </td>

	<td class="col-md-1"> 
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
	<!-- name on map  !!!not valid for humid and dist -->
	<td class="col-md-1">
		<?php if($b['mode'] != 'dist' && $b['mode'] != 'humid') : ?>
    	<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="name_on_map" value="<?php echo $b["gpio"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="name_on_mapon" value="on" <?php echo $b["display_name"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
		<input type="hidden" name="name_on_maponoff" value="onoff" />
		</form>
		<?php endif; ?>
	</td>
	<td class="col-md-1">
		<?php if($b['mode'] != 'dist' && $b['mode'] != 'humid') : ?>
    	<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="control_on_map" value="<?php echo $b["gpio"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="control_on_mapon" value="on" <?php echo $b["control_on_map"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
		<input type="hidden" name="control_on_maponoff" value="onoff" />
		</form>
		<?php endif; ?>
	</td>

<?php } ?>

</tr>
</table> </div> </div>

