<?php
$gpio_rev = isset($_POST['gpio_rev']) ? $_POST['gpio_rev'] : '';
$gpio_rev1 = isset($_POST['gpio_rev1']) ? $_POST['gpio_rev1'] : '';
if (($gpio_rev1 == "gpio_rev1") ){
    //exec("/usr/local/bin/gpio -g mode $gpio_post output");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
    $sth->execute();
    $result = $sth->fetchAll();    
    foreach ($result as $a) { 
	if ( $a['rev'] == "on") { 
	$db->exec("UPDATE gpio SET rev='' where gpio='$gpio_post' ") or die("exec error");
	}
	else { 
	$db->exec("UPDATE gpio SET rev='on' where gpio='$gpio_post' ") or die("exec error");
	}
   }
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<form action="" method="post">
    <?php if ( $a['rev'] == "on"){ ?>
    <td><input type="image" src="media/ico/Letter-L-icon.png" title="Reverse state HIGH to LOW" onclick="this.form.submit()"/></td>
    <?php } else { ?>
    <td><input type="image" src="media/ico/Letter-H-icon.png" title="Reverse state HIGH to LOW" onclick="this.form.submit()"/></td>
    <?php } ?>
    <input type="hidden" name="gpio_rev1" value="gpio_rev1" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
</form>


    