<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE type='gas' OR type='elec' OR type='water'");
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div id="sensor_status">
<div class="grid-item">

<div class="panel panel-default">
<div class="panel-heading">Counters - hour day month all</div>

<table class="table table-hover">
<tbody>
<?php       
    foreach ($result as $a) { 
?>
<tr>
    <td>
    <?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?>
    <?php if($a['device'] == 'remote'){ ?><img src="media/ico/remote.png" /><?php } ?>
    </td>
    <td>
	<?php if($a['type'] == 'gas'){ ?><img src="media/ico/gas-icon.png" /><?php $units='m3'; } ?>
	<?php if($a['type'] == 'water'){ ?><img src="media/ico/water-icon.png" /><?php $units='m3'; } ?>
	<?php if($a['type'] == 'elec'){ ?><img src="media/ico/Lamp-icon.png" /><?php $units='kWh' ;} ?>
	<?php if($a['type'] == 'wat'){ ?><img src="media/ico/Lamp-icon.png" /><?php $units='W' ;} ?>
    </td>
    <td><?php echo $a['name'] ?> </td>
	<td>
	<?php
	$rom=$a['rom'];
	$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
	$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def WHERE time BETWEEN datetime('now','-1 hour') AND datetime('now')") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums'];
	?>
	</td>
	<td>
	<?php
	$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def WHERE time >= date('now','start of day')") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums'];
	?>
	</td>
	<td>
	<?php
	$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def WHERE time >= date('now','start of month')") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums'];
	?>
	</td>
	<td>
	<?php
	$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums']." ".$units;
	?>
	</td>
	
</tr>
	

<?php    
    } 
?>
</tbody>
</table> 
</div>
</div>
</div>

<?php 
    }
?>