<?php
session_start();
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");

$hidec = $db->query("SELECT value FROM nt_settings WHERE option='hide_counters'");
$hide_resc = $hidec->fetchAll();
foreach ($hide_resc as $hc) {
    $nts_hide_counters=$hc['value'];
}	 
//hide counters in status
	$hidecounters = isset($_POST['hidecounters']) ? $_POST['hidecounters'] : '';
	$hidecountersstate = isset($_POST['hidecountersstate']) ? $_POST['hidecountersstate'] : '';
	
	if (!empty($hidecounters) && $hidecounters == 'hidecounters'){
		if ($hidecountersstate == 'on') {$hidecountersstate = 'off';
		}elseif ($hidecountersstate == 'off') {$hidecountersstate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE nt_settings SET value='$hidecountersstate' WHERE option='hide_counters'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }	
	 
//logon or logoff
if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {

	$rows = $db->query("SELECT * FROM sensors WHERE ch_group!='none' AND  (type='gas' OR type='elec' OR type='water')");
	
} else { 

	$rows = $db->query("SELECT * FROM sensors WHERE ch_group!='none' AND logon ='on' AND (type='gas' OR type='elec' OR type='water')");
	
	}
	
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div class="grid-item co">
<div class="panel panel-default">
<div class="panel-heading"> 
<div class="pull-left">Counters</div>
<div class="pull-right">
		<div class="text-right">
			 <form action="" method="post" style="display:inline!important;">
					
					<input type="hidden" name="hidecountersstate" value="<?php echo $nts_hide_counters; ?>" />
					<input type="hidden" name="hidecounters" value="hidecounters"/>
					<?php
					if($nts_hide_counters == 'off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($nts_hide_counters == 'on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
				</form>	
		</div>
  </div>
  <div class="clearfix"></div>
</div>

<table class="table table-responsive table-hover table-condensed">
<?php 
if ($nts_hide_counters == 'off') { ?>

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
    <?php if($a['type'] == 'gas'){ ?><img src="media/ico/gas-icon.png" alt=""/><?php $units='m3'; $units2='L';} ?>
    <?php if($a['type'] == 'water'){ ?><img src="media/ico/water-icon.png" alt=""/><?php $units='m3'; $units2='L'; } ?>
    <?php if($a['type'] == 'elec'){ ?><img src="media/ico/Lamp-icon.png" alt=""/><?php $units='kWh' ; $units2='W';} ?>
    <small><span class="label label-default">
	<?php echo str_replace("_"," ","$a[name]"); ?>
    </span></small>
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
}//hide
?>
</tbody>
</table> 
</div>
</div>
<?php 
    }
?>
