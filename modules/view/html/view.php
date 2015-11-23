<script type="text/javascript" src="html/highcharts/highstock.js"></script>
<script type="text/javascript" src="html/highcharts/exporting.js"></script>
<script type="text/javascript" src="html/highcharts/dark-unica.js"></script>

<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->

<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
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
<a href="index.php?id=view&type=temp&max=day" ><button class="btn btn-default">Temperature</button></a>
<?php 
if (in_array('humid', $type))  {?>
<a href="index.php?id=view&type=humid&max=day" ><button class="btn btn-default">Humidity</button></a>
<?php }
if (in_array('press', $type))  {?>
<a href="index.php?id=view&type=press&max=day" ><button class="btn btn-default">Pressure</button></a>
<?php }
if (in_array('altitude', $type))  {?>
<a href="index.php?id=view&type=altitude&max=day" ><button class="btn btn-default">Altitude view</button></a>
<?php }
if (glob('tmp/kwh/*.json')) {?>
<a href="index.php?id=view&type=kwh" ><button class="btn btn-default">kWh</button></a>
<?php }
if (in_array('elex', $type))  {?>
<a href="index.php?id=view&type=elec&max=day" ><button class="btn btn-default">Electricity</button></a>
<?php } 
if (in_array('water', $type))  {?>
<a href="index.php?id=view&type=water&max=day" ><button class="btn btn-default">Water</button></a>
<?php } 
if (in_array('gas', $type))  {?>
<a href="index.php?id=view&type=gas&max=day" ><button class="btn btn-default">Gas</button></a>
<?php } 
if (in_array('lux', $type))  {?>
<a href="index.php?id=view&type=lux&max=day" ><button class="btn btn-default">Light</button></a>
<?php } 
if (in_array('gonoff', $type))  {?>
<a href="index.php?id=view&type=gonoff&max=day" ><button class="btn btn-default">GPIO</button></a>
<?php } 
if ( $hostc >= "1")  {?>
<a href="index.php?id=view&type=hosts&max=day" ><button class="btn btn-default">Hosts</button></a>
<?php } 
?>
<a href="index.php?id=view&type=system&max=day" ><button class="btn btn-default">System stats</button></a>
</p>

<p>
<?php
//if ($art == temp) { ?>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=hour" ><button class="btn btn-default">Hour</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=day" ><button class="btn btn-default">Day</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=week" ><button class="btn btn-default">Week</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=month" ><button class="btn btn-default">Month</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=months" ><button class="btn btn-default">6Months</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=year" ><button class="btn btn-default">Year</button></a>
<a href="index.php?id=view&type=<?php echo $art; ?>&max=all" ><button class="btn btn-default">All</button></a>
<?php 
//} 
?>

</p>

<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/menu.php'); break;
case 'kwh': include('modules/kwh/html/kwh_charts.php'); break;
}
?>




