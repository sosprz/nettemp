<?php
$rand=substr(rand(), 0, 4);
$distexit = isset($_POST['distexit']) ? $_POST['distexit'] : '';

if (($distexit == "distexit") ){
    $id_rom_newh='gpio_2324_dist';
    $id_rom_h='gpio_2324_dist.sql';

    $db->exec("UPDATE gpio SET mode='', status='' where gpio='$gpio_post' ") or die ("dist off db error");
    $db->exec("DELETE FROM sensors WHERE rom='$id_rom_newh' "); 
    $db->exec("DELETE FROM newdev WHERE list='$id_rom_newh'"); 
    unlink("db/$id_rom_h");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
    <?php echo "Distance GPIO ".$a['gpio']?> 
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="dist" value="off"/>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="distexit" value="distexit" />
    </form>
    