<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if(!isset($NT_SETTINGS)){ include($root."/modules/settings/nt_settings.php"); }
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE minmax='on' ORDER BY position ASC");
$result = $rows->fetchAll();
$numRows = count($result);

//hide minmax in status
	$hidemm = isset($_POST['hidemm']) ? $_POST['hidemm'] : '';
	$hidemmstate = isset($_POST['hidemmstate']) ? $_POST['hidemmstate'] : '';
	
	if (!empty($hidemm) && $hidemm == 'hidemm'){
		if ($hidemmstate == 'on') {$hidemmstate = 'off';
		}elseif ($hidemmstate == 'off') {$hidemmstate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE nt_settings SET value='$hidemmstate' WHERE option='hide_minmax'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }	

if ( $numRows > '0' ) { ?>
<div class="grid-item mm">
<div class="panel panel-default">
<div class="panel-heading">
<div class="pull-left">Sensors Min Max</div>
<div class="pull-right">
		<div class="text-right">
			 <form action="" method="post" style="display:inline!important;">
					
					<input type="hidden" name="hidemmstate" value="<?php echo $nts_hide_minmax; ?>" />
					<input type="hidden" name="hidemm" value="hidemm"/>
					<?php
					if($nts_hide_minmax =='off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($nts_hide_minmax =='on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
				</form>	
		</div>
  </div>
  <div class="clearfix"></div>
</div>

<div class="table-responsive">
<table class="table table-hover table-condensed">
<tbody>
<?php
if ($nts_hide_minmax == 'off') { ?>

<tr>
   <th></th>
   
<?php

 if($nts_minmax_mode != '1') {
     ?>
    <th>Hour</th>
    <?php
 }
 ?>
    <th>Day</th>
    <th>Week</th>
    <th>Month</th>
</tr>
<?php
foreach ($result as $a) {

$rom=$a['rom'];
$minmax_full=$a['minmax'];
$file=$rom .".sql";


    if($minmax_full == 'on') { 

    $db1 = new PDO("sqlite:$root/db/$file");
    $h = $db1->query("select min(value) AS hmin, max(value) AS hmax from def WHERE time BETWEEN datetime('now','localtime','-1 hour') AND datetime('now','localtime')") or die('hour');
    $h = $h->fetch(); 
    $d = $db1->query("select min(value) AS dmin, max(value) AS dmax from def WHERE time BETWEEN datetime('now','localtime','-1 day') AND datetime('now','localtime') ") or die('day');
    $d = $d->fetch(); 
    $w = $db1->query("select min(value) AS wmin, max(value) AS wmax from def WHERE time BETWEEN datetime('now','localtime','-7 day') AND datetime('now','localtime') ") or die('week');
    $w = $w->fetch(); 
    $m = $db1->query("select min(value) AS mmin, max(value) AS mmax from def WHERE time BETWEEN datetime('now','localtime','-1 months') AND datetime('now','localtime') ") or die('month');
    $m = $m->fetch();
	} 
	
	/*
	
	elseif ($minmax_full == 'light') {

	$db1 = new PDO("sqlite:$root/db/$file");
    $h = $db1->query("select min(value) AS hmin, max(value) AS hmax from def WHERE time BETWEEN datetime('now','localtime','-1 hour') AND datetime('now','localtime')") or die('hour');
    $h = $h->fetch(); 
    $d = $db1->query("select min(value) AS dmin, max(value) AS dmax from def WHERE time BETWEEN datetime('now','localtime','-1 day') AND datetime('now','localtime') AND rowid % 60=0") or die('day');
    $d = $d->fetch(); 
    $w = $db1->query("select min(value) AS wmin, max(value) AS wmax from def WHERE time BETWEEN datetime('now','localtime','-7 day') AND datetime('now','localtime') AND rowid % 240=0") or die('week');
    $w = $w->fetch(); 
    $m = $db1->query("select min(value) AS mmin, max(value) AS mmax from def WHERE time BETWEEN datetime('now','localtime','-1 months') AND datetime('now','localtime') AND rowid % 480=0") or die('month');
    $m = $m->fetch();
		
	}
	*/

    
    if($nts_minmax_mode == '1') { 
    if ($a['type'] == 'elec' || $a['type'] == 'water' || $a['type'] == 'gas') { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo number_format($d['dmin'], 3, '.', '')?></span><span class="label label-warning"><?php echo number_format($d['dmax'], 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($w['wmin'], 3, '.', '')?></span><span class="label label-warning"><?php echo number_format($w['wmax'], 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($m['mmin'], 3, '.', '')?></span><span class="label label-warning"><?php echo number_format($m['mmax'], 3, '.', '')?></span></td>
    </tr>
    <?php
    } elseif ($a['type'] == 'volt' || $a['type'] == 'watt' || $a['type'] == 'amps' ) { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo number_format($d['dmin'], 2, '.', '')?></span><span class="label label-warning"><?php echo number_format($d['dmax'], 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($w['wmin'], 2, '.', '')?></span><span class="label label-warning"><?php echo number_format($w['wmax'], 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($m['mmin'], 2, '.', '')?></span><span class="label label-warning"><?php echo number_format($m['mmax'], 2, '.', '')?></span></td>
    </tr>
    <?php
	} elseif ($a['type'] == 'sunrise' || $a['type'] == 'sunset') { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo date('H:i', $d['dmin'])?></span><span class="label label-warning"><?php echo date('H:i', $d['dmax'])?></span></td>
	<td><span class="label label-info"><?php echo date('H:i', $w['wmin'])?></span><span class="label label-warning"><?php echo date('H:i', $w['wmax'])?></span></td>
	<td><span class="label label-info"><?php echo date('H:i', $m['mmin'])?></span><span class="label label-warning"><?php echo date('H:i', $m['mmax'])?></span></td>
    </tr>
    <?php
     } else { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo number_format($d['dmin'], 1, '.', '')?></span><span class="label label-warning"><?php echo number_format($d['dmax'], 1, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($w['wmin'], 1, '.', '')?></span><span class="label label-warning"><?php echo number_format($w['wmax'], 1, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($m['mmin'], 1, '.', '')?></span><span class="label label-warning"><?php echo number_format($m['mmax'], 1, '.', '')?></span></td>
    </tr>
    <?php
    }
 	 } else {

	//option2    
   
     if ($a['type'] == 'elec' || $a['type'] == 'water' || $a['type'] == 'gas') { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo number_format(($h['hmax']-$h['hmin']), 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($d['dmax']-$d['dmin']), 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($w['wmax']-$w['wmin']), 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($m['mmax']-$m['mmin']), 3, '.', '')?></span></td>
    </tr>
    <?php
    } elseif ($a['type'] == 'volt' || $a['type'] == 'watt' || $a['type'] == 'amps' ) { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo number_format(($h['hmax']-$h['hmin']), 2, '.', '')?></span></td>
   <td><span class="label label-info"><?php echo number_format(($d['dmax']-$d['dmin']), 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($w['wmax']-$w['wmin']), 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($m['mmax']-$m['mmin']), 2, '.', '')?></span></td>
    <?php
	} elseif ($a['type'] == 'sunrise' || $a['type'] == 'sunset') { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo date('i', ($h['hmax']-$h['hmin']))?></span></td>
	<td><span class="label label-info"><?php echo date('i', ($d['dmax']-$d['dmin']))?></span></td>
	<td><span class="label label-info"><?php echo date('i', ($w['wmax']-$w['wmin']))?></span></td>
	<td><span class="label label-info"><?php echo date('i', ($m['mmax']-$m['mmin']))?></span></td>
    </tr>
    <?php
     } else { ?>
    <tr>
	<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']) ?></span></td>
	<td><span class="label label-info"><?php echo number_format(($h['hmax']-$h['hmin']), 1, '.', '')?> </span></td>
   <td><span class="label label-info"><?php echo number_format(($d['dmax']-$d['dmin']), 1, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($w['wmax']-$w['wmin']), 1, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($m['mmax']-$m['mmin']), 1, '.', '')?></span></td>
    </tr>
    <?php
    }
	}    
    
}
}//hide
?>
</tbody>
</table>
</div>
</div>
</div>
<?php 
}
?>
