<?php
$gpio_rev = isset($_POST['gpio_rev']) ? $_POST['gpio_rev'] : '';
$gpio_rev1 = isset($_POST['gpio_rev1']) ? $_POST['gpio_rev1'] : '';
if (($gpio_rev1 == "gpio_rev1") ){
	if ( $gpio_rev == "on") { 
	$db->exec("UPDATE gpio SET rev='on' where gpio='$gpio_post' ") or die("exec error");
	}
	else { 
	$db->exec("UPDATE gpio SET rev='' where gpio='$gpio_post' ") or die("exec error");
	}
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<form action="" method="post" style=" display:inline!important;">
    <?php if ( $a['rev'] === "on"){ ?>
    <button class="btn btn-xs btn-primary">LOW</button>
    <input type="hidden" name="gpio_rev" value="" />
    <?php } else { ?>
    <button class="btn btn-xs btn-danger">HIGH</button>
    <input type="hidden" name="gpio_rev" value="on" />
    <?php } ?>
    <input type="hidden" name="gpio_rev1" value="gpio_rev1" />
    
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
</form>


    