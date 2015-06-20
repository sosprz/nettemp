<?php
$weekexit = isset($_POST['weekexit']) ? $_POST['weekexit'] : '';
if (($weekexit == "weekexit") ){
    $db->exec("UPDATE gpio SET mode='', day_run='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$Mon = isset($_POST['Mon']) ? $_POST['Mon'] : '';
$MonMon = isset($_POST['MonMon']) ? $_POST['MonMon'] : '';
    if ( $Mon == "Mon" ) {
    $db->exec("UPDATE gpio SET week_Mon='$MonMon' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Tue = isset($_POST['Tue']) ? $_POST['Tue'] : '';
$TueTue = isset($_POST['TueTue']) ? $_POST['TueTue'] : '';
    if ( $Tue == "Tue" ) {
    $db->exec("UPDATE gpio SET week_Tue='$TueTue' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Wed = isset($_POST['Wed']) ? $_POST['Wed'] : '';
$WedWed = isset($_POST['WedWed']) ? $_POST['WedWed'] : '';
    if ( $Wed == "Wed" ) {
    $db->exec("UPDATE gpio SET week_Wed='$WedWed' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Thu = isset($_POST['Thu']) ? $_POST['Thu'] : '';
$ThuThu = isset($_POST['ThuThu']) ? $_POST['ThuThu'] : '';
    if ( $Thu == "Thu" ) {
    $db->exec("UPDATE gpio SET week_Thu='$ThuThu' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Fri = isset($_POST['Fri']) ? $_POST['Fri'] : '';
$FriFri = isset($_POST['FriFri']) ? $_POST['FriFri'] : '';
    if ( $Fri == "Fri" ) {
    $db->exec("UPDATE gpio SET week_Fri='$FriFri' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Sun = isset($_POST['Sun']) ? $_POST['Sun'] : '';
$SunSun = isset($_POST['SunSun']) ? $_POST['SunSun'] : '';
    if ( $Sun == "Sun" ) {
    $db->exec("UPDATE gpio SET week_Sun='$SunSun' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Sat = isset($_POST['Sat']) ? $_POST['Sat'] : '';
$SatSat = isset($_POST['SatSat']) ? $_POST['SatSat'] : '';
    if ( $Sat == "Sat" ) {
    $db->exec("UPDATE gpio SET week_Sat='$SatSat' where gpio='$gpio_post' ") or die("simple off db error");
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
	<form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="image" src="media/ico/Button-Turn-Off-icon.png"/>
	<input type="hidden" name="weekrun" value="off" />
	<input type="hidden" name="off" value="off" />
        </form>

<?php 
    }
	else 
    {
include('gpio_rev.php');

?>
    
    <form action="" method="post">
		<input type="image" name="weekoff" value="off" src="media/ico/Close-2-icon.png" title="Back" onclick="this.form.submit()" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="weekexit" value="weekexit" />        
   </form>
   <form action="" method="post">
	    <img  src="media/ico/day-icon.png" title="Day plan" />
	    <input type="checkbox" name="dayrun" value="on" <?php echo $a["day_run"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" />
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <input type="hidden" name="dayrunon" value="on" /> 
	</form>
Day of the week:


<?php
$arr = array(Mon, Tue, Wed, Thu, Fri, Sat, Sun);
foreach ($arr as &$days) {
?>
	<form action="" method="post">
	
	<label><?php echo $days ?></label>
   <input type="checkbox" name="<?php echo $days; echo $days; ?>" value="on" <?php echo $a['week_'.$days] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="<?php echo $days; ?>" value="<?php echo $days; ?>"/>
	
	</form>
<?php
}
?>




    <form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="image" src="media/ico/Button-Turn-On-icon.png"/>
	<input type="hidden" name="weekrun" value="on" />
	
	
    </form>
<?php
    }
    //}
?>

