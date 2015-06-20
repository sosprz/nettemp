<?php


$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
if ($bi == "bi")  {
    if ($a['rev'] == 'on') {
    exec("/usr/local/bin/gpio -g write $gpio_post 0 && sleep 0.5 &&  /usr/local/bin/gpio -g write $gpio_post 1");
    } else {
    exec("/usr/local/bin/gpio -g write $gpio_post 1 && sleep 0.5 && /usr/local/bin/gpio -g write $gpio_post 0");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$mexit = isset($_POST['mexit']) ? $_POST['mexit'] : '';
if (($mexit == "mexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>

<?php include('gpio_rev.php'); ?>

<form action="" method="post">
    <input type="image" name="simpleexit" value="exit" src="media/ico/Close-2-icon.png" title="Back"   onclick="this.form.submit()" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="mexit" value="mexit" />
</form>
<form action="" method="post">
    <input type="image" name="bi" value="on" src="media/ico/Button-Log-Off-icon.png" title="Turn on wait 1s and off"   onclick="this.form.submit()" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="bi" value="bi" />
</form>

