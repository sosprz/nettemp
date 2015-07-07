<?php
$tempexit = isset($_POST['tempexit']) ? $_POST['tempexit'] : '';
if ($tempexit == "tempexit"){
    $db->exec("UPDATE gpio SET mode='', day_run='', week_run='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$tempon = isset($_POST['tempon']) ? $_POST['tempon'] : '';
if ($tempon == "on") {
    $db->exec("UPDATE gpio SET temp_run='on', status='wait' WHERE gpio='$gpio_post'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

if ($tempon == "off") {
	include('gpio_off.php');
    $db->exec("UPDATE gpio SET temp_run='off' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$dayrunon = isset($_POST['dayrunon']) ? $_POST['dayrunon'] : '';
$dayrun = isset($_POST['dayrun']) ? $_POST['dayrun'] : '';
if ($dayrunon == "on")  {
    $db->exec("UPDATE gpio SET day_run='$dayrun'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$weekrunon = isset($_POST['weekrunon']) ? $_POST['weekrunon'] : '';
$weekrun = isset($_POST['weekrun']) ? $_POST['weekrun'] : '';
if ($weekrunon == "on")  {
    $db->exec("UPDATE gpio SET week_run='$weekrun'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

// MAIN

if ( $a['temp_run'] == "on") {

foreach (range(1, $tempnum) as $v) {
$sth = $db->prepare("SELECT * FROM sensors");
$sth->execute();
$result = $sth->fetchAll();
//foreach ($result as $select) {
//    if (($a['temp_sensor'.$v] == $select['id']) && (!empty($a['temp_temp'.$v]))) {
//    echo $select['name'];
//    echo $select['tmp'];
//    echo $a['temp_op'.$v];
//    echo $a['temp_temp'.$v];
//    echo $a['temp_onoff'.$v];
//    }
//}
}
?>
Status:<?php echo $a['status'];?>
<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="tempon" value="off" />
    <input type="hidden" name="off" value="off" />
</form>

<?php
} else {
?>
<?php 
    if ($a['day_run'] == 'on') { 
	include('gpio_day_forms.php');
	
    } 
    if ($a['week_run'] == 'on') { 
	include('gpio_week_forms.php');
    }
	include('gpio_temp_forms.php');
	
?>

<form action="" method="post" style=" display:inline!important;">
	    <button type="submit" name="dayrun" value="<?php echo $a["day_run"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["day_run"] == 'on' ? 'class="btn btn-xs btn-danger"' : 'class="btn btn-xs btn-primary"'; ?>  >Day</button>
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <input type="hidden" name="dayrunon" value="on" /> 
</form>
<form action="" method="post" style=" display:inline!important;">
	    <button type="submit" name="weekrun"  value="<?php echo $a["week_run"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["week_run"] == 'on' ? 'class="btn btn-xs btn-danger"' : 'class="btn btn-xs btn-primary"'; ?>  >Week</button>
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <input type="hidden" name="weekrunon" value="on" /> 
</form>
<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="tempon" value="on" />
    <button type="submit" class="btn btn-xs btn-primary">ON</button>
</form>
<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="tempexit" value="tempexit"/>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>



<?php
include('gpio_function_num.php');

}
?>

