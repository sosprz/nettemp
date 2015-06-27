<?php

$triggeroutexit = isset($_POST['triggeroutexit']) ? $_POST['triggeroutexit'] : '';
if (($triggeroutexit == "triggeroutexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>

<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="triggeroutexit" value="triggeroutexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

