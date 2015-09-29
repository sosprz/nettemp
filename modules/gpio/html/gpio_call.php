<?php

$callexit = isset($_POST['callexit']) ? $_POST['callexit'] : '';
if (($callexit == "callexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or exit(header("Location: html/errors/db_error.php"));
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$savenum = isset($_POST['savenum']) ? $_POST['savenum'] : '';
$tel_num1 = isset($_POST['tel_num1']) ? $_POST['tel_num1'] : '';
$tel_num2 = isset($_POST['tel_num2']) ? $_POST['tel_num2'] : '';
$tel_num3 = isset($_POST['tel_num3']) ? $_POST['tel_num3'] : '';
    if ($savenum == "savenum") {
    $db->exec("UPDATE gpio SET tel_num1='$tel_num1',tel_num2='$tel_num2',tel_num3='$tel_num3' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    shell_exec("sudo /usr/bin/pkill -f call");
    $cmd=("nohup modules/gpio/call_proc");
    shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
?>

<form class="form-horizontal" method="post">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Tel. number 1</label>  
  <div class="col-md-4">
  <input id="textinput" name="tel_num1" placeholder="" class="form-control input-md" type="text" value="<?php echo $a['tel_num1']; ?>">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Tel. number 2</label>  
  <div class="col-md-4">
  <input id="textinput" name="tel_num2" placeholder="" class="form-control input-md" type="text" value="<?php echo $a['tel_num2']; ?>">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Tel. number 3</label>  
  <div class="col-md-4">
  <input id="textinput" name="tel_num3" placeholder="" class="form-control input-md" type="text" value="<?php echo $a['tel_num3']; ?>">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
  </div>
</div>
</fieldset>
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<input type="hidden" name="savenum" value="savenum" />
</form>



<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="callexit" value="callexit" />
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

