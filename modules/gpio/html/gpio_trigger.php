<?php
$triggernotice_checkbox = isset($_POST['triggernotice_checkbox']) ? $_POST['triggernotice_checkbox'] : '';
$xtriggernoticeon = isset($_POST['xtriggernoticeon']) ? $_POST['xtriggernoticeon'] : '';
if ($xtriggernoticeon == "xtriggernoticeON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_notice='$triggernotice_checkbox' WHERE gpio='$gpio_post' AND rom='$rom'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$triggerexit = isset($_POST['triggerexit']) ? $_POST['triggerexit'] : '';
if (($triggerexit == "triggerexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' AND rom='$rom' ") or exit(header("Location: html/errors/db_error.php"));
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$triggerrun = isset($_POST['triggerrun']) ? $_POST['triggerrun'] : '';
if ($triggerrun == "on")  {
    $db->exec("UPDATE gpio SET trigger_run='on', status='Wait' WHERE gpio='$gpio_post' AND rom='$rom'") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    $cmd=("nohup modules/gpio/trigger_proc $gpio_post");
    shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
if ($triggerrun == "off")  {
    $db->exec("UPDATE gpio SET trigger_run='', status='WWW OFF' WHERE gpio='$gpio_post' AND rom='$rom'") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    shell_exec("modules/gpio/trigger_close $gpio_post");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$toutonoff = isset($_POST['toutonoff']) ? $_POST['toutonoff'] : '';

$tout = isset($_POST['tout']) ? $_POST['tout'] : '';
$togpio = isset($_POST['togpio']) ? $_POST['togpio'] : '';
$rom2 = isset($_POST['rom2']) ? $_POST['rom2'] : '';
if (($toutonoff == "onoff") &&  (!empty($tout)))  {
  
    $db->exec("UPDATE gpio SET trigout ='$tout' WHERE gpio='$togpio' AND rom='$rom'") or exit(header("Location: html/errors/db_error.php"));
	$db->exec("UPDATE gpio SET trigsource ='$togpio' WHERE gpio='$tout' AND rom='$rom2'") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


$trigger_delay = isset($_POST['trigger_delay']) ? $_POST['trigger_delay'] : '';
$trigger_delay1 = isset($_POST['trigger_delay1']) ? $_POST['trigger_delay1'] : '';
if ($trigger_delay1 == "trigger_delay1") {
    $db->exec("UPDATE gpio SET trigger_delay='$trigger_delay' WHERE gpio='$gpio_post' AND rom='$rom'") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$con = isset($_POST['con']) ? $_POST['con'] : '';
$cononoff = isset($_POST['cononoff']) ? $_POST['cononoff'] : '';
if ($cononoff == "onoff") {
    $db->exec("UPDATE gpio SET trigger_con='$con' WHERE gpio='$gpio_post' AND rom='$rom'") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


    $trigger_run=$a['trigger_run'];
    $status=$a['status'];
    if ($trigger_run == 'on') { 
?>
    <form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-danger">OFF </button>
	<input type="hidden" name="triggerrun" value="off" />
    </form>

<?php 
}
else
{
    $db = new PDO('sqlite:dbf/nettemp.db');
    $rows = $db->query("SELECT * FROM gpio WHERE mode='triggerout'");
    $row = $rows->fetchAll();
    foreach ($row as $b) {
    //$sec=$a['gpio'];
	$trout=$b['gpio'];
    //$to="tout$sec";
?>    
<form action="" method="post" style=" display:inline!important;">
    
	<input type="hidden" name="togpio" value="<?php echo $a['gpio']; ?>" />
	<input type="hidden" name="rom2" value="<?php echo $b['rom']; ?>" />
	<input type="hidden" name="tout" value="<?php echo $trout; ?>" />
    <input type="hidden" name="toutonoff" value="onoff" />
	<button type="submit" name="aname"  <?php echo $b["trigsource"] == $a["gpio"] ? 'class="btn btn-xs btn-danger"' : 'class="btn btn-xs btn-success"'; ?> onchange="this.form.submit()" ><?php echo $b['name']; ?></button>
</form>
<?php
}
?>
     <form action="" method="post" style=" display:inline!important;">
	 <select name="trigger_delay" onchange="this.form.submit()">
	    <option <?php echo $a['trigger_delay'] == "" ? 'selected="selected"' : ''; ?> value="">Start delay 0</option>
	    <option <?php echo $a['trigger_delay'] == "5" ? 'selected="selected"' : ''; ?> value="5">Start delay 5 sec</option>
	    <option <?php echo $a['trigger_delay'] == "10" ? 'selected="selected"' : ''; ?> value="10">Start delay 10 sec</option>
	    <option <?php echo $a['trigger_delay'] == "30" ? 'selected="selected"' : ''; ?> value="30">Start delay 30 sec</option>
	    <option <?php echo $a['trigger_delay'] == "60" ? 'selected="selected"' : ''; ?> value="60">Start delay 1 min</option>
	    <option <?php echo $a['trigger_delay'] == "120" ? 'selected="selected"' : ''; ?> value="120">Start delay 2 min</option>
	    <option <?php echo $a['trigger_delay'] == "300" ? 'selected="selected"' : ''; ?> value="360">Start delay 5 min</option>
	</select> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="trigger_delay1" value="trigger_delay1" />
    </form>

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" name="con"  <?php echo $a['trigger_con'] == 'on' ? 'class="btn btn-xs btn-danger" value="off"' : 'class="btn btn-xs btn-success" value="on"'; ?> onchange="this.form.submit()" >Continous mode</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio'] ?>" />
    <input type="hidden" name="cononoff" value="onoff" />
</form>

<form method="post" type="submit" style=" display:inline!important;">
    <button type="submit" name="triggernotice_checkbox"  <?php echo $a['trigger_notice'] == 'on' ? 'class="btn btn-xs btn-danger" value=""' : 'class="btn btn-xs btn-success" value="on"'; ?> onchange="this.form.submit()" >Send mail</button>
    <!-- <input type="checkbox" name="triggernotice_checkbox" value="on" <?php echo $a["trigger_notice"] == 'on' ? 'checked="checked"' : ''; ?> data-toggle="toggle" data-size="mini" onchange="this.form.submit()" /></div> -->
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="xtriggernoticeon" value="xtriggernoticeON" />
</form>

<form action="" method="post" style=" display:inline!important;">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-success">ON</button>
	<input type="hidden" name="triggerrun" value="on" />
</form>

<form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-danger">Exit</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggerexit" value="triggerexit" />
</form>

<?php
}
?>