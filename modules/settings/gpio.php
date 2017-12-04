<?php
    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $gpio_onoff1 = isset($_POST['gpio_onoff1']) ? $_POST['gpio_onoff1'] : '';
    if (($gpio_onoff1 == "gpio_onoff2") ){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE nt_settings SET value='$gpio_onoff' WHERE option='gpio'") or die ($db->lastErrorMsg());
		echo $gpio_onoff;
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }
    
    $gpiodemo = isset($_POST['gpiodemo']) ? $_POST['gpiodemo'] : '';
    $gpiodemo_onoff = isset($_POST['gpiodemo_onoff']) ? $_POST['gpiodemo_onoff'] : '';
    if (($gpiodemo == "onoff") ){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE nt_settings SET value='$gpiodemo_onoff' WHERE option='gpio_demo'") or die ($db->lastErrorMsg());
		echo $gpio_onoff;
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }


    $MCP23017_onoff = isset($_POST['MCP23017_onoff']) ? $_POST['MCP23017_onoff'] : '';
    $MCP23017_onoff1 = isset($_POST['MCP23017_onoff1']) ? $_POST['MCP23017_onoff1'] : '';
    if (($MCP23017_onoff1 == "MCP23017_onoff2") ){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE nt_settings SET value='$MCP23017_onoff' WHERE option='MCP23017'") or die ($db->lastErrorMsg());
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }


?>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO RPI</h3>
</div>
<div class="panel-body"> 
<form action="" method="post">
  <input type="hidden" name="gpio_onoff1" value="gpio_onoff2"  />
  <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="gpio_onoff" value="on"  <?php echo $nts_gpio == 'on' ? 'checked="checked"' : ''; ?> >
</form>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO demo (fake gpio)</h3>
</div>
<div class="panel-body"> 
<form action="" method="post">
  <input type="hidden" name="gpiodemo" value="onoff"  />
  <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="gpiodemo_onoff" value="on"  <?php echo $nts_gpio_demo == 'on' ? 'checked="checked"' : ''; ?> >
</form>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO MCP23017</h3>
</div>
<div class="panel-body">
<form action="" method="post">
  <input type="hidden" name="MCP23017_onoff1" value="MCP23017_onoff2"  />
  <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="MCP23017_onoff" value="on"  <?php echo $nts_MCP23017 == 'on' ? 'checked="checked"' : ''; ?> >
</form>
</div>
</div>

