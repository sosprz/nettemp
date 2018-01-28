<?php
$triggeroutexit = isset($_POST['triggeroutexit']) ? $_POST['triggeroutexit'] : '';
if (($triggeroutexit == "triggeroutexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' AND rom='$rom' ") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
<img type="image" src="media/ico/light-icon.png" title="trigger Out" " />
<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="triggeroutexit" value="triggeroutexit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

