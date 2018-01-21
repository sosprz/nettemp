<?php
$name = isset($_POST['name']) ? $_POST['name'] : '';
$stime = isset($_POST['stime']) ? $_POST['stime'] : '';
$etime = isset($_POST['etime']) ? $_POST['etime'] : '';
$mon = isset($_POST['mon']) ? $_POST['mon'] : '';
$tue = isset($_POST['tue']) ? $_POST['tue'] : '';
$wed = isset($_POST['wed']) ? $_POST['wed'] : '';
$thu = isset($_POST['thu']) ? $_POST['thu'] : '';
$fri = isset($_POST['fri']) ? $_POST['fri'] : '';
$sat = isset($_POST['sat']) ? $_POST['sat'] : '';
$sun = isset($_POST['sun']) ? $_POST['sun'] : '';
$del = isset($_POST['del']) ? $_POST['del'] : '';
$dpgpio = isset($_POST['dpgpio']) ? $_POST['dpgpio'] : '';
$dprom = isset($_POST['dprom']) ? $_POST['dprom'] : '';

	$dpdd1 = isset($_POST['add1']) ? $_POST['add1'] : '';
	if ($dpdd1 == 'add2'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$name=str_replace(' ', '_', $name);
	$db->exec("INSERT OR IGNORE INTO day_plan (name, Mon, Tue, Wed, Thu, Fri, Sat, Sun, stime, etime, gpio,rom) VALUES ('$name','$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun', '$stime', '$etime', '$dpgpio','$dprom') ") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	
	$week_plan = isset($_POST['week_plan']) ? $_POST['week_plan'] : '';
	$week_plan_id = isset($_POST['week_plan_id']) ? $_POST['week_plan_id'] : '';
	if ($week_plan == 'edit'){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE day_plan SET Mon='$mon', Tue='$tue', Wed='$wed', Thu='$thu', Fri='$fri', Sat='$sat', Sun='$sun', stime='$stime', etime='$etime' WHERE id='$week_plan_id' AND rom='$dprom' ") or die($week_plan_id."\n".$etime."\n".$stime."\n".$wed);
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}



	// SQLite - usuwanie notification
	if (!empty($del) && ($_POST['del1'] == "del2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM day_plan WHERE id='$del'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>


<div class="panel panel-default">
<div class="panel-heading">Day/Week plan profiles</div>

<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Name</th>
<th>Mon</th>
<th>Tue</th>
<th>Wed</th>
<th>Thu</th>
<th>Fri</th>
<th>Sat</th>
<th>Sun</th>
<th>Start hour</th>
<th>End hour</th>
<th></th>
<th></th>
</tr>
</thead>

    <tr>	
	<form action="" method="post">
	<td><input type="text" name="name" value="" class="form-control" required=""/></td>
	<td><input type="checkbox" name="mon" value="Mon" /></td>
	<td><input type="checkbox" name="tue" value="Tue" /></td>
	<td><input type="checkbox" name="wed" value="Wed" /></td>    
	<td><input type="checkbox" name="thu" value="Thu" /></td>
	<td><input type="checkbox" name="fri" value="Fri" /></td>        
	<td><input type="checkbox" name="sat" value="Sat" /></td>        
	<td><input type="checkbox" name="sun" value="Sun" /></td>
	<td><input type="text" name="stime" value="" class="form-control" required="" placeholder="07:00"/></td>
	<td><input type="text" name="etime" value="" class="form-control" required="" placeholder="19:00"/></td>
	<input type="hidden" name="add1" value="add2" />
	<input type="hidden" name="dpgpio" value="<?php echo $gpio; ?>" />
	<input type="hidden" name="dprom" value="<?php echo $a['rom']; ?>"/>
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	<th></th>
	</form>
    </tr> 
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from day_plan where gpio='$gpio' AND rom='$rom'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $dp) { 
?>
	<tr>
			<form action="" method="post"> 
	
	<td><?php echo str_replace('_', ' ', $dp["name"])?></td>
	<td><input type="checkbox" name="mon" value="Mon" <?php echo $dp['Mon'] == 'Mon' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="checkbox" name="tue" value="Tue" <?php echo $dp['Tue'] == 'Tue' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="checkbox" name="wed" value="Wed" <?php echo $dp['Wed'] == 'Wed' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="checkbox" name="thu" value="Thu" <?php echo $dp['Thu'] == 'Thu' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="checkbox" name="fri" value="Fri" <?php echo $dp['Fri'] == 'Fri' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="checkbox" name="sat" value="Sat" <?php echo $dp['Sat'] == 'Sat' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="checkbox" name="sun" value="Sun" <?php echo $dp['Sun'] == 'Sun' ? 'checked="checked"' : ''; ?>/></td>
	<td><input type="text" name="stime" value="<?php echo $dp["stime"];?>" class="form-control" required="" placeholder="07:00"/></td>
	<td><input type="text" name="etime" value="<?php echo $dp["etime"];?>" class="form-control" required="" placeholder="19:00"/></td>
	
	
	
	<td>
			<input type="hidden" name="week_plan_id" value="<?php echo $dp["id"]; ?>" />
			<input type="hidden" type="submit" name="week_plan" value="edit" />
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
		</form>
	</td>
	
	<td>
    	<form action="" method="post"> 	
			<input type="hidden" name="del" value="<?php echo $dp["id"]; ?>" />
			<input type="hidden" type="submit" name="del1" value="del2" />
			<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
		</form>
	</td>
	</tr>
<?php 
    }
?>
</table>
</div>
</div>
