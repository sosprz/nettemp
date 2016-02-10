<?php 
$db = new PDO('sqlite:dbf/nettemp.db');
$rows1 = $db->query("SELECT charts_theme FROM settings WHERE id='1'");
$row1 = $rows1->fetchAll();
foreach($row1 as $t){
$theme=$t['charts_theme'];
}
?>
<script type="text/javascript" src="html/highcharts/highstock.js"></script>
<script type="text/javascript" src="html/highcharts/exporting.js"></script>
<?php if ($theme == 'black') { ?>
<script type="text/javascript" src="html/highcharts/dark-unica.js"></script>
<?php 
    }
if ($theme == 'sand') { ?>
<script type="text/javascript" src="html/highcharts/sand-signika.js"></script>
<?php 
    }
if ($theme == 'grid') { ?>
<script type="text/javascript" src="html/highcharts/grid-light.js"></script>
<?php 
    }
?>

<script type="text/javascript" src="html/highcharts/no-data-to-display.js"></script>




<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->

<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
$max = isset($_GET['max']) ? $_GET['max'] : '';
$group = isset($_GET['group']) ? $_GET['group'] : '';
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

$rows1 = $db->query("SELECT type FROM sensors WHERE charts='on'");
$row1 = $rows1->fetchAll();
foreach($row1 as $hi){
$type[]=$hi['type'];
}

$dbh = new PDO('sqlite:dbf/hosts.db');
$rows1 = $dbh->query("SELECT name FROM hosts");
$row1 = $rows1->fetchAll();
$hostc = count($row1);

$gr1 = $db->query("SELECT * FROM sensors WHERE ch_group='1'");
$grp1 = $gr1->fetchAll();
$gre1 = count($grp1);
$gr2 = $db->query("SELECT * FROM sensors WHERE ch_group='2'");
$grp2 = $gr2->fetchAll();
$gre2 = count($grp2);
$gr3 = $db->query("SELECT * FROM sensors WHERE ch_group='3'");
$grp3 = $gr3->fetchAll();
$gre3 = count($grp3);


//print_r($type);
?>
<p>
<a href="index.php?id=view&type=temp&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'temp' ? ' active' : ''; ?>">Temperature</button></a>
<?php 
if (in_array('humid', $type))  {?>
<a href="index.php?id=view&type=humid&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'humid' ? ' active' : ''; ?>">Humidity</button></a>
<?php }
if (in_array('press', $type))  {?>
<a href="index.php?id=view&type=press&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'press' ? ' active' : ''; ?>">Pressure</button></a>
<?php }
if (in_array('altitude', $type))  {?>
<a href="index.php?id=view&type=altitude&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'altitude' ? ' active' : ''; ?>">Altitude view</button></a>
<?php }
//if (glob('tmp/kwh/*.json')) {?>
<!-- <a href="index.php?id=view&type=kwh" ><button class="btn btn-xs btn-default <?php echo $art == 'kwh' ? ' active' : ''; ?>">kWh</button></a> -->
<?php 
//}
if (in_array('elec', $type))  {?>
<a href="index.php?id=view&type=elec&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && empty($mode) ? ' active' : ''; ?>">Electricity kWh</button></a>
<a href="index.php?id=view&type=elec&max=day&mode=2" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && $mode == '2' ? ' active' : ''; ?>">Electricity Wh</button></a>
<?php } 
if (in_array('water', $type))  {?>
<a href="index.php?id=view&type=water&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'water' ? ' active' : ''; ?>">Water</button></a>
<?php } 
if (in_array('gas', $type))  {?>
<a href="index.php?id=view&type=gas&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'gas' ? ' active' : ''; ?>">Gas</button></a>
<?php } 
if (in_array('lux', $type))  {?>
<a href="index.php?id=view&type=lux&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'lux' ? ' active' : ''; ?>">Light</button></a>
<?php } 
if (in_array('volt', $type))  {?>
<a href="index.php?id=view&type=volt&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'volt' ? ' active' : ''; ?>">Voltage</button></a>
<?php } 
if (in_array('amps', $type))  {?>
<a href="index.php?id=view&type=amps&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'amps' ? ' active' : ''; ?>">Ampere</button></a>
<?php } 
if (in_array('watt', $type))  {?>
<a href="index.php?id=view&type=watt&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'watt' ? ' active' : ''; ?>">Watt</button></a>
<?php } 
if (glob('db/gpio_stats_*')) {?>
<a href="index.php?id=view&type=gpio&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'gpio' ? ' active' : ''; ?>">GPIO</button></a>
<?php } 
if ( $hostc >= "1")  {?>
<a href="index.php?id=view&type=hosts&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'hosts' ? ' active' : ''; ?>">Hosts</button></a>
<?php } 
if (in_array('dist', $type))  {?>
<a href="index.php?id=view&type=dist&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'dist' ? ' active' : ''; ?>">Distance</button></a>
<?php } 
if ( $gre1 >= "1") { ?>
<a href="index.php?id=view&type=group&group=1&max=day" ><button class="btn btn-xs btn-default <?php echo $group == '1' ? ' active' : ''; ?>">Group 1</button></a>
<?php } 
if ( $gre2 >= "1") { ?>
<a href="index.php?id=view&type=group&group=2&max=day" ><button class="btn btn-xs btn-default <?php echo $group == '2' ? ' active' : ''; ?>">Group 2</button></a>
<?php } 
if ( $gre3 >= "1") { ?>
<a href="index.php?id=view&type=group&group=3&max=day" ><button class="btn btn-xs btn-default <?php echo $group == '3' ? ' active' : ''; ?>">Group 3</button></a>
<?php } ?>

<a href="index.php?id=view&type=system&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'system' ? ' active' : ''; ?>">System stats</button></a>
<a href="index.php?id=view&type=meteogram" ><button class="btn btn-xs btn-default <?php echo $art == 'meteogram' ? ' active' : ''; ?>">Meteogram</button></a>
</p>
<?php
if ($art!='meteogram') {
    ?>
<p>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=hour&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'hour' ? ' active' : ''; ?>">Hour</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=day&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'day' ? ' active' : ''; ?>">Day</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=week&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'week' ? ' active' : ''; ?>">Week</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=month&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'month' ? ' active' : ''; ?>">Month</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=months&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'months' ? ' active' : ''; ?>">6Month</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=year&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'year' ? ' active' : ''; ?>">Year</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=all&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'all' ? ' active' : ''; ?>">All</button></a> 
</p>
<?php
    }
?>

<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/menu.php'); break;
case 'kwh': include('modules/kwh/html/kwh_charts.php'); break;
case 'meteogram': include('modules/view/html/meteogram.php'); break;
}
?>




