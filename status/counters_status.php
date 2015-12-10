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
<div class="panel-heading">Counters </div>

<table class="table table-responsive table-hover table-condensed">
<thead>
<th></th>
<th></th>
<th></th>
<th>Hour</th>
<th>Day</th>
<th>Month</th>
<th>All</th>
<th>Current</th>
</thead>
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
    </td>
    <td>
	<?php echo $a['name'] ?> 
    </td>
	
	<td>
	    <span class="label label-info">
		<?php
		$rom=$a['rom'];
		$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
		$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def WHERE time BETWEEN datetime('now','-1 hour') AND datetime('now')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
	</td>
	<td>
	    <span class="label label-info">
		<?php
		$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def WHERE time >= date('now','start of day')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
	</td>
	<td>
	    <span class="label label-info">
		<?php
		$rows = $dbs->query("SELECT round(sum(value),1) AS sums FROM def WHERE time >= date('now','start of month')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
	</td>
	<td>
	    <span class="label label-danger">
		<?php
		//$rows = $dbs->query("SELECT sum AS sums FROM def WHERE id=1") or die('lol');
		//$i = $rows->fetch(); 
		//echo $i['sums']." ";
		echo $a[sum];
		?>
	    </span>
	</td>
	<td>
	    <span class="label label-warning">
		<?php
		$rows = $dbs->query("SELECT current AS sums from def where time = (select max(time) from def)") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
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