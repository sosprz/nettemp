<?php
$dayexit = isset($_POST['dayexit']) ? $_POST['dayexit'] : '';
if (($dayexit == "dayexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
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

$dayrun = isset($_POST['dayrun']) ? $_POST['dayrun'] : '';
if ($dayrun == "on")  {
	 include('gpio_on.php');
    $db->exec("UPDATE gpio SET status='Wait',day_run='on' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$dayset = isset($_POST['dayset']) ? $_POST['dayset'] : '';
if ($dayset == "on")  {
    $db->exec("UPDATE gpio SET day_zone1s='$day_zone1s',day_zone1e='$day_zone1e',day_zone2s='$day_zone2s',day_zone2e='$day_zone2e',day_zone3s='$day_zone3s',day_zone3e='$day_zone3e'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }


if ($dayrun == "off")  {
	 include('gpio_off.php');
    $db->exec("UPDATE gpio SET day_run='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }


    $day_run=$a['day_run'];
    if ($day_run == 'on') { 
?>

  
	Status:<?php echo $a['status']; ?> 
	
	<table>
	<?php echo $a['day_zone1s']; ?>-<?php echo $a['day_zone1e']; ?>  
	<?php echo $a['day_zone2s']; ?>-<?php echo $a['day_zone2e']; ?> 
	<?php echo $a['day_zone3s']; ?>-<?php echo $a['day_zone3e']; ?> 
	</table>
	
	  <form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="image" src="media/ico/Button-Turn-Off-icon.png"/>
	<input type="hidden" name="dayrun" value="off" />
	<input type="hidden" name="off" value="off" />
    </form>

<?php 
    }
	else 
    {
include('gpio_rev.php');
?>
    
    <form action="" method="post">
	<input type="image" name="dayoff" value="off" src="media/ico/Close-2-icon.png" title="Back" onclick="this.form.submit()" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayexit" value="dayexit" />        
   </form>
   
    <form action="" method="post">
	Set hour range:
	Zone 1 <input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="3" placeholder="08:00"  >-<input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="3" placeholder="11:00"> 
	Zone 2 <input type="text" name="day_zone2s" value="<?php echo $a['day_zone2s']; ?>" size="3" placeholder="12:30" >-<input type="text" name="day_zone2e" value="<?php echo $a['day_zone2e']; ?>" size="3" placeholder="16:30"> 
	Zone 3 <input type="text" name="day_zone3s" value="<?php echo $a['day_zone3s']; ?>" size="3" placeholder="20:15" >-<input type="text" name="day_zone3e" value="<?php echo $a['day_zone3e']; ?>" size="3" placeholder="06:00"> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="image" src="media/ico/Actions-edit-redo-icon.png"/>
	<input type="hidden" name="dayset" value="on" />
    </form>
    <form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="image" src="media/ico/Button-Turn-On-icon.png"/>
	<input type="hidden" name="dayrun" value="on" />
	
	
    </form>
<?php
    }
    //}
?>

