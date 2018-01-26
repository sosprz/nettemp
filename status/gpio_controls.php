<?php 
session_start();
$root=$_SERVER["DOCUMENT_ROOT"];
if(isset($_SESSION['user'])){
	
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$sth = $db->prepare("SELECT id FROM gpio WHERE mode='simple' OR mode='trigger' OR mode='call' OR mode='moment'");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { 
?>	
<div class="grid-item">
<div class="panel panel-default">
<div class="panel-heading">
	<h3 class="panel-title">GPIO</h3>
</div>
<div class="panel-body">
<?php

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : '';
$perms = isset($_SESSION["perms"]) ? $_SESSION["perms"] : '';


$dir="modules/gpio/";
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");

$simple = isset($_POST['simple']) ? $_POST['simple'] : '';
$onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
$rev = isset($_POST['rev']) ? $_POST['rev'] : '';
if (($onoff == "onoff")){
    
    if ($simple == 'on'){
	include('modules/gpio/html/gpio_on.php');
	$db->exec("UPDATE gpio SET simple='$simple', status='ON' WHERE gpio='$gpio_post'") or exit(header("Location: html/errors/db_error.php"));
    } else { 
	include('modules/gpio/html/gpio_off.php');
	$db->exec("UPDATE gpio SET simple='$simple', status='OFF' WHERE gpio='$gpio_post'") or exit(header("Location: html/errors/db_error.php"));
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
$moment_time = isset($_POST['moment_time']) ? $_POST['moment_time'] : '';
if ($bi == "bi")  {
    if ($rev == 'on') {
    exec("/usr/local/bin/gpio -g mode $gpio_post output && /usr/local/bin/gpio -g write $gpio_post 0 && sleep $moment_time &&  /usr/local/bin/gpio -g write $gpio_post 1");
    } else {
    exec("/usr/local/bin/gpio -g mode $gpio_post output && /usr/local/bin/gpio -g write $gpio_post 1 && sleep $moment_time && /usr/local/bin/gpio -g write $gpio_post 0");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$triggeronoff = isset($_POST['triggeronoff']) ? $_POST['triggeronoff'] : '';
$trigger = isset($_POST['trigger']) ? $_POST['trigger'] : '';
if ($triggeronoff == "onoff")  {
    if ( $trigger == 'on' ) {
	$db->exec("UPDATE gpio SET trigger_run='on', status='Wait' WHERE gpio='$gpio_post'") or exit(header("Location: html/errors/db_error.php"));
	$db = null;
	$cmd=("nohup modules/gpio/trigger_proc $gpio_post");
        shell_exec( $cmd . "> /dev/null 2>/dev/null &" );

    } else {
	$db->exec("UPDATE gpio SET trigger_run='', status='CONTROLS OFF' WHERE gpio='$gpio_post'") or exit(header("Location: html/errors/db_error.php"));
	$db = null;
	shell_exec("modules/gpio/trigger_close $gpio_post");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


if( $perms == 'usr' && $accesstime == 'yes') {
    $row = $db->prepare("SELECT * FROM users where login='$user'") or exit(header("Location: html/errors/db_error.php"));
    $row->execute();
    $result = $row->fetchAll();
    foreach ( $result as $u) {
	$call=$u['ctr'];
	$simple=$u['simple'];
	$trigger=$u['trigger'];
	$moment=$u['moment'];
	
    }

$simple->execute();
$results = $simple->fetchAll();
$moment->execute();
$resultm = $moment->fetchAll();
$trigger->execute();
$resultt = $trigger->fetchAll();
$call->execute();
$resultc = $call->fetchAll();

}
elseif ($perms == 'adm') {
$simple = $db->prepare("select * from gpio where mode='simple'") or exit(header("Location: html/errors/db_error.php"));
$call = $db->prepare("select * from gpio where mode='call'") or exit(header("Location: html/errors/db_error.php"));
$trigger = $db->prepare("select * from gpio where mode='trigger'") or exit(header("Location: html/errors/db_error.php"));
$moment = $db->prepare("select * from gpio where mode='moment'") or exit(header("Location: html/errors/db_error.php"));
$simple->execute();
$results = $simple->fetchAll();
$moment->execute();
$resultm = $moment->fetchAll();
$trigger->execute();
$resultt = $trigger->fetchAll();
$call->execute();
$resultc = $call->fetchAll();

}

foreach ( $results as $a) {
?>
<form class="form-horizontal" action="" method="post">
<fieldset>

<div class="form-group">
  <label class="col-md-5 control-label" for="simple"><?php echo $a['name']; ?></label>
	<div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
		<input type="checkbox" title="Simple on/off" data-toggle="toggle"  onchange="this.form.submit()" name="simple"  value="on" <?php echo $a['simple'] == 'on' ? 'checked="checked"' : ''; ?>  />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="rev" value="<?php echo $a['rev']; ?>"/>
		<input type="hidden" name="onoff" value="onoff" />
    </label>
   </div>
</div>

</fieldset>
</form>
<?php 
}


foreach ( $resultm as $a) {
?>
<form class="form-horizontal" action="" method="post">
<fieldset>

<div class="form-group">
  <label class="col-md-5 control-label" for="bi"><?php echo $a['name']; ?></label>
	<div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
		<input data-onstyle="warning" type="checkbox" data-toggle="toggle" name="bi" value="on" onchange="this.form.submit()" title=""   onclick="this.form.submit()" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="rev" value="<?php echo $a['rev']; ?>"/>
		<input type="hidden" name="bi" value="bi" />
		<input type="hidden" name="moment_time" value="<?php echo $a['moment_time']; ?>" />    
    </label>
   </div>
</div>

</fieldset>
</form>
<?php 
}


foreach ( $resultt as $a) {
?>
<form class="form-horizontal" action="" method="post">
<fieldset>

<div class="form-group">
  <label class="col-md-5 control-label" for="trigger"><?php echo $a['name']; ?></label>
	<div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
    <input type="checkbox" data-toggle="toggle" name="trigger" value="on" <?php echo $a['trigger_run'] == 'on' ? 'checked="checked"' : ''; ?>  onchange="this.form.submit()" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="triggeronoff" value="onoff" />
    </label>
   </div>
</div>

</fieldset>
</form>
<?php 
}


foreach ( $resultc as $a) {
?>
<form class="form-horizontal" action="" method="post">
<fieldset>

<div class="form-group">
  <label class="col-md-5 control-label" for="bi"><?php echo $a['name']; ?></label>
	<div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
    <input data-onstyle="warning" type="checkbox" data-toggle="toggle" name="bi" value="on" onchange="this.form.submit()"  title="Turn on wait 1s and off"   onclick="this.form.submit()" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="rev" value="<?php echo $a['rev']; ?>"/>
    <input type="hidden" name="bi" value="bi" />
    <input type="hidden" name="moment_time" value="<?php echo $a['moment_time']; ?>" />
    </label>
   </div>
</div>

</fieldset>
</form>
<?php 
}
?>
</div>
</div>
</div>
<?php 
}
}
?>

