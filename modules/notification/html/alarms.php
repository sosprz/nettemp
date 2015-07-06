<?php
$tmp_id = isset($_POST['tmp_id']) ? $_POST['tmp_id'] : '';
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$tmp_min_new = isset($_POST['tmp_min_new']) ? $_POST['tmp_min_new'] : '';
$tmp_max_new = isset($_POST['tmp_max_new']) ? $_POST['tmp_max_new'] : '';
$add_alarm = isset($_POST['add_alarm']) ? $_POST['add_alarm'] : '';
$del_alarm = isset($_POST['del_alarm']) ? $_POST['del_alarm'] : '';
?>
<?php	// SQLite - dodawania alarmu
    if (!empty($add_alarm) && ($_POST['add_alarm1'] == "add_alarm2")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='on' WHERE id='$add_alarm'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
     ?> 
<?php	// SQLite - usuwanie alarmu
    if (!empty($del_alarm) && ($_POST['del_alarm1'] == "del_alarm2")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='off' WHERE name='$del_alarm'") or die ($db->lastErrorMsg());
    unlink("tmp/mail/$del_alarm.mail");
    unlink("tmp/mail/hour/$del_alarm.mail");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
     ?> 
<?php	
    if (!empty($tmp_id) && ($_POST['ok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET tmp_min='$tmp_min_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE sensors SET tmp_max='$tmp_max_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
    
?>
<div class="panel panel-default">
<div class="panel-heading">Set the temperature range</div>
<div class="panel-body">
<?php  
	$db1 = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db1->prepare("select * from sensors WHERE alarm='on'");
	$sth->execute();
	$result =  $sth->fetchAll();
		foreach ($result as $a) { ?>

<div class="row">
	
	<form action="" method="post" style=" display:inline!important;"> 
	<div class="col-md-1"><img src="media/ico/TO-220-icon.png" />
	<?php echo $a['name']; ?></div>
	<input type="hidden" name="tmp_id" value="<?php echo $a['id']; ?>" />
	<div class="col-md-1"><input type="text" name="tmp_min_new" size="3" value="<?php echo $a['tmp_min']; ?>" placeholder="min"/></div>
	<div class="col-md-1"><input type="text" name="tmp_max_new" size="3" value="<?php echo $a['tmp_max']; ?>" placeholder="max"/></div>
	<div class="col-md-1"><button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button></div>
	<input type="hidden" name="ok" value="ok" />
	</form>

	<form action="" method="post" style=" display:inline!important;"> 
	<input type="hidden" name="del_alarm1" value="del_alarm2" />
	<input type="hidden" name="del_alarm" value="<?php echo $a['name']; ?>" />
	<div class="col-md-1"><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></div>
	</form>

</div>							
		 
<?php
}
?>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">Free sensors</div>
<div class="panel-body">
<?php	
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE alarm='off'");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }

$sth = $db1->prepare("select * from sensors WHERE alarm='off'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>
<div class="row">
    <form action="" method="post">
	<div class="col-sm-1"><img src="media/ico/TO-220-icon.png" />
	<?php echo $a['name']; ?></div>
	<input type="hidden" name="add_alarm" value="<?php echo $a['id']; ?>" />
	<input type="hidden" name="add_alarm1" value="add_alarm2" />
	<div class="col-sm-1"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></div>
    </form>
</div>
<?php }  ?>


</div>
</div>




