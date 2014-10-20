<?php


$timeexit = isset($_POST['timeexit']) ? $_POST['timeexit'] : '';
if ($timeexit == "timeexit")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$time_offset = isset($_POST['time_offset']) ? $_POST['time_offset'] : '';
$timerun = isset($_POST['timerun']) ? $_POST['timerun'] : '';
if ($timerun == "timerun") {
    $date = new DateTime();
    $time_start=$date->getTimestamp();
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET time_run='on', status='$time_offset', time_offset='$time_offset',time_start='$time_start' WHERE gpio='$gpio_post'") or die("exec error");
}

if ($timerun == "off") {
    $date = new DateTime();
    $time_start=$date->getTimestamp();
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET time_run='', time_start='' WHERE gpio='$gpio_post'") or die("exec error");
}

include('gpio_onoff.php');


$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db->prepare("select * from gpio where gpio='$gpio'");
    $sth->execute();
    $result = $sth->fetchAll();    
    foreach ($result as $a) { 
    $time_run=$a['time_run'];
    if ($time_run == 'on') { 
?>

    <form action="" method="post">
	<td>Status: <?php echo $a['status']; ?> min</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-Off-icon.png"/></td>
	<input type="hidden" name="timerun" value="off" />
	<input type="hidden" name="off" value="off" />
    </form>

    <?php
    } 
    else {

include('gpio_rev.php');

?>
    <form action="" method="post">
	<td><input type="image" name="time_checkbox" src="media/ico/Close-2-icon.png" title="back" value="off"  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeexit" value="timeexit" />
   </form>

    <form action="" method="post">
	<td><input type="text" name="time_offset" value="<?php echo $a['time_offset']; ?>" size="8"  ></td><td>min</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="timerun" value="timerun" />
	<input type="hidden" name="on" value="on" />
    </form>
<?php 
    }
    }
?> 
