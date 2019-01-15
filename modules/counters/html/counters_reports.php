<?php
$crom=isset($_GET['crom']) ? $_GET['crom'] : '';
$repyear = isset($_POST['repyear']) ? $_POST['repyear'] : '';
$cost1rom = isset($_POST['cost1rom']) ? $_POST['cost1rom'] : '';
$cost2rom = isset($_POST['cost2rom']) ? $_POST['cost2rom'] : '';
$cost1_new = isset($_POST['cost1_new']) ? $_POST['cost1_new'] : '';
$cost2_new = isset($_POST['cost2_new']) ? $_POST['cost2_new'] : '';
$c1 = isset($_POST['c1']) ? $_POST['c1'] : '';
$c2 = isset($_POST['c2']) ? $_POST['c2'] : '';
$monthexp = isset($_POST['monthexp']) ? $_POST['monthexp'] : '';
$repyearselect = isset($_POST['repyearselect']) ? $_POST['repyearselect'] : '';

$thisyear = date("Y");
//$repyearselect = '';
$totalusage = 0;
$totalcosts = 0;

//if (empty($monthexp)) {$monthexp = '%';}

if(!empty($repyear)) {$repyearselect = $repyear;} else {$repyearselect = $thisyear;} 

if ( !empty($cost1rom) && !empty($cost1_new) && ($c1 == "ok")){
	$cost1_new = str_replace(",", ".", $cost1_new);
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET cost1='$cost1_new' WHERE rom='$cost1rom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
	
if ( !empty($cost2rom) && !empty($cost2_new) && ($c2 == "ok")){
	$cost2_new = str_replace(",", ".", $cost2_new);
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET cost2='$cost2_new' WHERE rom='$cost2rom'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE rom='$crom' AND type = 'elec' OR type = 'gas' OR type = 'water'");
$row = $rows->fetchAll();
$count = count($row);
if ($count >= "1") {
foreach ($row as $a) { 	
$t1cost = $a["cost1"];
$t2cost = $a["cost2"];
$romcost = $a["rom"];
$type = $a['type'];



$rom=$a['rom'];
		$dbs = new PDO("sqlite:$root/db/$rom.sql") or die('lol');
		
		if (empty($monthexp)) {
		
		$rows = $dbs->query("SELECT time AS date,round(sum(value),3) AS sums from def WHERE strftime('%Y',time) IN ('$repyearselect') GROUP BY strftime('%m',time)") or die('Something is wrong');
		} else {
			
			$rows = $dbs->query("SELECT time AS date,round(sum(value),3) AS sums from def WHERE strftime('%Y',time) IN ('$repyearselect') AND strftime('%m',time) LIKE '$monthexp'  GROUP BY strftime('%m',time), strftime('%d',time)") or die('Something is wrong');
			$exp = 1;
		}
		
		$row = $rows->fetchAll();

?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $a["name"]; ?> </h3></div>
<div class="table-responsive ">
<table class="table table-hover table-striped table-condensed small" border="0">

<thead>
<th>Month</th>
<th>Usage</th>
<th>Cost</th>
<th></th>

</thead>
<tbody>
	
	<?php
	
		foreach ($row as $a) { 
		
		?>
		<tr>
			<td class="col-md-0">
			
			<?php 
			
				if ($exp != 1) { 
				
				$monthraw = $a['date']; 
				$month = date("F",strtotime($monthraw)); 
				echo $month = date("m",strtotime($monthraw)).". ".$month." ".$repyearselect;
				
				
				
				} else {
					
				$monthraw = $a['date']; 
				$month = date("F",strtotime($monthraw)); 
				$day = date("d",strtotime($monthraw)); 
				echo $day.". ".$month." ".$repyearselect;
					
				
				
				} //echo $monthraw;
			?>
			
			</td>
			
			<td class="col-md-0">
			<?php 
				$usage = $a['sums']; 
				echo number_format($usage, 3, ',', '.');
				$totalusage = $totalusage + $usage;
			?>
			</td>
			
			<td class="col-md-0">
			<?php 
				$costs = ($a['sums'] * $t1cost);
      
				echo number_format($costs, 2, ',', '.');
				$totalcosts = $totalcosts + $costs;
			 ?>
			</td>
			
			<td class="col-md-5"> <?php if ($exp != 1) { ?>
			<form action="" method="post" style="display:inline!important;">
				<input type="hidden" name="monthexp" value="<?php echo $month = date("m",strtotime($monthraw)); ?>" />
				<input type="hidden" name="repyear" value="<?php echo $repyear; ?>" />
				<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-menu-down"></span> </button>
			</form>
			<?php
			}
			?>
			
			</td>
		</tr>
		
		<?php
		}
		?>
		<tr>
			<td class="col-md-0"><label>Total:</label></td>
			<td class="col-md-0"><label><?php echo number_format($totalusage, 3, ',', '.'); ?></label></td>
			<td class="col-md-0"><label><?php echo number_format($totalcosts, 2, ',', '.'); ?></label></td>
			<td class="col-md-5"></td>
		</tr>
		
		<?php if ($exp == 1) { ?>
		
		<tr>
			<td class="col-md-0">
				<form action="" method="post" style="display:inline!important;">
					<input type="hidden" name="repyear" value="<?php echo $repyear; ?>" />
					<button class="btn btn-xs btn-info">Back </button>
				</form>
			</td>
			
			<td class="col-md-0"></td>
			<td class="col-md-0"></td>
			<td class="col-md-5"></td>
		</tr>
		<?php 
		}
		?>
<?php		
}
?>
</tbody>
</table>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Report parameters </h3></div>
<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">

<tr>
			<td class="col-md-0">Select year:
			
				<form action="" method="post" style="display:inline!important;">
					<select name="repyear" id="repyear" onchange="this.form.submit()">
						<option value="<?php echo $thisyear; ?>" <?php echo $repyearselect == $thisyear ? 'selected="selected"' : ''; ?> ><?php echo $thisyear; ?></option>
						<option value="<?php echo $thisyear -1; ?>" <?php echo $repyearselect == $thisyear-1 ? 'selected="selected"' : ''; ?>  ><?php echo $thisyear -1; ?></option>
						<option value="<?php echo $thisyear -2; ?>" <?php echo $repyearselect == $thisyear-2 ? 'selected="selected"' : ''; ?>  ><?php echo $thisyear -2; ?></option>
						<option value="<?php echo $thisyear -3; ?>" <?php echo $repyearselect == $thisyear-3 ? 'selected="selected"' : ''; ?>  ><?php echo $thisyear -3; ?></option>
						<option value="<?php echo $thisyear -4; ?>" <?php echo $repyearselect == $thisyear-4 ? 'selected="selected"' : ''; ?>  ><?php echo $thisyear -4; ?></option>
					</select>
				</form>
			</td>
			
			<td class="col-md-0">T1 Costs: 
				<form action="" method="post" style="display:inline!important;"> 
					<input type="hidden" name="cost1rom" value="<?php echo $romcost; ?>" />
					<input type="text" name="cost1_new" size="1" value="<?php echo $t1cost; ?>" />
					<input type="hidden" name="c1" value="ok" />
					<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
				</form>
			</td> 
			
			<?php 
			if ($type == 'elec'){ ?>
			<td class="col-md-0">T2 Costs: 
				<form action="" method="post" style="display:inline!important;"> 
					<input type="hidden" name="cost2rom" value="<?php echo $romcost; ?>" />
					<input type="text" name="cost2_new" size="1" value="<?php echo $t2cost; ?>" />
					<input type="hidden" name="c2" value="ok" />
					<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
				</form>
			</td>
			<?php
			}
			?>			
		
		</tr>



</table>
</div>
</div>
<a href="index.php?id=device&type=counters"><button class="btn btn-xs btn-info">Back to counters</button></a>
<?php
	} else { 
		?>
		<div class="panel-body">
		This is no counter device.
		</div>
		<?php
	}
?>


