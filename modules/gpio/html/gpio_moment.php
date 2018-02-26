<?php


$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
$moment_time = isset($_POST['moment_time']) ? $_POST['moment_time'] : '';

if ($bi == "bi")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET moment_time='$moment_time' where gpio='$gpio_post' AND rom='$rom'") or die("moment off db error");
    if ($a['rev'] == 'on') {
    exec("/usr/local/bin/gpio -g mode $gpio_post output && /usr/local/bin/gpio -g write $gpio_post 0 && sleep $moment_time &&  /usr/local/bin/gpio -g write $gpio_post 1");
    } else {
    exec("/usr/local/bin/gpio -g mode $gpio_post output && /usr/local/bin/gpio -g write $gpio_post 1 && sleep $moment_time && /usr/local/bin/gpio -g write $gpio_post 0");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$mexit = isset($_POST['mexit']) ? $_POST['mexit'] : '';
if (($mexit == "mexit") ){
	include('gpio_off.php');
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='', status='off' where gpio='$gpio_post' AND rom='$rom'") or die("moment off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>

<form action="" method="post" style=" display:inline!important;">
 	 <input type="text" name="moment_time" size="4" value="<?php echo $a['moment_time']; ?>"/>
    <button type="submit" class="btn btn-xs btn-warning">ON <?php echo $a['moment_time']; ?>s OFF</button>
    <input type="hidden" name="bi" value="on" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="bi" value="bi" />
</form>
<!-- wy³¹czamy exit dla mapy -->
<?php if ($_GET['id'] != 'map'): ?>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="mexit" value="mexit" />
</form>
<?php endif; ?>

