<?php
$waterexit = isset($_POST['waterexit']) ? $_POST['waterexit'] : '';
if (($waterexit == "waterexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db->exec("UPDATE sensors SET type='gpio' WHERE gpio='$gpio_post'") or die("exec error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$waterrun = isset($_POST['waterrun']) ? $_POST['waterrun'] : '';
if (($waterrun == "on") ){
    $db->exec("UPDATE gpio SET water_run='on', status='ON' where gpio='$gpio_post' ") or die("simple off db error");
    $reset="/bin/bash modules/counters/reset_water";
    shell_exec("$reset");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
if (($waterrun == "off") ){
    $db->exec("UPDATE gpio SET water_run='', status='OFF' where gpio='$gpio_post' ") or die("simple off db error");
    //$reset="/bin/bash modules/water/reset";
    //shell_exec("$reset");
    shell_exec("sudo pkill -f nettemp_water");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$water_divider = isset($_POST['water_divider']) ? $_POST['water_divider'] : '';
$water_divider1 = isset($_POST['water_divider1']) ? $_POST['water_divider1'] : '';
if ($water_divider1 == "water_divider2"){
    if (!empty($water_divider)){
	$water_dividert = trim($water_divider); 
	$db->exec("UPDATE gpio SET water_divider='$water_dividert' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/counters/reset_water";
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
$water_debouncing = isset($_POST['water_debouncing']) ? $_POST['water_debouncing'] : '';
$water_debouncing1 = isset($_POST['water_debouncing1']) ? $_POST['water_debouncing1'] : '';
if ($water_debouncing1 == "water_debouncing2"){
    if (!empty($water_debouncing)){
	$water_debouncingt = trim($water_debouncing); 
	$db->exec("UPDATE gpio SET water_debouncing='$water_debouncingt' WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash modules/counters/reset_water";
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
  // $sth = $db->prepare("swatert * from gpio where gpio='$gpio'");
  // $sth->execute();
  // $result = $sth->fetchAll();    
   //foreach ($result as $a) {
    $waterrun=$a['water_run'];
        if ($waterrun=='on') { 
?>
    Status: <?php echo $a['status']; ?>
	<form action="" method="post" style=" display:inline!important;">
	<input type="image" src="media/ico/Button-Turn-Off-icon.png" title="Simple on/off" onclick="this.form.submit()" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="waterrun" value="off" />
    </form>

<?php 
} 
    else 
    {
    ?>
water status: <?php echo $a['status']; ?>
<form action="" method="post" style=" display:inline!important;">
	Divider
	<input type="text" name="water_divider" size="4" value="<?php echo $a["water_divider"]; ?>"  />
	<input type="hidden" name="water_divider1" value="water_divider2" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
</form>
<form action="" method="post" style=" display:inline!important;">
	Debouncing time
	<input type="text" name="water_debouncing" size="4" value="<?php echo $a["water_debouncing"]; ?>"  />
	<input type="hidden" name="water_debouncing1" value="water_debouncing2" />
	<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></button>
    </form>

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-success">ON</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="waterrun" value="on" />
</form>
<form action="" method="post" style=" display:inline!important;">
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="waterexit" value="waterexit" />
</form>



    <?php 
    } 
//}
?>
