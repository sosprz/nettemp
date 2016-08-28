<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';

$max = isset($_GET['max']) ? $_GET['max'] : '';
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

$rows = $db->query("SELECT * FROM settings WHERE id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $temp_scale=$a['temp_scale'];
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
<?php

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();
foreach($result_t as $ty){
	if(in_array($ty['type'], $typearr)) { 
	?>
     <a href="index.php?id=<?php echo $id ?>&type=<?php echo $ty['type'] ?>&max=day&mode=&group=&single=" ><button class="btn btn-xs btn-default <?php echo $art == $ty['type'] ? ' active' : ''; ?>"><?php echo $ty['title']?></button></a>
	<?php
	}
}


if ( $gre1 >= "1") { ?>
<a href="index.php?id=<?php echo $id ?>&type=group&group=1&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $group == '1' ? ' active' : ''; ?>">Group 1</button></a>
<?php } 
if ( $gre2 >= "1") { ?>
<a href="index.php?id=<?php echo $id ?>&type=group&group=2&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $group == '2' ? ' active' : ''; ?>">Group 2</button></a>
<?php } 
if ( $gre3 >= "1") { ?>
<a href="index.php?id=<?php echo $id ?>&type=group&group=3&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $group == '3' ? ' active' : ''; ?>">Group 3</button></a>
<?php }
if ( $hostc >= "1")  {?>
<a href="index.php?id=<?php echo $id ?>&type=hosts&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'hosts' ? ' active' : ''; ?>">Hosts</button></a>
<?php } 
if (in_array('elec', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && empty($mode) ? ' active' : ''; ?>">Electricity kWh</button></a>
<a href="index.php?id=<?php echo $id ?>&type=<?php echo $art ?>&max=day&mode=2" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && $mode == '2' ? ' active' : ''; ?>">Electricity Wh</button></a>
<?php } 
if (glob('db/gpio_stats_*')) {?>
<a href="index.php?id=<?php echo $id ?>&type=gpio&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'gpio' ? ' active' : ''; ?>">GPIO</button></a>
<?php } 

if($id!='screen') {
?>

<a href="index.php?id=<?php echo $id ?>&type=system&max=<?php echo $max ?>" ><button class="btn btn-xs btn-default <?php echo $art == 'system' ? ' active' : ''; ?>">System stats</button></a>
<a href="index.php?id=<?php echo $id ?>&type=meteogram" ><button class="btn btn-xs btn-default <?php echo $art == 'meteogram' ? ' active' : ''; ?>">Meteogram</button></a>
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




