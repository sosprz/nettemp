<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if(!isset($NT_SETTINGS)){ include($root."/modules/settings/nt_settings.php"); }
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE minmax='on' ORDER BY position ASC");
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div class="grid-item mm">
<div class="panel panel-default">
<div class="panel-heading">Sensors Min Max</div>
<div class="table-responsive">
<table class="table table-hover table-condensed">
<tbody>
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
	<td><?php echo str_replace("_", " ", $a['name']) ?></td>
	<td><span class="label label-info"><?php echo number_format($d['dmin'], 2, '.', '')?></span><span class="label label-warning"><?php echo number_format($d['dmax'], 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($w['wmin'], 2, '.', '')?></span><span class="label label-warning"><?php echo number_format($w['wmax'], 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format($m['mmin'], 2, '.', '')?></span><span class="label label-warning"><?php echo number_format($m['mmax'], 2, '.', '')?></span></td>
    </tr>
    <?php
     } else { ?>
    <tr>
	<td><?php echo str_replace("_", " ", $a['name']) ?></td>
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
	<td><?php echo str_replace("_", " ", $a['name']) ?></td>
	<td><span class="label label-info"><?php echo number_format(($h['hmax']-$h['hmin']), 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($d['dmax']-$d['dmin']), 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($w['wmax']-$w['wmin']), 3, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($m['mmax']-$m['mmin']), 3, '.', '')?></span></td>
    </tr>
    <?php
    } elseif ($a['type'] == 'volt' || $a['type'] == 'watt' || $a['type'] == 'amps' ) { ?>
    <tr>
	<td><?php echo str_replace("_", " ", $a['name']) ?></td>
	<td><span class="label label-info"><?php echo number_format(($h['hmax']-$h['hmin']), 2, '.', '')?></span></td>
   <td><span class="label label-info"><?php echo number_format(($d['dmax']-$d['dmin']), 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($w['wmax']-$w['wmin']), 2, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($m['mmax']-$m['mmin']), 2, '.', '')?></span></td>
    <?php
     } else { ?>
    <tr>
	<td><?php echo str_replace("_", " ", $a['name']) ?></td>
	<td><span class="label label-info"><?php echo number_format(($h['hmax']-$h['hmin']), 1, '.', '')?> </span></td>
   <td><span class="label label-info"><?php echo number_format(($d['dmax']-$d['dmin']), 1, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($w['wmax']-$w['wmin']), 1, '.', '')?></span></td>
	<td><span class="label label-info"><?php echo number_format(($m['mmax']-$m['mmin']), 1, '.', '')?></span></td>
    </tr>
    <?php
    }
	}    
    
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
