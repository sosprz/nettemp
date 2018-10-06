<?php
    $csave = isset($_POST['csave']) ? $_POST['csave'] : '';
    $cip = isset($_POST['cip']) ? $_POST['cip'] : '';
	$cport = isset($_POST['cport']) ? $_POST['cport'] : '';
    $ckey = isset($_POST['ckey']) ? $_POST['ckey'] : '';
    if ($csave == "csave"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$cip' WHERE option='client_ip'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE nt_settings SET value='$ckey' WHERE option='client_key'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE nt_settings SET value='$cport' WHERE option='client_port'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $ssave = isset($_POST['ssave']) ? $_POST['ssave'] : '';
    $skey = isset($_POST['skey']) ? $_POST['skey'] : '';
    if ($ssave == "ssave"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$skey' WHERE option='server_key'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $conoff = isset($_POST['conoff']) ? $_POST['conoff'] : '';
    $con = isset($_POST['con']) ? $_POST['con'] : '';
    if (($conoff == "conoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$con' WHERE option='client_on'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $cauth_onoff = isset($_POST['cauth_onoff']) ? $_POST['cauth_onoff'] : '';
    $cauth_on = isset($_POST['cauth_on']) ? $_POST['cauth_on'] : '';
    if (($cauth_onoff == "cauth_onoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$cauth_on' WHERE option='cauth_on'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    
    $cauth_save = isset($_POST['cauth_save']) ? $_POST['cauth_save'] : '';
    $cauth_pass = isset($_POST['cauth_pass']) ? $_POST['cauth_pass'] : '';
    if ($cauth_save == "cauth_save"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$cauth_pass' WHERE option='cauth_pass'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
	
	$domoticzsave = isset($_POST['domoticzsave']) ? $_POST['domoticzsave'] : '';
    $domoticzip = isset($_POST['domoticzip']) ? $_POST['domoticzip'] : '';
	$domoticzport = isset($_POST['domoticzport']) ? $_POST['domoticzport'] : '';
   
    if ($domoticzsave == "domoticzsave"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$domoticzip' WHERE option='domoip'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE nt_settings SET value='$domoticzport' WHERE option='domoport'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
	$domoticzon = isset($_POST['domoticzon']) ? $_POST['domoticzon'] : '';
	$domoon = isset($_POST['domoon']) ? $_POST['domoon'] : '';
	
	if ($domoticzon == "domoticzon"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$domoon' WHERE option='domoon'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
	$domoauth_onoff = isset($_POST['domoauth_onoff']) ? $_POST['domoauth_onoff'] : '';
    $domoauth_on = isset($_POST['domoauth_on']) ? $_POST['domoauth_on'] : '';
    if (($domoauth_onoff == "domoauth_onoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$domoauth_on' WHERE option='domoauth'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
	
	$domoauth_save = isset($_POST['domoauth_save']) ? $_POST['domoauth_save'] : '';
    $domo_pass = isset($_POST['domo_pass']) ? $_POST['domo_pass'] : '';
	$domo_login = isset($_POST['domo_login']) ? $_POST['domo_login'] : '';
    if ($domoauth_save == "domoauth_save"){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$domo_pass' WHERE option='domopass'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE nt_settings SET value='$domo_login' WHERE option='domolog'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	

$cip=$nts_client_ip;
$cport=$nts_client_port;
$ckey=$nts_client_key;
$skey=$nts_server_key;
$con=$nts_client_on;
$cauth_on=$nts_cauth_on;
$cauth_login=$nts_cauth_login;
$cauth_pass=$nts_cauth_pass;
?>


<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Nettemp Server</h3>
</div>
<div class="panel-body">

<form action="" method="post">
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="con" value="on" <?php echo $con == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="conoff" value="conoff" />
</form>

<?php
if ($con == 'on'){
?>


<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">IP/Hostname</label>  
  <div class="col-md-4">
  <input id="textinput" name="cip" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $cip; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Port</label>  
  <div class="col-md-4">
  <input id="textinput" name="cport" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $cport; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Key</label>  
  <div class="col-md-4">
  <input id="textinput" name="ckey" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $ckey; ?>">
     <input type="hidden" name="csave" value="csave" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>

<form action="" method="post">
    <input data-on="AUTH" data-off="AUTH" data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="cauth_on" value="on" <?php echo $cauth_on == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="cauth_onoff" value="cauth_onoff" />
</form>

<?php
if ($cauth_on == 'on'){
?>

<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">User:</label>  
  <div class="col-md-4">
  <input id="textinput" name="cauth_login" placeholder="" class="form-control input-md" required="" type="text" value="admin" disabled>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Password:</label>  
  <div class="col-md-4">
  <input id="textinput" name="cauth_pass" placeholder="" class="form-control input-md" required="" type="password" value="<?php echo $cauth_pass; ?>">
     <input type="hidden" name="cauth_save" value="cauth_save" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>

<?php
	}
}
?>

</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Server</h3>
</div>
<div class="panel-body">

<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Key</label>  
  <div class="col-md-4">
  <input id="textinput" name="skey" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $skey; ?>">
     <input type="hidden" name="ssave" value="ssave" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>


</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Domoticz Server</h3>
</div>
<div class="panel-body">

<form action="" method="post">
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="domoon" value="on" <?php echo $nts_domo_on == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="domoticzon" value="domoticzon" />
</form>

<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">IP/Hostname</label>  
  <div class="col-md-4">
  <input id="textinput" name="domoticzip" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $nts_domo_ip; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Port</label>  
  <div class="col-md-4">
  <input id="textinput" name="domoticzport" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $nts_domo_port; ?>">
  <input type="hidden" name="domoticzsave" value="domoticzsave" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>

<form action="" method="post">
    <input data-on="AUTH" data-off="AUTH" data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="domoauth_on" value="on" <?php echo $nts_domo_auth == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="domoauth_onoff" value="domoauth_onoff" />
</form>

<?php
if ($nts_domo_auth == 'on'){
?>

<form action="" method="post" class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">User:</label>  
  <div class="col-md-4">
  <input id="textinput" name="domo_login" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $nts_domo_log; ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Password:</label>  
  <div class="col-md-4">
  <input id="textinput" name="domo_pass" placeholder="" class="form-control input-md" required="" type="password" value="<?php echo $nts_domo_pass; ?>">
     <input type="hidden" name="domoauth_save" value="domoauth_save" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-xs btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>

<?php
	}
?>


</div>
</div>


