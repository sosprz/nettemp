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
    
$triggernotice_checkbox = isset($_POST['triggernotice_checkbox']) ? $_POST['triggernotice_checkbox'] : '';
$xtriggernoticeon = isset($_POST['xtriggernoticeon']) ? $_POST['xtriggernoticeon'] : '';
if ($xtriggernoticeon == "xtriggernoticeON")  {
    //exec("/usr/local/bin/gpio reset $gpio_post ");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_notice='$triggernotice_checkbox' WHERE gpio='$gpio_post'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Set the temperature range</h3>
</div>
<div class="panel-body">
<table class="table table-striped">
<thead><tr><th></th><th>Name</th><th><img src="media/ico/temp_low.png" /> min</th><th><img src="media/ico/temp2-icon.png" />max</th><th>Set temp</th><th>Remove</th></tr></thead>
<?php  
//$db = new PDO('sqlite:dbf/nettemp.db');
//$rows = $db->query("SELECT * FROM sensors WHERE alarm='on'");
//$row = $rows->fetchAll();
//$numRows = count($row);

//if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
	$db1 = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db1->prepare("select * from sensors WHERE alarm='on'");
	$sth->execute();
	$result = $sth->fetchAll();
		foreach ($result as $a) { ?>

	
	<tr>
	<form action="" method="post"> 
	<td><img src="media/ico/TO-220-icon.png" /></td>
	<td><?php echo $a['name']; ?></td>
	<input type="hidden" name="tmp_id" value="<?php echo $a['id']; ?>" />
	<td><input type="text" name="tmp_min_new" size="3" value="<?php echo $a['tmp_min']; ?>" /></td>
	<td><input type="text" name="tmp_max_new" size="3" value="<?php echo $a['tmp_max']; ?>" /></td>
	<input type="hidden" name="ok" value="ok" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
	<form action="" method="post"> 
	<input type="hidden" name="del_alarm1" value="del_alarm2" />
	<input type="hidden" name="del_alarm" value="<?php echo $a['name']; ?>" />
	<td><input type="image" src="media/ico/Close-2-icon.png"  /></td>
	</form></tr>  							
		 <?php	} 

?>
</table>
</div></div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Free sensors</h3>
</div>
<div class="panel-body">
<table class="table table-striped">
<thead><tr><th></th><th>Name</th><th>Add</th></tr></thead>
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
    <tr>
   <form action="" method="post">
   <td><img src="media/ico/TO-220-icon.png" /></td>
	<td><?php echo $a['name']; ?></td>
	<input type="hidden" name="add_alarm" value="<?php echo $a['id']; ?>" />
	<input type="hidden" name="add_alarm1" value="add_alarm2" />
    <td>&nbsp<input type="image" src="media/ico/Add-icon.png"  /></td>
	</tr>    
    </form>
<?php }  ?>
</table>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Trigger alarms</h3>
</div>
<div class="panel-body">
<table class="table table-striped">
<?php	
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * from gpio WHERE mode='trigger'");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }

$sth = $db1->prepare("select * from gpio WHERE mode='trigger'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>
    <tr>
	<form action="" method="post"> 
	<td><img src="media/ico/TO-220-icon.png" /></td>
	<td><?php echo $a['name']; ?></td>
		<td><input type="checkbox" name="triggernotice_checkbox" value="on" <?php echo $a["trigger_notice"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtriggernoticeon" value="xtriggernoticeON" />
	</form>    
    
    
<?php }  ?>
</table>
</div>
</div>


	
	
