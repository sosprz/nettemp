<?php
$dayoff = isset($_POST['dayoff']) ? $_POST['dayoff'] : '';
if (($dayoff == "dayoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$day_zone1s = isset($_POST['day_zone1s']) ? $_POST['day_zone1s'] : '';
$day_zone1e = isset($_POST['day_zone1e']) ? $_POST['day_zone1e'] : '';
$dayon = isset($_POST['dayon']) ? $_POST['dayon'] : '';
if ($dayon == "dayON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET day_run='on', day_zone1s='$day_zone1s',day_zone1e='$day_zone1e'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
?>

    
   <form action="" method="post">
	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
   </form>
    <form action="" method="post">
	<td>Start time</td>
	<td><input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="8"  ></td><td></td> 
	<td>End time</td>
	<td><input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="8"  ></td><td></td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="dayon" value="dayON" />
    </form>
    <form action="" method="post">
	<td><input type="image" name="dayoff" value="off" src="media/ico/back-icon.png" title="Back" onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayoff" value="dayoff" />        
   </form>