<?php
 	 $h_map = isset($_POST['h_map']) ? $_POST['h_map'] : '';
    $h_maponoff = isset($_POST['h_maponoff']) ? $_POST['h_maponoff'] : '';
    $h_mapon = isset($_POST['h_mapon']) ? $_POST['h_mapon'] : '';
    if (($h_maponoff == "onoff")){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE maps SET map_on='$h_mapon' WHERE element_id='$h_map' AND type='hosts'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }
    $h_icon_on_map = isset($_POST['h_icon_on_map']) ? $_POST['h_icon_on_map'] : '';
	$h_icon_on_map_set = isset($_POST['h_icon_on_map_set']) ? $_POST['h_icon_on_map_set'] : '';
    $h_icon_on_map_name = isset($_POST['h_icon_on_map_name']) ? $_POST['h_icon_on_map_name'] : '';
	if ($h_icon_on_map_set == 'set') {
		print_r("UPDATE maps SET icon='$h_icon_on_map_name' WHERE element_id='$h_icon_on_map' AND type='hosts'");
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE maps SET icon='$h_icon_on_map_name' WHERE element_id='$h_icon_on_map' AND type='hosts'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	
    ?>
    
    
<div class="panel panel-default">
<div class="panel-heading">Hosts</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead>
<tr>
<th>Name</th>
<th>View</th>
<th>Icon</th>
</tr>
</thead>


<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from hosts ORDER BY position ASC");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {  
	$rows=$db->query("SELECT * FROM maps WHERE element_id='$a[id]' AND type='hosts'");//always one record
	$h=$rows->fetchAll();
	$h=$h[0];//extracting from array
?>
<tr>
 	<td class="col-md-1"><?php echo str_replace("host_", "",$a["name"]);?>
 	</td>
	<td class="col-md-3">
	<form action="" method="post" style="display:inline!important;"> 	
	    <input type="hidden" name="h_map" value="<?php echo $a["id"]; ?>" />
	    <input type="checkbox" data-toggle="toggle" data-size="mini"  name="h_mapon" value="on" <?php echo $h["map_on"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	    <input type="hidden" name="h_maponoff" value="onoff" />
	</form>
	</td>
	<td class="col-md-8">
	<form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="h_icon_on_map" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="h_icon_on_map_set" value="set" />
		<select id="h_icon_on_map_name" data-size="mini" name="h_icon_on_map_name" onchange="this.form.submit()">
				<option value='' <?php echo $h['icon'] == '' ? 'selected="selected"' : ''; ?>>default</option>
				<option value='Host' <?php echo $h['icon'] == 'Host' ? 'selected="selected"' : ''; ?>>Host</option>
				<option value='Camera' <?php echo $h['icon'] == 'Camera' ? 'selected="selected"' : ''; ?>>Camera</option>
				<option value='Printer' <?php echo $h['icon'] == 'Printer' ? 'selected="selected"' : ''; ?>>Printer</option>
				<option value='Raspberry' <?php echo $h['icon'] == 'Raspberry' ? 'selected="selected"' : ''; ?>>Raspberry</option>
		</select>
	</form>
	</td>
</tr>
	
<?php 
    }
?>
</table>
</div>
</div>