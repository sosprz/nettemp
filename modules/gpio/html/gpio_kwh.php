<?php
$kwhexit = isset($_POST['kwhexit']) ? $_POST['kwhexit'] : '';
if (($kwhexit == "kwhexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$kwhrun = isset($_POST['kwhrun']) ? $_POST['kwhrun'] : '';
if (($kwhrun == "on") ){
    $db->exec("UPDATE gpio SET kwh_run='on', status='ON' where gpio='$gpio_post' ") or die("simple off db error");
    $reset="/bin/bash modules/kwh/reset";
    shell_exec("$reset");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
if (($kwhrun == "off") ){
    $db->exec("UPDATE gpio SET kwh_run='', status='OFF' where gpio='$gpio_post' ") or die("simple off db error");
    //$reset="/bin/bash modules/kwh/reset";
    //shell_exec("$reset");
    shell_exec("sudo pkill -f nettemp_kwh");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$kwh_divider = isset($_POST['kwh_divider']) ? $_POST['kwh_divider'] : '';
$kwh_divider1 = isset($_POST['kwh_divider1']) ? $_POST['kwh_divider1'] : '';
if ($kwh_divider1 == "kwh_divider2"){
    if (!empty($kwh_divider)){
	$kwh_dividert = trim($kwh_divider); 
	$db->exec("UPDATE gpio SET kwh_divider='$kwh_dividert' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/kwh/reset";
	shell_exec("$reset");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
     } 
else 
    { 
    ?> 
	<font color="red">Divider cannot be empty!</font> 
    <?php 
    }
}

  // $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
  // $sth = $db->prepare("select * from gpio where gpio='$gpio'");
  // $sth->execute();
  // $result = $sth->fetchAll();    
   //foreach ($result as $a) {
    $kwhrun=$a['kwh_run'];
        if ($kwhrun=='on') { 
?>
    Status: <?php echo $a['status']; ?>
	<form action="" method="post" style=" display:inline!important;">
	<input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="kwhrun" value="off" />
    </form>

<?php 
} 
    else 
    {
    ?>
kWh status: <?php echo $a['status']; ?>
<form action="" method="post" style=" display:inline!important;">
	Divider
	<input type="text" name="kwh_divider" size="2" value="<?php echo $a["kwh_divider"]; ?>"  />
	<input type="hidden" name="kwh_divider1" value="kwh_divider2" />
	<button type="submit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></button>
    </form>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-info">ON</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="kwhrun" value="on" />
</form>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="kwhexit" value="kwhexit" />
</form>



    <?php 
    } 
//}
?>
