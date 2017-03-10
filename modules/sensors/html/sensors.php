<?php 

$device_group=isset($_GET['device_group']) ? $_GET['device_group'] : '';
$device_type=isset($_GET['device_type']) ? $_GET['device_type'] : '';
$device_id=isset($_GET['device_id']) ? $_GET['device_id'] : '';
$device_menu=isset($_GET['device_menu']) ? $_GET['device_menu'] : '';

$rows2 = $db->query("SELECT id FROM newdev WHERE seen is null") or header("Location: html/errors/db_error.php");
$row2 = $rows2->fetchAll();
$seen = count($row2);

function new_seen($seen){
	if($seen >  0)
	{	
		return '<span class="badge">'.$seen.'</span>';
	} 
}

?>
<p>

<a href="index.php?id=<?php echo $id ?>&type=devices&device_group=<?php echo $ch_g?>&device_menu=settings" ><button class="btn btn-xs btn-default <?php if($device_menu==settings) {echo "active";} ?>">Settings</button></a>
<a href="index.php?id=<?php echo $id ?>&type=devices&device_menu=new_devices" ><button class="btn btn-xs btn-default <?php if($device_menu==new_devices) {echo "active";} ?>">New devices <?php echo new_seen($seen);?></button></a>

</p>



<?php
if($device_menu!='new_devices') {
	
echo '<p>';

$query = $db->query("SELECT ch_group FROM sensors ");
$result_ch_g = $query->fetchAll();
	foreach($result_ch_g as $uniq) {
		if(!empty($uniq['ch_group'])&&$uniq['ch_group']!='none'&&$uniq['ch_group']!='all') {
			$unique[]=$uniq['ch_group'];
		}
	}
	$rowu = array_unique($unique);
	foreach ($rowu as $ch_g) { 	
		?>
		<a href="index.php?id=<?php echo $id ?>&type=devices&device_group=<?php echo $ch_g?>&device_menu=settings" ><button class="btn btn-xs btn-default <?php if($device_group==$ch_g) {echo "active";} ?>"><?php echo $ch_g?></button></a>
		<?php 
	}

echo '</p>';
echo '<p>';

$query = $db->query("SELECT type FROM sensors ");
$result_g = $query->fetchAll();
	foreach($result_g as $uniqg) {
		if(!empty($uniqg['type'])&&$uniqg['type']!='none'&&$uniqg['type']!='all') {
			$uniqueg[]=$uniqg['type'];
		}
	}
	$rowu = array_unique($uniqueg);
	foreach ($rowu as $t_g) { 	
		?>
		<a href="index.php?id=<?php echo $id ?>&type=devices&device_group=<?php echo $device_group?>&device_type=<?php echo $t_g?>&device_menu=settings" ><button class="btn btn-xs btn-default <?php if($device_type==$t_g) {echo "active";} ?>"><?php echo $t_g?></button></a>
		<?php 
	}

echo '</p>';

include("modules/sensors/html/sensors_settings.php"); 
}
if($device_menu=='new_devices') {
    include("modules/sensors/html/sensors_new.php"); 
}
?>

