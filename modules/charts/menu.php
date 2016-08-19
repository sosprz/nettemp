

<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->

<?php 
$art = isset($_GET['type']) ? $_GET['type'] : 'temp';
$max = isset($_GET['max']) ? $_GET['max'] : 'day';
if($id=='screen') {
       $max='hour';
       }
$group = isset($_GET['group']) ? $_GET['group'] : '';
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
$single = isset($_GET['single']) ? $_GET['single'] : '';

$rows1 = $db->query("SELECT type FROM sensors WHERE charts='on'");
$row1 = $rows1->fetchAll();
$typearr[] = array(); 
foreach($row1 as $hi){
$typearr[]=$hi['type'];
}


$rows1 = $db->query("SELECT name FROM hosts");
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
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day&mode=&group=&single=" ><button class="btn btn-xs btn-default <?php echo $art == 'temp' ? ' active' : ''; ?>">Temperature</button></a>
<?php 
if (in_array('humid', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?><?php echo $art ?>&max=day&mode=&group=&single=" ><button class="btn btn-xs btn-default <?php echo $art == 'humid' ? ' active' : ''; ?>">Humidity</button></a>
<?php }
if (in_array('press', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day&mode=&group=&single=" ><button class="btn btn-xs btn-default <?php echo $art == 'press' ? ' active' : ''; ?>">Pressure</button></a>
<?php }
if (in_array('altitude', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day&mode=&group=&single=" ><button class="btn btn-xs btn-default <?php echo $art == 'altitude' ? ' active' : ''; ?>">Altitude view</button></a>
<?php }
//if (glob('tmp/kwh/*.json')) {?>
<!-- <a href="index.php?id=view&type=<?php echo $art ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'kwh' ? ' active' : ''; ?>">kWh</button></a> -->
<?php 
//}
if (in_array('elec', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && empty($mode) ? ' active' : ''; ?>">Electricity kWh</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day&mode=2" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && $mode == '2' ? ' active' : ''; ?>">Electricity Wh</button></a>
<?php } 
if (in_array('water', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'water' ? ' active' : ''; ?>">Water</button></a>
<?php } 
if (in_array('gas', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'gas' ? ' active' : ''; ?>">Gas</button></a>
<?php } 
if (in_array('lux', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'lux' ? ' active' : ''; ?>">Light</button></a>
<?php } 
if (in_array('volt', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'volt' ? ' active' : ''; ?>">Voltage</button></a>
<?php } 
if (in_array('amps', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'amps' ? ' active' : ''; ?>">Ampere</button></a>
<?php } 
if (in_array('watt', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'watt' ? ' active' : ''; ?>">Watt</button></a>
<?php } 
if (glob('db/gpio_stats_*')) {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'gpio' ? ' active' : ''; ?>">GPIO</button></a>
<?php } 
if ( $hostc >= "1")  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'hosts' ? ' active' : ''; ?>">Hosts</button></a>
<?php } 
if (in_array('dist', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'dist' ? ' active' : ''; ?>">Distance</button></a>
<?php } 
if ( $gre1 >= "1") { ?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&group=1&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $group == '1' ? ' active' : ''; ?>">Group 1</button></a>
<?php } 
if ( $gre2 >= "1") { ?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&group=2&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $group == '2' ? ' active' : ''; ?>">Group 2</button></a>
<?php } 
if ( $gre3 >= "1") { ?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&group=3&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $group == '3' ? ' active' : ''; ?>">Group 3</button></a>
<?php } 
if (in_array('rainfall', $type))  {?>
<a href="index.php?id=view&type=rainfall&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'rainfall' ? ' active' : ''; ?>">Rainfall</button></a>
<?php } 
if (in_array('speed', $type))  {?>
<a href="index.php?id=view&type=speed&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'speed' ? ' active' : ''; ?>">Speed</button></a>
<?php } 
if (in_array('wind', $type))  {?>
<a href="index.php?id=view&type=wind&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'wind' ? ' active' : ''; ?>">Wind</button></a>
<?php } 
if (in_array('uv', $type))  {?>
<a href="index.php?id=view&type=uv&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'uv' ? ' active' : ''; ?>">UV</button></a>
<?php } 
if (in_array('storm', $type))  {?>
<a href="index.php?id=view&type=storm&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'storm' ? ' active' : ''; ?>">Storm</button></a>
<?php } 
if (in_array('lightning', $type))  {?>
<a href="index.php?id=view&type=lightning&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'lightning' ? ' active' : ''; ?>">Lightning</button></a>
<?php } 

if($id!='screen') {
?>

<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'system' ? ' active' : ''; ?>">System stats</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'meteogram' ? ' active' : ''; ?>">Meteogram</button></a>
</p>
<?php
if ($art!='meteogram') {
    ?>
<p>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=hour&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'hour' ? ' active' : ''; ?>">Hour</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'day' ? ' active' : ''; ?>">Day</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=week&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'week' ? ' active' : ''; ?>">Week</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=month&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'month' ? ' active' : ''; ?>">Month</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=months&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'months' ? ' active' : ''; ?>">6Month</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=year&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'year' ? ' active' : ''; ?>">Year</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=all&mode=<?php echo $mode; ?>&group=<?php echo $group; ?>&single=<?php echo $single; ?>" ><button class="btn btn-xs btn-default <?php echo $max == 'all' ? ' active' : ''; ?>">All</button></a> 
</p>
<?php
    }
 }
	switch ($art)
	{ 
	default: case '$art': include('modules/charts/router.php'); break;
	case 'meteogram': include('modules/charts/meteogram.php'); break;
	}
?>




