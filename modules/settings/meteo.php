<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$save = isset($_POST['save']) ? $_POST['save'] : '';
$lat = isset($_POST['lat']) ? $_POST['lat'] : '';
$hei = isset($_POST['hei']) ? $_POST['hei'] : '';
$tem = isset($_POST['tem']) ? $_POST['tem'] : '';
$pre = isset($_POST['pre']) ? $_POST['pre'] : '';
$hum = isset($_POST['hum']) ? $_POST['hum'] : '';


if ($save == "save") {
    $db->exec("UPDATE meteo SET temp='$tem',pressure='$pre',latitude='$lat',height='$hei',humid='$hum' WHERE id='1'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	

}

$met = $db->prepare("SELECT * FROM meteo WHERE id='1'");
$met->execute();
$resultmet = $met->fetchAll();
foreach ($resultmet as $m) { 
?>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Temperature</label>
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
  <label class="col-md-4 control-label" for="selectbasic">Humidity</label>
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
  <label class="col-md-4 control-label" for="selectbasic">Pressure</label>
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
  <label class="col-md-4 control-label" for="textinput">Latitude</label>  
  <div class="col-md-4">
  <input id="textinput" name="lat" value="<?php echo $m['latitude'];?> " placeholder="placeholedder" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Height</label>  
  <div class="col-md-4">
  <input id="textinput" name="hei" value="<?php echo $m['height'];?>" placeholder="placeholder" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
    <input type="hidden" name="save" value="save" />
  </div>
</div>

</fieldset>
</form>
<?php }
?>



<?php
$met1 = $db->prepare("SELECT * FROM meteo WHERE id='1'");
$met1->execute();
$resultmet1 = $met1->fetchAll();
foreach ($resultmet1 as $me) { 
    $szerokosc=$me['latitude'];
    $wysokosc=$me['height'];
    $idtmp=$me['temp'];
    $idpre=$me['pressure'];
    $idhum=$me['humid'];
}

$sth = $db->prepare("select tmp from sensors where id='$idtmp'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$temperatura=$a['tmp'];
}

$sth = $db->prepare("select tmp from sensors where id='$idpre'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$cisnienie=$a['tmp'];
}

$sth = $db->prepare("select tmp from sensors where id='$idhum'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$wilgotnosc=$a['tmp'];
}


echo "sila grawitacji [m/s^2]";
echo $sila_grawitacji=9.780313*(pow(1+0.005324*SIN($szerokosc),2)-0.0000058*pow(SIN(2*$szerokosc),2)-0.000003085*$wysokosc);
echo "<br>";
echo "temp znormalizowana [K]";
echo $temp_znormalizowana=((2*($temperatura+273.15))+((0.6*$wysokosc)/100))/2;
echo "<br>";
echo "temp znormalizowana [C]";
echo $temp_znormalizowana-273,15;
echo "<br>";
echo "cisnienie znormalizowane [hPa]";
echo ($cisnienie*(EXP(($sila_grawitacji*$wysokosc)/(287.05*$temp_znormalizowana)))*10)/10;
echo "<br>";
echo "temperatura punku rosy [°C]";
echo 243.12*(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura))/(17.62-(((LOG10($wilgotnosc)-2)/0.4343)+(17.5*$temperatura)/(243.12+$temperatura)));
echo "<br>";
echo "cisnienie pary wodnej nasyconej [hPa]";
echo $cisnienie_pary_nasyconej=6.112*EXP((17.67*$temperatura)/($temperatura+243.5));
echo "<br>";
echo "cisnienie pary wodnej [hPa]";
echo $cisnienie_pary=$wilgotnosc/(1/$cisnienie_pary_nasyconej)/100;
echo "<br>";
echo "wilgotnosc bezwzgledna [g/m^3]";
echo 2165*(($cisnienie_pary/10)/(273.15+$temperatura));
echo "<br>";
?>