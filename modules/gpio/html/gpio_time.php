<?php
$time_offset = isset($_POST['time_offset']) ? $_POST['time_offset'] : '';
$timeoff = isset($_POST['timeoff']) ? $_POST['timeoff'] : '';




//    $date = new DateTime();
//    $time_start=$date->getTimestamp();
//    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
//    $db->exec("UPDATE gpio SET time_offset='$time_offset',time_run='on',time_start='$time_start' WHERE gpio='$gpio_post'") or die("exec error");
//    $sth = $db1->prepare("select * from gpio where gpio='$gpio_post'");
//   $sth->execute();
 //  $result = $sth->fetchAll();    
  // foreach ($result as $a) { 
    //    if ( $a['gpio_rev_hilo'] == "on") { 
//	    exec("/usr/local/bin/gpio -g write $gpio_post 0");	
//	    }
//	    else { 
//	    exec("/usr/local/bin/gpio -g write $gpio_post 1");	
//	    }
//    }

if ($timeoff == "timeoff")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' WHERE gpio='$gpio_post'") or die("exec error");
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
	<td><input type="text" name="time_offset" value="<?php echo $a['time_offset']; ?>" size="8"  ></td><td>min</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="timeon" value="timeON" />
    </form>
    <form action="" method="post">
	<td><input type="image" name="time_checkbox" src="media/ico/back-icon.png" title="back" value="off"  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeoff" value="timeoff" />        
   </form>
