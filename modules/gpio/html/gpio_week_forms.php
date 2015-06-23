<?php
$Mon = isset($_POST['Mon']) ? $_POST['Mon'] : '';
$Tue = isset($_POST['Tue']) ? $_POST['Tue'] : '';
$Wed = isset($_POST['Wed']) ? $_POST['Wed'] : '';
$Thu = isset($_POST['Thu']) ? $_POST['Thu'] : '';
$Fri = isset($_POST['Fri']) ? $_POST['Fri'] : '';
$Sun = isset($_POST['Sun']) ? $_POST['Sun'] : '';
$Sat = isset($_POST['Sat']) ? $_POST['Sat'] : '';

$weekcheck = isset($_POST['weekcheck']) ? $_POST['weekcheck'] : '';

    if ($weekcheck == "weekcheck") {
    $db->exec("UPDATE gpio SET week_Sat='$Sat', week_Sun='$Sun', week_Fri='$Fri', week_Thu='$Thu', week_Wed='$Wed', week_Tue='$Tue', week_Mon='$Mon' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>
<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Week plan</legend>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <!-- <label class="col-md-2 control-label" for="checkboxes">Week plan</label>-->
  <div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
      <input name="Mon" id="checkboxes-0" value="on" <?php echo $a["week_Mon"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Mon
    </label>
    <label class="checkbox-inline" for="checkboxes-1">
      <input name="Tue" id="checkboxes-1" value="on" <?php echo $a["week_Tue"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Tue
    </label>
    <label class="checkbox-inline" for="checkboxes-2">
      <input name="Wed" id="checkboxes-2" value="on" <?php echo $a["week_Wed"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Wed
    </label>
    <label class="checkbox-inline" for="checkboxes-3">
      <input name="Thu" id="checkboxes-3" value="on" <?php echo $a["week_Thu"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Thu
    </label>
    <label class="checkbox-inline" for="checkboxes-4">
      <input name="Fri" id="checkboxes-4" value="on" <?php echo $a["week_Fri"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Fri
    </label>
    <label class="checkbox-inline" for="checkboxes-5">
      <input name="Sun" id="checkboxes-5" value="on" <?php echo $a["week_Sun"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Sun
    </label>
    <label class="checkbox-inline" for="checkboxes-6">
      <input name="Sat" id="checkboxes-6" value="on" <?php echo $a["week_Sat"] == 'on' ? 'checked="checked"' : ''; ?>  type="checkbox" onclick="this.form.submit()" />
      Sat
    </label>
     <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
     <input type="hidden" name="weekcheck" value="weekcheck"/>
  </div>
</div>

</fieldset>
</form>




