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


$temp_scale=$nts_temp_scale;



?>
<p>
<?php

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();
foreach($result_t as $ty){
	if(in_array($ty['type'], $typearr)) { 
	?>
     <a href="index.php?id=<?php echo $id ?>&type=<?php echo $ty['type']?>&max=<?php echo $nts_charts_max?>&mode=&group=&single=" ><button class="btn btn-xs btn-default <?php if($art == $ty['type']&&empty($group)) {echo "active";} ?>"><?php echo $ty['title']?></button></a>
	<?php
	}
}

$query = $db->query("SELECT ch_group FROM sensors ");
$result_ch_g = $query->fetchAll();
	foreach($result_ch_g as $uniq) {
		if(!empty($uniq['ch_group'])&&$uniq['ch_group']!='none'&&$uniq['ch_group']!='all') {
			$unique[]=$uniq['ch_group'];
		}
	}
	$rowu = array_unique($unique);
	foreach ($rowu as $ch_g) { 	
		?>
		<a href="index.php?id=<?php echo $id ?>&type=group&max=<?php echo $nts_charts_max?>&mode=&group=<?php echo $ch_g ?>&single=" ><button class="btn btn-xs btn-default <?php if($group==$ch_g) {echo "active";} ?>">Group: <?php echo $ch_g?></button></a>
		<?php 
	}



if (in_array('elec', $typearr))  {?>
<a href="index.php?id=<?php echo $id ?>&type=elec&max=day&mode=2" ><button class="btn btn-xs btn-default <?php echo $art == 'elec' && $mode == '2' ? ' active' : ''; ?>">Electricity Wh</button></a>
<?php } 
if($id!='screen'&&isset($_SESSION['user'])) {
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




