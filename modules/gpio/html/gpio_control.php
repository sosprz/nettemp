<?php
$control = isset($_POST['control']) ? $_POST['control'] : '';
$save = isset($_POST['save']) ? $_POST['save'] : '';
if (($save == "save") ){
    $db->exec("UPDATE gpio SET control='$control' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$exit = isset($_POST['exit']) ? $_POST['exit'] : '';
if (($exit == "control_exit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$controlrun = isset($_POST['controlrun']) ? $_POST['controlrun'] : '';
if ($controlrun == "on")  {
    $db->exec("UPDATE gpio SET control_run='on', status='Wait' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    $cmd=("nohup modules/gpio/control_proc $gpio_post");
    shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
if ($controlrun == "off")  {
    $db->exec("UPDATE gpio SET control_run='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    shell_exec("modules/gpio/control_close $gpio_post");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}




    if ($a['control_run'] == 'on') { 
?>
    <form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-danger">OFF </button>
    <input type="hidden" name="controlrun" value="off" />
    </form>

<?php 
}
else
{
?>
<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="control">Select function</label>
  <div class="col-md-2">
    <select id="control" name="control" class="form-control input-sm" onchange="this.form.submit()">
<?php $sth = $db->prepare("SELECT * FROM gpio WHERE mode='trigger'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $s) { ?>
    <option <?php echo $a['control'] == $s['gpio'] ? 'selected="selected"' : ''; ?> value="<?php echo $s['gpio']; ?>"><?php echo $s['name'] ?></option>
<?php 
    } 
?>
    <option value="" <?php echo $a['control'] == '' ? 'selected="selected"' : ''; ?>>-</option>
    </select>
  </div>
</div>
<input type="hidden" name="save" value="save"/>
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
</fieldset>
</form>

<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-primary">ON</button>
    <input type="hidden" name="controlrun" value="on" />
</form>

<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="exit" value="control_exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>
<?php
}
?>

