<?php
$day_zone1s = isset($_POST['day_zone1s']) ? $_POST['day_zone1s'] : '';
$day_zone1e = isset($_POST['day_zone1e']) ? $_POST['day_zone1e'] : '';
$day_zone2s = isset($_POST['day_zone2s']) ? $_POST['day_zone2s'] : '';
$day_zone2e = isset($_POST['day_zone2e']) ? $_POST['day_zone2e'] : '';
$day_zone3s = isset($_POST['day_zone3s']) ? $_POST['day_zone3s'] : '';
$day_zone3e = isset($_POST['day_zone3e']) ? $_POST['day_zone3e'] : '';

$dayset = isset($_POST['dayset']) ? $_POST['dayset'] : '';
if ($dayset == "on")  {
    $db->exec("UPDATE gpio SET day_zone1s='$day_zone1s',day_zone1e='$day_zone1e',day_zone2s='$day_zone2s',day_zone2e='$day_zone2e',day_zone3s='$day_zone3s',day_zone3e='$day_zone3e'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
?>

<fieldset>
<!-- Form Name -->
<legend>Day plan</legend>
  <form action="" method="post" role="form" class="form-horizontal">
    <div class="form-group">
     <label class="col-sm-1">Zone 1</label>
      <div class="col-sm-1"><input class="form-control" placeholder="08:00" type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>"></div>
      <div class="col-sm-1"><input class="form-control" placeholder="10:00" type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>"></div>
    </div>
    <div class="form-group">
    <label class="col-sm-1">Zone 2</label>
      <div class="col-sm-1"><input class="form-control" placeholder="13:00" type="text" name="day_zone2s" value="<?php echo $a['day_zone2s']; ?>"></div>
      <div class="col-sm-1"><input class="form-control" placeholder="16:15" type="text" name="day_zone2e" value="<?php echo $a['day_zone2e']; ?>"></div>
    </div>
    <div class="form-group">
    <label class="col-sm-1">Zone 3</label>
      <div class="col-sm-1"><input class="form-control" placeholder="19:00" type="text" name="day_zone3s" value="<?php echo $a['day_zone3s']; ?>"></div>
      <div class="col-sm-1"><input class="form-control" placeholder="21:30" type="text" name="day_zone3e" value="<?php echo $a['day_zone3e']; ?>"></div>
    </div>
    <div class="form-group">
      <div class="col-sm-6">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<button type="submit" class="btn btn-xs btn-success">SAVE</button>
	<input type="hidden" name="dayset" value="on" />
      </div>
    </div>
  </form>
</fieldset>