<?php
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$triggernotice_checkbox = isset($_POST['triggernotice_checkbox']) ? $_POST['triggernotice_checkbox'] : '';
$xtriggernoticeon = isset($_POST['xtriggernoticeon']) ? $_POST['xtriggernoticeon'] : '';
if ($xtriggernoticeon == "xtriggernoticeON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_notice='$triggernotice_checkbox' WHERE gpio='$gpio_post'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<div class="panel panel-info">
<div class="panel-heading">
<h3 class="panel-title">Trigger alarms</h3>
</div>
<div class="panel-body">

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
<div class="row">
<form method="post" type="submit">
    <div class="col-sm-2"><img src="media/ico/TO-220-icon.png" />
    <?php echo $a['name']; ?></div>
    <div class="col-sm-1"><input type="checkbox" name="triggernotice_checkbox" value="on" <?php echo $a["trigger_notice"] == 'on' ? 'checked="checked"' : ''; ?> data-toggle="toggle" data-size="mini" onchange="this.form.submit()" /></div>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="xtriggernoticeon" value="xtriggernoticeON" />
</form>
</div>
<?php 
}  
?>
</div>
</div>
