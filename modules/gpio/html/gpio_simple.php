<?php


$simpleon = isset($_POST['simpleon']) ? $_POST['simpleon'] : '';
if ($simpleon == "on")  {    
    $db->exec("UPDATE gpio SET simple='on', status='ON' WHERE gpio='$gpio_post'") or die("PDO exec error");
    include('gpio_on.php');
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$simpleoff = isset($_POST['simpleoff']) ? $_POST['simpleoff'] : '';
if ($simpleoff == "off")  {
    $db->exec("UPDATE gpio SET simple='off', status='OFF' WHERE gpio='$gpio_post'") or die("PDO exec error");
    include('gpio_off.php');
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

        if ( $a['simple'] == "on" ) { 

?>
<td>Status: <?php echo $a['status']; ?></td>
    <form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
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

<td>Status: <?php echo $a['status']; ?></td>
<form action="" method="post">
    <td><input type="image" src="media/ico/Button-Turn-On-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleon" value="on" />
</form>
    <?php 
    } 
//}
?>
