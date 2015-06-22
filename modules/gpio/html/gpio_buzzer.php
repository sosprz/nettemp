<?php

$buzzerexit = isset($_POST['buzzerexit']) ? $_POST['buzzerexit'] : '';
if (($buzzerexit == "buzzerexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>
<img type="image" src="media/ico/speaker-icon.png" title="Buzzer on" " />
<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="buzzerexit" value="buzzerexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

