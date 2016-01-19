<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE type='gas' OR type='elec' OR type='water'");
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div class="panel panel-default">
<div class="panel-heading">Counters </div>

<table class="table table-responsive table-hover table-condensed">
<thead>
<th></th>
<th><small>Hour</small></th>
<th><small>Day</small></th>
<th><small>Month</small></th>
<th><small>All</small></th>
<th><small>Current</small></th>
</thead>
<tbody>
<?php       
    foreach ($result as $a) { 
?>
<tr>
    <td>
    <?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?>
    <?php if($a['device'] == 'remote'){ ?><img src="media/ico/remote.png" /><?php } ?>
    <?php if($a['device'] == 'usb'){ ?><img src="media/ico/usb-icon.png" /><?php } ?>
    <?php if($a['device'] == 'gpio'){ ?><img src="media/ico/gpio2.png" /><?php } ?>
    <?php if($a['type'] == 'gas'){ ?><img src="media/ico/gas-icon.png" /><?php $units='m3'; } ?>
    <?php if($a['type'] == 'water'){ ?><img src="media/ico/water-icon.png" /><?php $units='m3'; } ?>
    <?php if($a['type'] == 'elec'){ ?><img src="media/ico/Lamp-icon.png" /><?php $units='kWh' ;} ?>
    <small>
	<?php echo str_replace("_"," ","$a[name]"); ?>
    </small>
    </td>
	
	<td>
	    <small>
	    <span class="label label-info">
		<?php
		$rom=$a['rom'];
		$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
		$rows = $dbs->query("SELECT round(sum(value),4) AS sums FROM def WHERE time >= datetime('now','localtime','-1 hour')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
	    </small>
	</td>
	<td>
	    <small>
	    <span class="label label-info">
		<?php
		$rows = $dbs->query("SELECT round(sum(value),4) AS sums FROM def WHERE time >= datetime('now','localtime','start of day')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
	    </small>
	</td>
	<td>
	    <small>
	    <span class="label label-info">
		<?php
		$rows = $dbs->query("SELECT round(sum(value),4) AS sums FROM def WHERE time >= datetime('now','localtime','start of month')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </span>
	    </small>
	</td>
	<td>
	    <small>
	    <span class="label label-danger">
		<?php
		    echo number_format($a['sum'], 2, '.', ',')." ";
		?>
	    </span>
	    </small>
	</td>
	<td>
	    <small>
	    <span class="label label-warning">
		<?php
		$rows = $dbs->query("SELECT current AS sums from def where time = (select max(time) from def)") or die('lol');
		$i = $rows->fetch(); 
		echo number_format($i['sums'], 3, '.', ',')." ";
		?>
	    </span>
	    </small>
	</td>
	
</tr>
	

<?php    
    } 
?>
</tbody>
</table> 
</div>
<?php 
    }
?>