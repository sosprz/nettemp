<?php
$simpleexit = isset($_POST['simpleexit']) ? $_POST['simpleexit'] : '';
if (($simpleexit == "simpleexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$off = isset($_POST['off']) ? $_POST['off'] : '';
if ($off == "off") {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET simple='off' WHERE gpio='$gpio_post'") or die("PDO exec error");
    $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
        if ( $a["rev"] == "on") { 
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
if ($on == "on")  {
    exec("/usr/local/bin/gpio -g mode $gpio_post output");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET simple='on' WHERE gpio='$gpio_post'") or die("PDO exec error");
   $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
        if ( $a["rev"] == "on") { 
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
<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
   $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
        if ( empty($a["simple"])) { 
?>
<form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="off" value="off" />
</form>
<?php 
} 
else 
{
?>
<form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-On-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="on" value="on" />
</form>
<?php } }?>


<form action="" method="post">
    <td><input type="image" name="simpleexit" value="exit" src="media/ico/back-icon.png" title="Back"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleexit" value="simpleexit" />
</form>
