<?php

$tel_anyonoff= isset($_POST['tel_anyonoff']) ? $_POST['tel_anyonoff'] : '';
$tel_any = isset($_POST['tel_any']) ? $_POST['tel_any'] : '';
if ($tel_anyonoff == "onoff") {
    $db->exec("UPDATE gpio SET tel_any='$tel_any' WHERE gpio='$gpio_post'") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$tel_at = isset($_POST['tel_at']) ? $_POST['tel_at'] : '';
$tel_at_onoff = isset($_POST['tel_at_onoff']) ? $_POST['tel_at_onoff'] : '';
if (($tel_at_onoff == "onoff") ){
    $db->exec("UPDATE gpio SET tel_at='$tel_at' where gpio='$gpio_post' ") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$callexit = isset($_POST['callexit']) ? $_POST['callexit'] : '';
if (($callexit == "callexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio' ") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$savenum = isset($_POST['savenum']) ? $_POST['savenum'] : '';
    if ($savenum == "savenum") {
    shell_exec("sudo /usr/bin/pkill -f call");
    $cmd=("nohup modules/gpio/call_proc");
    shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
    }
    
$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
$moment_time = isset($_POST['moment_time']) ? $_POST['moment_time'] : '';

if ($bi == "bi")  {
	 $db->exec("UPDATE gpio SET moment_time='$moment_time' where gpio='$gpio_post' ") or die("simple off db error");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<table class="table table-striped">
<tbody>
<th>Name</th><th>Tel</th>
</tbody>
<?php 
if ($a['tel_any'] != 'on') {
    $db = new PDO("sqlite:dbf/nettemp.db");
    $urows = $db->query("SELECT * FROM users where ctr='$gpio'");
    $uresult = $urows->fetchAll();
    foreach ($uresult as $ua) { ?>
    <tr><td><?php echo $ua['login'];?></td> <td><?php echo $ua['tel'];?></td></tr>
<?php
    }
 }
?>
<table>

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" name="tel_any"  <?php echo $a['tel_any'] == 'on' ? 'class="btn btn-xs btn-danger" value="off"' : 'class="btn btn-xs btn-success" value="on"'; ?> onchange="this.form.submit()" >Any number</button>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio'] ?>" />
    <input type="hidden" name="tel_anyonoff" value="onoff" />
</form>

<?php
if ($a['tel_any'] == 'on') {
?>

<form action="" method="post">
<select id="control" name="tel_at" onchange="this.form.submit()">
<?php $sth = $db->prepare("SELECT * FROM access_time");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $s) { ?>
    <option <?php echo $a['tel_at'] == $s['name'] ? 'selected="selected"' : ''; ?> value="<?php echo $s['name']; ?>"><?php echo $s['name'] ?></option>
<?php 
    } 
?>
    <option value="" <?php echo $a['tel_at'] == '' ? 'selected="selected"' : ''; ?>>Select time access profile</option>
    </select>
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<input type="hidden" name="tel_at_onoff" value="onoff" />
</form>

<?php 
   }
?>

Delay
<form action="" method="post" style=" display:inline!important;">
 	 <input type="number" name="moment_time" size="2" value="<?php echo $a['moment_time']; ?>" style="width: 4em;"/>
    <button type="submit" class="btn btn-xs btn-warning">Save</button>
    <input type="hidden" name="bi" value="on" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="bi" value="bi" />
</form>

<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="callexit" value="callexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

