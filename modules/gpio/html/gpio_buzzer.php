<?php

$buzzerexit = isset($_POST['buzzerexit']) ? $_POST['buzzerexit'] : '';
if (($buzzerexit == "buzzerexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>
<td><input type="image" src="media/ico/speaker-icon.png" title="Buzzer on" onclick="this.form.submit()" /></td>
<form action="" method="post">
    <td><input type="image" name="simpleexit" value="exit" src="media/ico/Close-2-icon.png" title="Back"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="buzzerexit" value="buzzerexit" />
</form>

