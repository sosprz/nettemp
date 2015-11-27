<div id="sensor_status">
<div class="grid-item">
<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE type='gas' OR type='elec' OR type='water'");
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div class="panel panel-default">
<div class="panel-heading">Counters</div>

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
	<?php if($a['type'] == 'gas'){ ?><img src="media/ico/gas-icon.png" /><?php } ?>
	<?php if($a['type'] == 'water'){ ?><img src="media/ico/water-icon.png" /><?php } ?>
	<?php if($a['type'] == 'elec'){ ?><img src="media/ico/Lamp-icon.png" /><?php } ?>
    </td>
    <td><?php echo $a['name'] ?> </td>
    <?php if($a['type'] == 'gas') { ?>
	<td><?php
	$rom=$a['rom'];
	$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
	$rows = $dbs->query("SELECT sum(value) AS sums FROM def") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums']." m3";
	?> </td>
    <?php } ?>
    <?php if($a['type'] == 'water') { ?>
	<td><?php 
	$rom=$a['rom'];
	$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
	$rows = $dbs->query("SELECT sum(value) AS sums FROM def") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums']." m3";
	?> </td>
    <?php } ?>
    <?php if($a['type'] == 'elec') { ?>
	<td><?php 
	$rom=$a['rom'];
	$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
	$rows = $dbs->query("SELECT sum(value) AS sums FROM def") or die('lol');
	$i = $rows->fetch(); 
	echo $i['sums']." kWh";
	?> </td>
    <?php } ?>
    
    
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