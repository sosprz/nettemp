<script type="text/javascript" src="html/highcharts/highstock.js"></script>
<script type="text/javascript" src="html/highcharts/exporting.js"></script>
<script type="text/javascript" src="html/highcharts/dark-unica.js"></script>
<script type="text/javascript" src="html/highcharts/no-data-to-display.js"></script>
<script src="https://rawgit.com/highslide-software/highcharts.com/master/js/modules/boost.src.js"></script>




<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->

<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
$max = isset($_GET['max']) ? $_GET['max'] : '';

$db1 = new PDO('sqlite:dbf/nettemp.db');
$rows1 = $db1->query("SELECT type FROM sensors WHERE charts='on'");
$row1 = $rows1->fetchAll();
foreach($row1 as $hi){
$type[]=$hi['type'];
}

$db1 = new PDO('sqlite:dbf/hosts.db');
$rows1 = $db1->query("SELECT name FROM hosts");
$row1 = $rows1->fetchAll();
$hostc = count($row1);


//print_r($type);
?>
<p>
<a href="index.php?id=view&type=temp&max=hour" ><button class="btn btn-default <?php echo $art == 'temp' ? ' active' : ''; ?>">Temperature</button></a>
<?php 
if (in_array('humid', $type))  {?>
<a href="index.php?id=view&type=humid&max=hour" ><button class="btn btn-default <?php echo $art == 'humid' ? ' active' : ''; ?>">Humidity</button></a>
<?php }
if (in_array('press', $type))  {?>
<a href="index.php?id=view&type=press&max=hour" ><button class="btn btn-default <?php echo $art == 'press' ? ' active' : ''; ?>">Pressure</button></a>
<?php }
if (in_array('altitude', $type))  {?>
<a href="index.php?id=view&type=altitude&max=hour" ><button class="btn btn-default <?php echo $art == 'altitude' ? ' active' : ''; ?>">Altitude view</button></a>
<?php }
if (glob('tmp/kwh/*.json')) {?>
<a href="index.php?id=view&type=kwh" ><button class="btn btn-default <?php echo $art == 'kwh' ? ' active' : ''; ?>">kWh</button></a>
<?php }
if (in_array('elex', $type))  {?>
<a href="index.php?id=view&type=elec&max=hour" ><button class="btn btn-default <?php echo $art == 'elec' ? ' active' : ''; ?>">Electricity</button></a>
<?php } 
if (in_array('water', $type))  {?>
<a href="index.php?id=view&type=water&max=hour" ><button class="btn btn-default <?php echo $art == 'water' ? ' active' : ''; ?>">Water</button></a>
<?php } 
if (in_array('gas', $type))  {?>
<a href="index.php?id=view&type=gas&max=hour" ><button class="btn btn-default <?php echo $art == 'gas' ? ' active' : ''; ?>">Gas</button></a>
<?php } 
if (in_array('lux', $type))  {?>
<a href="index.php?id=view&type=lux&max=hour" ><button class="btn btn-default <?php echo $art == 'lux' ? ' active' : ''; ?>">Light</button></a>
<?php } 
if (glob('db/gonoff*')) {?>
<a href="index.php?id=view&type=gonoff&max=hour" ><button class="btn btn-default <?php echo $art == 'gonoff' ? ' active' : ''; ?>">GPIO</button></a>
<?php } 
if ( $hostc >= "1")  {?>
<a href="index.php?id=view&type=hosts&max=hour" ><button class="btn btn-default <?php echo $art == 'hosts' ? ' active' : ''; ?>">Hosts</button></a>
<?php } 
?>
<a href="index.php?id=view&type=system&max=hour" ><button class="btn btn-default <?php echo $art == 'system' ? ' active' : ''; ?>">System stats</button></a>
</p>
<?php
if ($art != 'kwh') {
    ?>
<p>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=hour" ><button class="btn btn-default btn-xs <?php echo $max == 'hour' ? ' active' : ''; ?>">Hour</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=day" ><button class="btn btn-default btn-xs <?php echo $max == 'day' ? ' active' : ''; ?>">Day</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=week" ><button class="btn btn-default btn-xs <?php echo $max == 'week' ? ' active' : ''; ?>">Week</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=month" ><button class="btn btn-default btn-xs <?php echo $max == 'month' ? ' active' : ''; ?>">Month</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=months" ><button class="btn btn-default btn-xs <?php echo $max == 'months' ? ' active' : ''; ?>">6Month</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=year" ><button class="btn btn-default btn-xs <?php echo $max == 'year' ? ' active' : ''; ?>">Year</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=all" ><button class="btn btn-default btn-xs <?php echo $max == 'all' ? ' active' : ''; ?>">All</button></a> 
</p>
<?php
    }
?>

<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/menu.php'); break;
case 'kwh': include('modules/kwh/html/kwh_charts.php'); break;
}
?>




