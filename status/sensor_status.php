<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();

$rows_meteo = $db->query("SELECT normalized,pressure FROM meteo WHERE id='1'");
$row_meteo = $rows_meteo->fetchAll();
foreach ($row_meteo as $a) {
    $normalized=$a['normalized'];
	$pressure=$a['pressure'];
}
$rows = $db->query("SELECT * FROM settings WHERE id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $temp_scale=$a['temp_scale'];
}

$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);

if ($numRows == 0 ) { ?>
<div class="grid-item ss">
<div class="panel panel-default">
<div class="panel-heading">Sensors</div>
<div class="panel-body">
Go to device scan!
<a href="index.php?id=devices&type=scan" class="btn btn-success">GO!</a>
</div>
</div>
</div>
<?php
    }

    $sth = $db->prepare("SELECT * FROM sensors WHERE position !=0 AND type!='elec' AND status ='on' ORDER BY position ASC");
    $sth->execute();
    $result = $sth->fetchAll(); 
    $numsen = count($result);
    if ($numsen >= 1 ){
    ?>
    <div class="grid-item ss">
	<div class="panel panel-default">
	<div class="panel-heading">Sensors</div>
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
		
		
		foreach($result_t as $ty){
       	if($ty['type']==$a['type']){
     			if($temp_scale == 'F'){
       			$unit=$ty['unit2'];
       		} else {
       			$unit=$ty['unit'];
       		}
       		$type="<img src=\"".$ty['ico']."\" alt=\"\" title=\"".$ty['title']."\"/>";
       	}   
		}
		

		//glyphicon glyphicon-exclamation-sign	
		
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
				<?php $old_read=86400;
				    if (($a['tmp'] == 'error') || ($label=='danger') || strtotime($a['time'])<(time()-(7*$old_read))){
					echo 'class="label label-danger"';
				    } elseif (strtotime($a['time'])<(time()-$old_read)){
					echo 'class="label label-warning"';
				    }else{
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
    </table> 
	</div>
	</div>
<?php 
	}
?>
