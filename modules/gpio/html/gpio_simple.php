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
    <form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">OFF </button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleoff" value="off" />
    </form>
<?php 
} 
    else 
    {
    ?>

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-success">ON</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleon" value="on" />
</form>
<!-- //dodany warunek ¿eby na mapie nie wyœwietlaæ EXIT -->
<?php if ($_GET['id'] != 'map' ): ?>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="simpleexit" value="simpleexit" />
</form>
<?php endif; ?>
    <?php 
    } 
//}
?>
