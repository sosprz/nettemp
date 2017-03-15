<?php
$gasexit = isset($_POST['gasexit']) ? $_POST['gasexit'] : '';
if (($gasexit == "gasexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db->exec("UPDATE sensors SET type='gpio' WHERE gpio='$gpio_post'") or die("exec error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$gasrun = isset($_POST['gasrun']) ? $_POST['gasrun'] : '';
if (($gasrun == "on") ){
    $db->exec("UPDATE gpio SET gas_run='on', status='ON' where gpio='$gpio_post' ") or die("simple off db error");
    $reset="/bin/bash modules/counters/reset_gas";
    shell_exec("$reset");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
if (($gasrun == "off") ){
    $db->exec("UPDATE gpio SET gas_run='', status='OFF' where gpio='$gpio_post' ") or die("simple off db error");
    //$reset="/bin/bash modules/gas/reset";
    //shell_exec("$reset");
    shell_exec("sudo pkill -f nettemp_gas");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$gas_divider = isset($_POST['gas_divider']) ? $_POST['gas_divider'] : '';
$gas_divider1 = isset($_POST['gas_divider1']) ? $_POST['gas_divider1'] : '';
if ($gas_divider1 == "gas_divider2"){
    if (!empty($gas_divider)){
	$gas_dividert = trim($gas_divider); 
	$db->exec("UPDATE gpio SET gas_divider='$gas_dividert' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/counters/reset_gas";
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

$gas_debouncing = isset($_POST['gas_debouncing']) ? $_POST['gas_debouncing'] : '';
$gas_debouncing1 = isset($_POST['gas_debouncing1']) ? $_POST['gas_debouncing1'] : '';
if ($gas_debouncing1 == "gas_debouncing2"){
    if (!empty($gas_debouncing)){
	$gas_debouncingt = trim($gas_debouncing); 
	$db->exec("UPDATE gpio SET gas_debouncing='$gas_debouncingt' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/counters/reset_gas";
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
  // $sth = $db->prepare("sgast * from gpio where gpio='$gpio'");
  // $sth->execute();
  // $result = $sth->fetchAll();    
   //foreach ($result as $a) {
    $gasrun=$a['gas_run'];
        if ($gasrun=='on') { 
?>
    Status: <?php echo $a['status']; ?>
	<form action="" method="post" style=" display:inline!important;">
	<input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="gasrun" value="off" />
    </form>

<?php 
} 
    else 
    {
    ?>
gas status: <?php echo $a['status']; ?>
<form action="" method="post" style=" display:inline!important;">
	Divider
	<input type="text" name="gas_divider" size="4" value="<?php echo $a["gas_divider"]; ?>"  />
	<input type="hidden" name="gas_divider1" value="gas_divider2" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
</form>
<form action="" method="post" style=" display:inline!important;">
	Debouncing time
	<input type="text" name="gas_debouncing" size="4" value="<?php echo $a["gas_debouncing"]; ?>"  />
	<input type="hidden" name="gas_debouncing1" value="gas_debouncing2" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
    </form>

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-success">ON</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="gasrun" value="on" />
</form>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="gasexit" value="gasexit" />
</form>



    <?php 
    } 
//}
?>
