<?php
$kwhoff = isset($_POST['kwhoff']) ? $_POST['kwhoff'] : '';
if (($kwhoff == "kwhoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$gpio_kwh = isset($_POST['gpio_kwh']) ? $_POST['gpio_kwh'] : '';
$gpio_kwh1 = isset($_POST['gpio_kwh1']) ? $_POST['gpio_kwh1'] : '';
if (($gpio_kwh1 == "gpio_kwh2") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
        $sth->execute();
        $result = $sth->fetchAll();    
    foreach ($result as $a) { 
	if ( $a["gpio_kwh"] == "on") { 
	$db->exec("UPDATE gpio SET gpio_kwh='off' where gpio='$gpio_post' ") or die("exec error");
    $db->exec("UPDATE settings SET kwh=''") or die("exec error");
    $reset="/bin/bash modules/kwh/reset";
        shell_exec("$reset");
	}
	else { 
	$db->exec("UPDATE gpio SET gpio_kwh='on' where gpio='$gpio_post' ") or die("exec error");
    $db->exec("UPDATE settings SET kwh='on'") or die("exec error");
    $reset="/bin/bash modules/kwh/reset";
        shell_exec("$reset");

	}
   }
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

    <form action="" method="post">
	<td>kWh <?php echo $a["gpio_kwh"]; ?></td>
	<td><input type="image" src="media/ico/Lamp-icon.png" title="kWh metter" name="gpio_kwh" value="on" <?php echo $a["gpio_kwh"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio_kwh1" value="gpio_kwh2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
       </form>
    <?php include('modules/kwh/html/kwh_options.php'); ?>
    <form action="" method="post">
	<td><input type="image" name="kwhoff" value="off" src="media/ico/back-icon.png" title="Back"   onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="kwhoff" value="kwhoff" />
    </form>
