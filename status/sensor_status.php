<div id="sensor_status">
<div class="grid-item">
<div class="panel panel-default">
<div class="panel-heading">Sensors</div>
<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { ?>
<div class="panel-body">
Go to device scan!
<a href="index.php?id=devices&type=scan" class="btn btn-success">GO!</a>
</div>
<?php
    }

    $sth = $db->prepare("select * from sensors");
    $sth->execute();
    $result = $sth->fetchAll(); ?>
    <table class="table table-hover table-condensed">
    <tbody>
<?php       
    foreach ($result as $a) {
	$name1=$a['name'];
	$name = str_replace("_", " ", $name1);

		if($a['device'] == 'wireless'){ $device='<img src="media/ico/wifi-circle-icon.png"/>';}
		if($a['device'] == 'remote'){ $device='<img src="media/ico/remote.png" />';}

		if($a['type'] == 'lux'){ $unit='lux'; $type='<img src="media/ico/sun-icon.png"/>';} 
		if($a['type'] == 'temp'){ $unit='C'; $type='<img src="media/ico/temp2-icon.png"/>';}
		if($a['type'] == 'humid'){ $unit='%'; $type='<img src="media/ico/rain-icon.png"/>';}
		if($a['type'] == 'press'){ $unit='Pa'; $type='<img src="media/ico/Science-Pressure-icon.png"/>';}		
		if($a['type'] == 'water'){ $unit='m3'; $type='<img src="media/ico/water-icon.png"/>';}		
		if($a['type'] == 'gas'){ $unit='m3'; $type='<img src="media/ico/gas-icon.png"/>';}		
		if($a['type'] == 'elec'){ $unit='kWh'; $type='<img src="media/ico/Lamp-icon.png"/>';}		
		if($a['type'] == 'watt'){ $unit='W'; $type='<img src="media/ico/Lamp-icon.png"/>';}		
		
		if($a['tmp'] > $a['tmp_5ago']) { $updo='<img src="media/ico/Up-3-icon.png"/>';}
		if($a['tmp'] < $a['tmp_5ago']) { $updo='<img src="media/ico/Down-3-icon.png" />';}

		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { 
		    $mm='e'; 
		    $max=max." ".$a['tmp_max'];
		    if($a['type'] == 'temp'){ $type='<img src="media/ico/temp_high.png"/>';}
		}
		if($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { 
		    $mm='e'; 
		    $min=min." ".$a['tmp_min'];
		    if($a['type'] == 'temp'){ $type='<img src="media/ico/temp_low.png"/>';}
		}
?>

		    <tr <?php echo !empty($mm) ? 'class="danger"' : ''?>>
			<td>
			    <?php echo $device;?>
			</td>
			<td>
			    <?php echo $type;?>
			<td>
				<?php echo $name;?>
			</td>
			<td>
			    <?php echo $a['tmp'] == 'error' ? '<span class="label label-danger">' : '<span class="label label-success">' ?>
			    
				<?php echo $a['tmp']." ".$unit." ".$max.$min;?>
			    </span>
			</td>
			<td>
		    	    <?php echo $updo; ?>
			</td>
		    </tr>
<?php
    unset($mm);
    unset($max);
    unset($min);
     } 
?>
    </tbody>
    </table> <?php
?>
</div>
</div>
</div>