<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$save = isset($_POST['save']) ? $_POST['save'] : '';
$lat = isset($_POST['lat']) ? $_POST['lat'] : '';
$hei = isset($_POST['hei']) ? $_POST['hei'] : '';
$tem = isset($_POST['tem']) ? $_POST['tem'] : '';
$pre = isset($_POST['pre']) ? $_POST['pre'] : '';
$hum = isset($_POST['hum']) ? $_POST['hum'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';


if ($save == "save") {
    $db->exec("UPDATE meteo SET temp='$tem',pressure='$pre',latitude='$lat',height='$hei',humid='$hum' WHERE id='1'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	

}

if ($onoff == "onoff") {
    $db->exec("UPDATE meteo SET onoff='$status' WHERE id='1'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	

}
?>
<div class="panel panel-default">
<div class="panel-heading">Meteo settings</div>
<div class="panel-body">

<?php
$met = $db->prepare("SELECT * FROM meteo WHERE id='1'");
$met->execute();
$resultmet = $met->fetchAll();
foreach ($resultmet as $m) { 
?>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Temperature [°C]</label>
  <div class="col-md-4">
    <select id="selectbasic" name="tem" class="form-control">
    <?php 
    $sth = $db->prepare("SELECT * FROM sensors where type='temp'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $s) { ?>
      <option <?php echo $m['temp'] == $s['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $s['id'];?>"><?php echo "{$s['name']} {$s['tmp']}"?></option>
    <?php 
    } 
    ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Humidity [%]</label>
  <div class="col-md-4">
    <select id="selectbasic" name="hum" class="form-control">
    <?php 
    $sth = $db->prepare("SELECT * FROM sensors where type='humid'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $s) { ?>
      <option <?php echo $m['humid'] == $s['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $s['id'];?>"><?php echo "{$s['name']} {$s['tmp']}"?></option>
    <?php 
    } 
    ?>

    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Pressure [hPa]</label>
  <div class="col-md-4">
    <select id="selectbasic" name="pre" class="form-control">
    <?php 
    $sth = $db->prepare("SELECT * FROM sensors where type='press'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $s) { ?>
      <option <?php echo $m['pressure'] == $s['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $s['id'];?>"><?php echo "{$s['name']} {$s['tmp']}"?></option>
    <?php 
    } 
    ?>

    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Latitude [°]</label>  
  <div class="col-md-4">
  <input id="textinput" name="lat" value="<?php echo $m['latitude'];?> " placeholder="placeholedder" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Height [m]</label>  
  <div class="col-md-4">
  <input id="textinput" name="hei" value="<?php echo $m['height'];?>" placeholder="placeholder" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-default">Save</button>
    <input type="hidden" name="save" value="save" />
  </div>
</div>
</fieldset>
</form>
<form action="" method="post">
    <label>Meteo status</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="status" value="on" <?php echo $m['onoff'] == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="onoff" value="onoff" />
    </form>

<?php }
?>
</div>
</div>
<?php
include('meteo_status.php');
?>



