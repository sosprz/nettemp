<?php
$elecexit = isset($_POST['elecexit']) ? $_POST['elecexit'] : '';
if (($elecexit == "elecexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db->exec("UPDATE sensors SET type='gpio' WHERE gpio='$gpio_post'") or die("exec error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$elecrun = isset($_POST['elecrun']) ? $_POST['elecrun'] : '';
if (($elecrun == "on") ){
    $db->exec("UPDATE gpio SET elec_run='on', status='ON' where gpio='$gpio_post' ") or die("simple off db error");
    $reset="/bin/bash modules/counters/reset_elec";
    shell_exec("$reset");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
if (($elecrun == "off") ){
    $db->exec("UPDATE gpio SET elec_run='', status='OFF' where gpio='$gpio_post' ") or die("simple off db error");
    //$reset="/bin/bash modules/elec/reset";
    //shell_exec("$reset");
    shell_exec("sudo pkill -f nettemp_elec");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$elec_divider = isset($_POST['elec_divider']) ? $_POST['elec_divider'] : '';
$elec_divider1 = isset($_POST['elec_divider1']) ? $_POST['elec_divider1'] : '';
if ($elec_divider1 == "elec_divider2"){
    if (!empty($elec_divider)){
	$elec_dividert = trim($elec_divider); 
	$db->exec("UPDATE gpio SET elec_divider='$elec_dividert' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/counters/reset_elec";
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

$elec_debouncing = isset($_POST['elec_debouncing']) ? $_POST['elec_debouncing'] : '';
$elec_debouncing1 = isset($_POST['elec_debouncing1']) ? $_POST['elec_debouncing1'] : '';
if ($elec_debouncing1 == "elec_debouncing2"){
    if (!empty($elec_debouncing)){
	$elec_debouncingt = trim($elec_debouncing); 
	$db->exec("UPDATE gpio SET elec_debouncing='$elec_debouncingt' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/counters/reset_elec";
	shell_exec("$reset");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
     } 
else 
    { 
    ?> 
	<font color="red">debouncing cannot be empty!</font> 
    <?php 
    }
}

  // $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
  // $sth = $db->prepare("select * from gpio where gpio='$gpio'");
  // $sth->execute();
  // $result = $sth->fetchAll();    
   //foreach ($result as $a) {
    $elecrun=$a['elec_run'];
        if ($elecrun=='on') { 
?>
    Status: <?php echo $a['status']; ?>
	<form action="" method="post" style=" display:inline!important;">
	<input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="elecrun" value="off" />
    </form>

<?php 
} 
    else 
    {
    ?>
elec status: <?php echo $a['status']; ?>
<form action="" method="post" style=" display:inline!important;">
	Divider
	<input type="text" name="elec_divider" size="4" value="<?php echo $a["elec_divider"]; ?>"  />
	<input type="hidden" name="elec_divider1" value="elec_divider2" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
</form>
<form action="" method="post" style=" display:inline!important;">
	Debouncing time
	<input type="text" name="elec_debouncing" size="4" value="<?php echo $a["elec_debouncing"]; ?>"  />
	<input type="hidden" name="elec_debouncing1" value="elec_debouncing2" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
</form>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-success">ON</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="elecrun" value="on" />
</form>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="elecexit" value="elecexit" />
</form>



    <?php 
    } 
//}
?>
