<?php
$simpleoff = isset($_POST['simpleoff']) ? $_POST['simpleoff'] : '';
if (($simpleoff == "simpleoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$off = isset($_POST['off']) ? $_POST['off'] : '';
if ($off == "OFF") {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET simple_run='off', trigger_run='off', tempday_run='off', time_run='off', temp_run='off', day_run='off', time_start='off' WHERE gpio='$gpio_post'") or die("PDO exec error");
    $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
        if ( $a["gpio_rev_hilo"] == "on") { 
	    exec("/usr/local/bin/gpio -g write $gpio_post 1");	
	    }
	    else { 
	    exec("/usr/local/bin/gpio -g write $gpio_post 0");	
	    }
    }
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
   
}

$on = isset($_POST['on']) ? $_POST['on'] : '';
if ($on == "ON")  {
    exec("/usr/local/bin/gpio -g mode $gpio_post output");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET simple_run='on' WHERE gpio='$gpio_post'") or die("PDO exec error");
   $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
        if ( $a["gpio_rev_hilo"] == "on") { 
	    exec("/usr/local/bin/gpio -g write $gpio_post 0");	
	    }
	    else { 
	    exec("/usr/local/bin/gpio -g write $gpio_post 1");	
	    }
    }
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
   exit();
    }
?>

<form action="" method="post">
    <td><input type="image" name="simpleoff" value="off" src="media/ico/back-icon.png" title="Back"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleoff" value="simpleoff" />
    </form>
