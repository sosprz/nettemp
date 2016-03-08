<?php


$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
if ($bi == "bi")  {
    if ($a['rev'] == 'on') {
    exec("/usr/local/bin/gpio -g mode $gpio_post output && /usr/local/bin/gpio -g write $gpio_post 0 && sleep 0.5 &&  /usr/local/bin/gpio -g write $gpio_post 1");
    } else {
    exec("/usr/local/bin/gpio -g mode $gpio_post output && /usr/local/bin/gpio -g write $gpio_post 1 && sleep 0.5 && /usr/local/bin/gpio -g write $gpio_post 0");
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

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-warning">ON 1s OFF</button>
    <input type="hidden" name="bi" value="on" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="bi" value="bi" />
</form>
<!-- wy³¹czamy exit dla mapy -->
<?php if ($_GET['id'] != 'map'): ?>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="mexit" value="mexit" />
</form>
<?php endif; ?>

