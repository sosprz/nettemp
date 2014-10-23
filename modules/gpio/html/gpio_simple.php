<?php


$simpleon = isset($_POST['simpleon']) ? $_POST['simpleon'] : '';
if ($simpleon == "on")  {    
    //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET simple='on', status='ON' WHERE gpio='$gpio_post'") or die("PDO exec error");
    $db = null;
    //header("location: " . $_SERVER['REQUEST_URI']);
    //exit();
    }
$simpleoff = isset($_POST['simpleoff']) ? $_POST['simpleoff'] : '';
if ($simpleoff == "off")  {
    //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET simple='off', status='OFF' WHERE gpio='$gpio_post'") or die("PDO exec error");
    $db = null;
    //header("location: " . $_SERVER['REQUEST_URI']);
    //exit();
    }
$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
if ($bi == "bi")  {
    if ($a['rev'] == 'on') {
    exec("/usr/local/bin/gpio -g write $gpio_post 0 &&  /usr/local/bin/gpio -g write $gpio_post 1");
    } else {
    exec("/usr/local/bin/gpio -g write $gpio_post 1 &&  /usr/local/bin/gpio -g write $gpio_post 0");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$simpleexit = isset($_POST['simpleexit']) ? $_POST['simpleexit'] : '';
if (($simpleexit == "simpleexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

include('gpio_onoff.php');

   //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
   //$sth = $db->prepare("select * from gpio where gpio='$gpio'");
   //$sth->execute();
   //$result = $sth->fetchAll();    
   //foreach ($result as $a) { 
        if ( $a['simple'] == "on" ) { 

?>
<td>Status: <?php echo $a['status']; ?></td>
    <form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="off" value="off" />
    <input type="hidden" name="simpleoff" value="off" />
    </form>
<?php 
} 
    else 
    {
include('gpio_rev.php');
    ?>
<form action="" method="post">
    <td><input type="image" name="simpleexit" value="exit" src="media/ico/Close-2-icon.png" title="Back"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleexit" value="simpleexit" />
</form>
<form action="" method="post">
    <td><input type="image" name="bi" value="bi" src="media/ico/Button-Log-Off-icon.png" title="Turn on wait 1s and off"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
</form>


<td>Status: <?php echo $a['status']; ?></td>
<form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-On-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="on" value="on" />
    <input type="hidden" name="simpleon" value="on" />
</form>
    <?php 
    } 
//}
?>
