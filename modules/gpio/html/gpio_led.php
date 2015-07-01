<?php

$ledexit = isset($_POST['ledexit']) ? $_POST['ledexit'] : '';
if (($ledexit == "ledexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>
<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="ledexit" value="ledexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

