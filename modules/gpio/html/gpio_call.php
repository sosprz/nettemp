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
?>

<table class="table table-striped">
<tbody>
<th>Name</th><th>Tel</th>
</tbody>
<?php 
    $db = new PDO("sqlite:dbf/nettemp.db");
    $rows = $db->query("SELECT * FROM users where ctr='$gpio'");
    $result = $rows->fetchAll();
    foreach ($result as $a) { ?>
    <tr><td><?php echo $a['login'];?></td> <td><?php echo $a['tel'];?></td></tr>
<?php
    }
?>
<table>

<form action="" method="post" style=" display:inline!important;">
    <button type="submit" name="tel_any"  <?php echo $a['tel_any'] == 'on' ? 'class="btn btn-xs btn-danger" value="off"' : 'class="btn btn-xs btn-info" value="on"'; ?> onchange="this.form.submit()" >Any number</button>
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


<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="callexit" value="callexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

