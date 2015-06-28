<?php

$trigger_source = isset($_POST['trigger_source']) ? $_POST['trigger_source'] : '';
$save = isset($_POST['save']) ? $_POST['save'] : '';
if (($save == "save") ){
    $db->exec("UPDATE gpio SET trigger_source='$trigger_source' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$triggeroutexit = isset($_POST['triggeroutexit']) ? $_POST['triggeroutexit'] : '';
if (($triggeroutexit == "triggeroutexit") ){
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="trigger_source">Select control source</label>
  <div class="col-md-1">
    <select id="trigger_source" name="trigger_source" class="form-control" onchange="this.form.submit()">
<?php $sth = $db->prepare("SELECT * FROM gpio WHERE mode='trigger'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $s) { ?>
    <option <?php echo $a['trigger_source'] == $s['gpio'] ? 'selected="selected"' : ''; ?> value="<?php echo $s['gpio']; ?>" ><?php echo $s['gpio'] ?></option>
<?php 
    } 
?>
    </select>
  </div>
</div>
<input type="hidden" name="save" value="save"/>
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
</fieldset>
</form>



<form action="" method="post" style=" display:inline!important;">
    <input type="hidden" name="simpleexit" value="exit" />
    <input type="hidden" name="triggeroutexit" value="triggeroutexit" />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <button type="submit" class="btn btn-xs btn-danger">Exit</button>
</form>

