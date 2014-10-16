<?php
$triggeroff = isset($_POST['triggeroff']) ? $_POST['triggeroff'] : '';

if (($triggeroff == "triggeroff") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("humid off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$triggeron = isset($_POST['triggeron']) ? $_POST['triggeron'] : '';
if ($triggeron == "triggerON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_run='on' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

    <form action="" method="post">
	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>" />
    </form>
    <form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="triggeron" value="triggerON" />
    </form>
    <form action="" method="post">
	<td><input type="image" name="triggeroff" value="off" src="media/ico/back-icon.png" title="Back"  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggeroff" value="triggeroff" />
    </form>
