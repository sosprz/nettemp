<div class="panel panel-default">
  <div class="panel-heading">Charts settings</div>
  <div class="panel-body">



<?php
    $chmin = isset($_POST['chmin']) ? $_POST['chmin'] : '';
    $set_chmin = isset($_POST['set_chmin']) ? $_POST['set_chmin'] : '';
    if  ($set_chmin == "set_chmin") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE highcharts SET charts_min='$chmin' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $chtheme = isset($_POST['chtheme']) ? $_POST['chtheme'] : '';
    $set_chtheme = isset($_POST['set_chtheme']) ? $_POST['set_chtheme'] : '';
    if  ($set_chtheme == "set_chtheme") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE highcharts SET charts_theme='$chtheme' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $chfast = isset($_POST['chfast']) ? $_POST['chfast'] : '';
    $set_chfast = isset($_POST['set_chfast']) ? $_POST['set_chfast'] : '';
    if  ($set_chfast == "set_chfast") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE highcharts SET charts_fast='$chfast' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from highcharts ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Sensors base update interval</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chmin" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("1","2","5","10", "15");
     foreach ($ar as $num) { ?>
        <option <?php echo $a['charts_min'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?> min</option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chmin" value="set_chmin" />
</form>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Theme</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chtheme" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("white","black","sand","grid");
     foreach ($ar as $num) { ?>
        <option <?php echo $a['charts_theme'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chtheme" value="set_chtheme" />
</form>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Fast view (don't get all data)</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chfast" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("on","off");
     foreach ($ar as $num) { ?>
        <option <?php echo $a['charts_fast'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chfast" value="set_chfast" />
</form>




<?php
}
?>




</div></div>


