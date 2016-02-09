<?php


$timeexit = isset($_POST['timeexit']) ? $_POST['timeexit'] : '';
if ($timeexit == "timeexit")  {
    $db->exec("UPDATE gpio SET mode='' WHERE gpio='$gpio_post'") or die("exec error");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$time_offset = isset($_POST['time_offset']) ? $_POST['time_offset'] : '';
$timerun = isset($_POST['timerun']) ? $_POST['timerun'] : '';
if ($timerun == "timerun") {
    include('gpio_on.php');
    $date = new DateTime();
    $time_start=$date->getTimestamp();
    $db->exec("UPDATE gpio SET time_run='on', status='ON $time_offset min', time_offset='$time_offset',time_start='$time_start' WHERE gpio='$gpio_post'") or die("exec error");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();

}

if ($timerun == "off") {
    $date = new DateTime();
    include('gpio_off.php');
    $time_start=$date->getTimestamp();
    $db->exec("UPDATE gpio SET time_run='', time_start='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();

}

    $time_run=$a['time_run'];
    if ($time_run == 'on') { 
?>

    <form action="" method="post" style=" display:inline!important;">
	Status: <?php echo $a['status']; ?> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">OFF </button>
	<input type="hidden" name="timerun" value="off" />
	<input type="hidden" name="off" value="off" />
    </form>

    <?php
    } 
    else {

?>
    
    <form action="" method="post" style=" display:inline!important;">
	<input type="text" name="time_offset" value="<?php echo $a['time_offset']; ?>" size="4"  >min 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-success">ON</button>
	<input type="hidden" name="timerun" value="timerun" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="time_checkbox" value="off"  />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeexit" value="timeexit" />
   </form>

<?php 
    }
//    }
?> 
