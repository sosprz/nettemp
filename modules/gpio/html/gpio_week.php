<?php
$weekexit = isset($_POST['weekexit']) ? $_POST['weekexit'] : '';
if (($weekexit == "weekexit") ){
    $db->exec("UPDATE gpio SET mode='', day_run='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$day_zone1s = isset($_POST['day_zone1s']) ? $_POST['day_zone1s'] : '';
$day_zone1e = isset($_POST['day_zone1e']) ? $_POST['day_zone1e'] : '';
$day_zone2s = isset($_POST['day_zone2s']) ? $_POST['day_zone2s'] : '';
$day_zone2e = isset($_POST['day_zone2e']) ? $_POST['day_zone2e'] : '';
$day_zone3s = isset($_POST['day_zone3s']) ? $_POST['day_zone3s'] : '';
$day_zone3e = isset($_POST['day_zone3e']) ? $_POST['day_zone3e'] : '';

$weekrun = isset($_POST['weekrun']) ? $_POST['weekrun'] : '';
if ($weekrun == "on")  {
	 $db->exec("UPDATE gpio SET status='Wait',week_run='on' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }



if ($weekrun == "off")  {
	 include('gpio_off.php');
    $db->exec("UPDATE gpio SET week_run='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
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


    $week_run=$a['week_run'];
    if ($week_run == 'on') { 
?>

   
	Status: <?php echo $a['status']; ?>
	Mon: <?php echo $a['week_Mon']; ?> Tue:<?php echo $a['week_Tue']; ?> Wed:<?php echo $a['week_Wed']; ?> Thu:<?php echo $a['week_Thu']; ?> Fri:<?php echo $a['week_Fri']; ?> Sat:<?php echo $a['week_Sat']; ?> Sun:<?php echo $a['week_Sun']; ?> 
	<form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="weekrun" value="off" />
	<input type="hidden" name="off" value="off" />
        </form>

<?php 
    }
	else 
    {
?>
    
<?php
include('modules/gpio/html/gpio_week_forms.php');

?>


<form action="" method="post" style=" display:inline!important;">
    <button type="submit" name="dayrun" value="<?php echo $a["day_run"] == 'on' ? 'off' : 'on'; ?>" <?php echo $a["day_run"] == 'on' ? 'class="btn btn-xs btn-danger"' : 'class="btn btn-xs btn-info"'; ?>  >Day</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="dayrunon" value="on" /> 
</form>

<form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-info">ON</button>
	<input type="hidden" name="weekrun" value="on" />
</form>

<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="weekoff" value="off" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="weekexit" value="weekexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

<?php
    }
    //}
?>

