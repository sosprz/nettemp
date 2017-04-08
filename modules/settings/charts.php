<div class="panel panel-default">
  <div class="panel-heading">Charts settings</div>
  <div class="panel-body">



<?php
    $charts = isset($_POST['charts']) ? $_POST['charts'] : '';
    $set_charts = isset($_POST['set_charts']) ? $_POST['set_charts'] : '';
    if  ($set_charts == "set_charts") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$charts' WHERE option='charts_default'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $chmin = isset($_POST['chmin']) ? $_POST['chmin'] : '';
    $set_chmin = isset($_POST['set_chmin']) ? $_POST['set_chmin'] : '';
    if  ($set_chmin == "set_chmin") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$chmin' WHERE option='charts_min'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $chtheme = isset($_POST['chtheme']) ? $_POST['chtheme'] : '';
    $set_chtheme = isset($_POST['set_chtheme']) ? $_POST['set_chtheme'] : '';
    if  ($set_chtheme == "set_chtheme") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$chtheme' WHERE option='charts_theme'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $chfast = isset($_POST['chfast']) ? $_POST['chfast'] : '';
    $set_chfast = isset($_POST['set_chfast']) ? $_POST['set_chfast'] : '';
    if  ($set_chfast == "set_chfast") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$chfast' WHERE option='charts_fast'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $chmax = isset($_POST['chmax']) ? $_POST['chmax'] : '';
    $set_chmax = isset($_POST['set_chmax']) ? $_POST['set_chmax'] : '';
    if  ($set_chmax == "set_chmax") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$chmax' WHERE option='charts_max'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Charts</label>
  <div class="col-md-2">
    <select id="selectbasic" name="charts" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("Highcharts","NVD3");
     foreach ($ar as $num) { ?>
        <option <?php echo $nts_charts_default == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_charts" value="set_charts" />
</form>


<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Sensors base update interval</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chmin" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("1","2","5","10", "15");
     foreach ($ar as $num) { ?>
        <option <?php echo $nts_charts_min == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?> min</option>   
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
  <label class="col-md-2 control-label" for="selectbasic">Highcharts theme</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chtheme" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("white","black","sand","grid");
     foreach ($ar as $num) { ?>
        <option <?php echo $nts_charts_theme == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
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
        <option <?php echo $nts_charts_fast == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chfast" value="set_chfast" />
</form>

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Set default chart MAX</label>
  <div class="col-md-2">
    <select id="selectbasic" name="chmax" onchange="this.form.submit()" class="form-control input-sm">
    <?php $ar=array("hour","day", "week", "month");
     foreach ($ar as $num) { ?>
        <option <?php echo $nts_charts_max == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num ." "; ?></option>   
    <?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_chmax" value="set_chmax" />
</form>





</div></div>


