<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE ch_group!='none' AND (type='gas' OR type='elec' OR type='water')");
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div class="grid-item co">
<div class="panel panel-default">
<div class="panel-heading">Counters </div>

<table class="table table-responsive table-hover table-condensed">
<thead>
<tr>
<th></th>
<th><small>Hour</small></th>
<th><small>Day</small></th>
<th><small>Month</small></th>
<th><small>All</small></th>
<th><small>Current</small></th>
</tr>
</thead>
<tbody>
<?php       
    foreach ($result as $a) { 
?>
<tr>
    <td>
    <?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" alt=""/><?php } ?>
    <?php if($a['device'] == 'remote'){ ?><img src="media/ico/remote.png" alt=""/><?php } ?>
    <?php if($a['device'] == 'usb'){ ?><img src="media/ico/usb-icon.png" alt=""/><?php } ?>
    <?php if($a['device'] == 'gpio'){ ?><img src="media/ico/gpio2.png" alt=""/><?php } ?>
    <?php if($a['type'] == 'gas'){ ?><img src="media/ico/gas-icon.png" alt=""/><?php $units='m3'; $units2='L';} ?>
    <?php if($a['type'] == 'water'){ ?><img src="media/ico/water-icon.png" alt=""/><?php $units='m3'; $units2='L'; } ?>
    <?php if($a['type'] == 'elec'){ ?><img src="media/ico/Lamp-icon.png" alt=""/><?php $units='kWh' ; $units2='W';} ?>
    <small>
	<?php echo str_replace("_"," ","$a[name]"); ?>
    </small>
    </td>
	
	<td>
	    <small>
	    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=hour&single=<?php echo $a['name']?>" class="label label-info" title="<?php echo $units;?>">
		<?php
		$rom=$a['rom'];
		$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
		$rows = $dbs->query("SELECT round(sum(value),4) AS sums FROM def WHERE time >= datetime('now','localtime','-1 hour')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </a>
	    </small>
	</td>
	<td>
	    <small>
	    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=day&single=<?php echo $a['name']?>" class="label label-info" title="<?php echo $units;?>">
		<?php
		$rows = $dbs->query("SELECT round(sum(value),4) AS sums FROM def WHERE time >= datetime('now','localtime','start of day')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </a>
	    </small>
	</td>
	<td>
	    <small>
	    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=month&single=<?php echo $a['name']?>" class="label label-info" title="<?php echo $units;?>">
		<?php
		$rows = $dbs->query("SELECT round(sum(value),4) AS sums FROM def WHERE time >= datetime('now','localtime','start of month')") or die('lol');
		$i = $rows->fetch(); 
		echo $i['sums'];
		?>
	    </a>
	    </small>
	</td>
	<td>
	    <small>
	    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=all&single=<?php echo $a['name']?>" class="label label-danger" title="<?php echo $units;?>">
		<?php
		    echo number_format($a['sum'], 2, '.', ',')." ";
		?>
	    </a>
	    </small>
	</td>
	<td>
	    <small>
	    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=day&single=<?php echo $a['name']?>&mode=2" class="label label-warning" title="<?php echo $units2;?>">
		<?php
		//$rows = $dbs->query("SELECT current AS sums from def where time = (select max(time) from def)") or die('lol');
		//$i = $rows->fetch(); 
		echo number_format($a['current'], 2, '.', ',')." ";
		?>
	    </a>
	    </small>
	</td>
	
</tr>
	

<?php    
    } 
?>
</tbody>
</table> 
</div>
</div>
<?php 
    }
?>
