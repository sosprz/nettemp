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
?>

<?php // SQLite - ADD RECIPIENT
	$dpdd1 = isset($_POST['add1']) ? $_POST['add1'] : '';
	if ($_POST['add1'] == "add2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO day_plan (name, Mon, Tue, Wed, Thu, Fri, Sat, Sun, stime, etime) VALUES ('$name','$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun', '$stime', '$etime')") or die ($db->lastErrorMsg());
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
<thead><tr>
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
</tr></thead>

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
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	</form>
    </tr> 
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from day_plan");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $dp) { 
?>
	<tr>
	<td><?php echo $dp["name"];?></td>
	<td><?php echo $dp["Mon"];?></td>
	<td><?php echo $dp["Tue"];?></td>
	<td><?php echo $dp["Wed"];?></td>
	<td><?php echo $dp["Thu"];?></td>
	<td><?php echo $dp["Fri"];?></td>
	<td><?php echo $dp["Sat"];?></td>
	<td><?php echo $dp["Sun"];?></td>
	<td><?php echo $dp["stime"];?></td>
	<td><?php echo $dp["etime"];?></td>


	<td>
	<?php if ($dp['name'] != 'any') { ?>
    	<form action="" method="post"> 	
	    <input type="hidden" name="del" value="<?php echo $dp["id"]; ?>" />
	    <input type="hidden" type="submit" name="del1" value="del2" />
	    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
	</form>
<?php } ?>
	</td>
	</tr>
<?php 
    }
?>
</table>
</div>
</div>
