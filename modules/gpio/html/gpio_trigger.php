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
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
if ($triggerrun == "off")  {
    $db->exec("UPDATE gpio SET trigger_run='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    exec("/usr/local/bin/gpio -g write $buzzergpio 0");
    exec("/usr/local/bin/gpio -g write $triggeroutgpio 0");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


    $trigger_run=$a['trigger_run'];
    $status=$a['status'];
    if ($trigger_run == 'on') { 
?>
    Status: <?php echo $status ?>
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">OFF </button>
	<input type="hidden" name="triggerrun" value="off" />
    </form>

<?php 
}
else
{
?>
    
    Status: OFF
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-primary">ON</button>
	<input type="hidden" name="triggerrun" value="on" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="triggerexit" value="off" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="buzzer" value="<?php echo $buzzer; ?>"/>
	<input type="hidden" name="triggerexit" value="triggerexit" />
    </form>

<?php
}
//}
?>