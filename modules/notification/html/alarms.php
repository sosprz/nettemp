<?php
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$tmp_min_new = isset($_POST['tmp_min_new']) ? $_POST['tmp_min_new'] : '';
$tmp_max_new = isset($_POST['tmp_max_new']) ? $_POST['tmp_max_new'] : '';
$tmp_id = isset($_POST['tmp_id']) ? $_POST['tmp_id'] : '';
$del_alarm = isset($_POST['del_alarm']) ? $_POST['del_alarm'] : '';
$del_alarm1 = isset($_POST['del_alarm1']) ? $_POST['del_alarm1'] : '';
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

<table class="table table-condensed table-hover">
<thead><tr><th>Name</th><th><img src="media/ico/temp_low.png" />min<img src="media/ico/temp2-icon.png" />max</th><th></th></tr></thead>
<tbody>
<?php  
	$db1 = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db1->prepare("select * from sensors WHERE alarm='on'");
	$sth->execute();
	$result = $sth->fetchAll();
		foreach ($result as $a) { ?>

<tr>
    <td class="col-md-2"><img src="media/ico/TO-220-icon.png" /><?php echo $a['name']; ?></td>
    <td class="col-md-10">
    <form action="" method="post" style="display:inline!important;"> 
	<input type="hidden" name="tmp_id" value="<?php echo $a['id']; ?>" />
	<input type="text" name="tmp_min_new" size="3" value="<?php echo $a['tmp_min']; ?>" />
	<input type="text" name="tmp_max_new" size="3" value="<?php echo $a['tmp_max']; ?>" />
	<input type="hidden" name="ok" value="ok" />
	<button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
    <form action="" method="post" style="display:inline!important;"> 
	<input type="hidden" name="del_alarm1" value="del_alarm2" />
	<input type="hidden" name="del_alarm" value="<?php echo $a['name']; ?>" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
    </form>
    </td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>

<?php include('free.php'); ?>

