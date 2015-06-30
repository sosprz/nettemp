<?php
$triggerexit = isset($_POST['triggerexit']) ? $_POST['triggerexit'] : '';

if (($triggerexit == "triggerexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("humid off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$triggerrun = isset($_POST['triggerrun']) ? $_POST['triggerrun'] : '';
if ($triggerrun == "on")  {
    $db->exec("UPDATE gpio SET trigger_run='on', status='Wait' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    $cmd=("nohup modules/gpio/trigger_proc $gpio_post");
    shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
if ($triggerrun == "off")  {
    $db->exec("UPDATE gpio SET trigger_run='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    shell_exec("modules/gpio/trigger_close $gpio_post");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$toutonoff = isset($_POST['toutonoff']) ? $_POST['toutonoff'] : '';
foreach (range(1, 30) as $num) {
$tout=isset($_POST["tout".$num]) ? $_POST["tout".$num] : '';
if (($toutonoff == "onoff") &&  (!empty($tout)))  {
    $tout == "off" ? $tout='' : "";
    $db->exec("UPDATE gpio SET tout$num='$tout' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
}


    $trigger_run=$a['trigger_run'];
    $status=$a['status'];
    if ($trigger_run == 'on') { 
?>
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">OFF </button>
	<input type="hidden" name="triggerrun" value="off" />
    </form>

<?php 
}
else
{
    $db = new PDO('sqlite:dbf/nettemp.db');
    $rows = $db->query("SELECT * FROM gpio WHERE mode='triggerout'");
    $row = $rows->fetchAll();
    foreach ($row as $b) {
    $sec=$a['gpio'];
    $to="tout$sec";
?>    
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" name="<?php echo $to; ?>"  <?php echo $b["$to"] == 'on' ? 'class="btn btn-xs btn-danger" value="off"' : 'class="btn btn-xs btn-primary" value="on"'; ?> onchange="this.form.submit()" ><?php echo $b['name']; ?></button>
    <input type="hidden" name="gpio" value="<?php echo $b['gpio'] ?>" />
    <input type="hidden" name="toutonoff" value="onoff" />
</form>
<?php
}
?>


    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-primary">ON</button>
	<input type="hidden" name="triggerrun" value="on" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggerexit" value="triggerexit" />
    </form>

<?php
}
//}
?>