<div class="grid-item ss">
<div class="panel panel-default">
<div class="panel-heading">Sensors</div>
<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");

$rows = $db->query("SELECT * FROM settings WHERE id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $temp_scale=$a['temp_scale'];
}
$rows_meteo = $db->query("SELECT normalized,pressure FROM meteo WHERE id='1'");
$row_meteo = $rows_meteo->fetchAll();
foreach ($row_meteo as $a) {
    $normalized=$a['normalized'];
	$pressure=$a['pressure'];
}

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

    $sth = $db->prepare("SELECT * FROM sensors WHERE position !=0 AND type!='elec' ORDER BY position ASC");
    $sth->execute();
    $result = $sth->fetchAll(); ?>
    <table class="table table-hover table-condensed small">
    <tbody>
<?php       
    foreach ($result as $a) {
	$name1=$a['name'];
	$name = str_replace("_", " ", $name1);
	$min='';
	$max='';
	$label='';
	$updo='';
	$mm='';

		if($a['device'] == 'wireless'){ $device='<img src="media/ico/wifi-circle-icon.png" alt="" title="Wireless"/>';}
		if($a['device'] == 'remote'){ $device='<img src="media/ico/remote.png" alt="" title="Remote NODE"/>';}
		if($a['device'] == 'usb'){ $device='<img src="media/ico/usb-icon.png" alt="" title="USB"/>';}
		if($a['device'] == 'rpi'){ $device='<img src="media/ico/raspberry-icon.png" alt="" title="Raspberry Pi"/>';}
		if($a['device'] == 'banana'){ $device='<img src="media/ico/banana-icon.png" alt="" title="Banana Pi"/>';}
		if($a['device'] == 'gpio'){ $device='<img src="media/ico/gpio2.png" alt="" title="GPIO"/>';}
		if($a['device'] == 'i2c'){ $device='<img src="media/ico/i2c_1.png" alt="" title="I2C"/>';}
		if($a['device'] == 'snmp'){ $device='<img src="media/ico/snmp-icon.png" alt="" title=SNMP"/>';}
		if(empty($a['device'])) { $device='<img src="media/ico/1wire.png" alt="" title="1wire"/>';}

		if($a['type'] == 'lux'){ $unit='lux'; $type='<img src="media/ico/sun-icon.png" alt="" title="Lux"/>';} 
		if($a['type'] == 'temp' && $temp_scale == 'C'){ $unit='&deg;C'; $type='<img src="media/ico/temp2-icon.png" alt="" title="Temperature"/>';}
		if($a['type'] == 'temp' && $temp_scale == 'F'){ $unit='&deg;F'; $type='<img src="media/ico/temp2-icon.png" alt="" title="Temperature"/>';}
		if($a['type'] == 'humid'){ $unit='%'; $type='<img src="media/ico/rain-icon.png" alt="" title="Humidity"/>';}
		if($a['type'] == 'press'){ $unit='hPa'; $type='<img src="media/ico/Science-Pressure-icon.png" alt="" title="Pressure"/>';}		
		if($a['type'] == 'water'){ $unit='m3'; $type='<img src="media/ico/water-icon.png" alt="" title="Water"/>';}		
		if($a['type'] == 'gas'){ $unit='m3'; $type='<img src="media/ico/gas-icon.png" alt="" title="Gas"/>';}		
		if($a['type'] == 'elec'){ $unit='kWh'; $type='<img src="media/ico/Lamp-icon.png" alt="" title="Electricity"/>';}		
		if($a['type'] == 'watt'){ $unit='W'; $type='<img src="media/ico/watt.png" alt="Watt" title="Watt"/>';}		
		if($a['type'] == 'volt'){ $unit='V'; $type='<img src="media/ico/volt.png" alt="Volt" title="Volt"/> ';}		
		if($a['type'] == 'amps'){ $unit='A'; $type='<img src="media/ico/amper.png" alt="Amps" title="Amps"/> ';}		
		if($a['type'] == 'dist'){ $unit='cm'; $type='';}	
		if($a['type'] == 'trigger'){ $unit=''; $type='<img src="media/ico/alarm-icon.png" alt="Trigger" title="Trigger"/>';}	
		
		//glyphicon glyphicon-exclamation-sign	
		
		//if($a['tmp'] > $a['tmp_5ago']) { $updo='<img src="media/ico/Up-3-icon.png"/>';}
		//if($a['tmp'] < $a['tmp_5ago']) { $updo='<img src="media/ico/Down-3-icon.png" />';}
		if($a['tmp'] > $a['tmp_5ago']) { $updo='<span class="label label-danger" title='.$a['tmp_5ago'].'><span class="glyphicon glyphicon-arrow-up"></span></span>';}
		if($a['tmp'] < $a['tmp_5ago']) { $updo='<span class="label label-info" title='.$a['tmp_5ago'].'><span class="glyphicon glyphicon-arrow-down"></span></span>';}
		
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max'])) { 
		    $mm='e'; 
		    $max="max ".$a['tmp_max'];
		    if($a['type'] == 'temp'){ $type='<img src="media/ico/temp_high.png" alt=""/>';}
		    $label='danger';
		}
		if($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min'])) { 
		    $mm='e'; 
		    $min="min ".$a['tmp_min'];
		    if($a['type'] == 'temp'){ $type='<img src="media/ico/temp_low.png" alt=""/>';}
		    $label='danger';
		}
?>

		    <tr>
			<td>
			    <?php echo $device." ".$type." ".$name;?>
			</td>
			<td>
			    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=day&single=<?php echo $a['name']?>" title="Last update: <?php echo $a['time']?>"
			    <?php if(($a['tmp'] == 'error') || ($label=='danger')) {
				    echo 'class="label label-danger"';
				    } 
				    else {
					echo 'class="label label-success"';
				    } ?>
				>
				<?php
				    if (is_numeric($a['tmp']) && $a['type']=='elec' || $a['type']=='gas' || $a['type']=='water' )  {
					echo 	number_format($a['tmp'], 3, '.', ',')." ".$unit." ".$max." ".$min;
				    } 
				    elseif (is_numeric($a['tmp']) && $a['type']=='volt' || $a['type']=='amps' || $a['type']=='watt' )  {
					echo 	number_format($a['tmp'], 2, '.', ',')." ".$unit." ".$max." ".$min;
				    } 
				    elseif (is_numeric($a['tmp'])) { 
					echo 	number_format($a['tmp'], 1, '.', ',')." ".$unit." ".$max." ".$min;
				    }
				    else {
					 echo $a['tmp']." ".$unit." ".$max." ".$min;
				    }
				?>	
			    </span>
			    </a>
			</td>
			<td>
		    	    <?php echo $updo; ?>
			</td>
		    </tr>
			<?php if ($normalized == "on" && $pressure == $a['id']): ?>
				<tr>
					<td></td>
					<td><span 
				<?php if(($a['tmp'] == 'error') || ($label=='danger')) {
				    echo 'class="label label-danger"';
				    } 
				    else {
					echo 'class="label label-success"';
				    } 
					?>
					>
					<?php
						require_once("Meteo.class.php");
						$m=new Meteo();
						echo number_format($m->getCisnienieZnormalizowane(),2,'.','').' hPa npm';
						?>
					</span>
					</td>
					<td>
		    	    <?php echo $updo; ?>
					</td>
				</tr>
			<?php endif; ?>
<?php
    unset($mm);
    unset($max);
    unset($min);
    unset($label);
    unset($updo);
    unset($device);
    unset($unit);
     } 
?>
    </tbody>
    </table> <?php
?>
</div>
</div>
