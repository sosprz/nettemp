<?php
$dir=$_SERVER["DOCUMENT_ROOT"];

    $sd = $_POST["sd"];
    $smsc = $_POST["smsc"];
    if (!empty($smsc) && ($_POST['smsc1'] == "smsc1") ){

   	$db = new PDO('sqlite:dbf/nettemp.db');
   	$db->exec("UPDATE sms_settings SET default_dev='off'") or die ($db->lastErrorMsg());
   	$db->exec("UPDATE sms_settings SET default_dev='on' WHERE id='$sd'") or die ($db->lastErrorMsg());
   	$sth = $db->prepare("SELECT * FROM sms_settings WHERE id='$sd'");
   	$sth->execute();
   	$result = $sth->fetchAll();
			foreach ($result as $sdd) {
				$ssd1=$sdd['dev'];
				$fh = fopen('tmp/gammurc', 'w'); 
				fwrite($fh, "[gammu]\n"); 
				fwrite($fh, "port=$ssd1\n");
				fwrite($fh, "connection=at\n");
				fclose ($fh);
				}

    exec("gammu -c tmp/gammurc identify > tmp/gammu_identify");
    $out = preg_replace('/\//',"\/", $ssd1);
    $cmd0="sudo cp -f '$dir'/install/conf/smsd.conf /etc/smsd.conf && sudo sed -i s/changedevice/'$out'/g /etc/smsd.conf";
    passthru($cmd0);

    $cmd1="sudo sed -i s/changesmsc/'$smsc'/g /etc/smsd.conf";
    passthru($cmd1);
    shell_exec("sudo service smstools restart");

    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 



   if ($_POST['scan'] == "Scan"){
	   exec("sh modules/settings/modem_scan");   
  		exec("rm tmp/gammu_identify*");
		header("location: " . $_SERVER['REQUEST_URI']);
  		exit();
   } 
      


    $call = $_POST["call"];
      if ($_POST['call1'] == "call2") {
   	$db = new PDO('sqlite:dbf/nettemp.db');
   	$db->exec("UPDATE call_settings SET default_dev='off'") or die ($db->lastErrorMsg());
   	$db->exec("UPDATE call_settings SET default_dev='on' WHERE id='$call'") or die ($db->lastErrorMsg());
   	$sth = $db->prepare("SELECT * FROM call_settings WHERE id='$call'");
   	$sth->execute();
   	$result = $sth->fetchAll();
			foreach ($result as $sdd) {
				$ssd1=$sdd['dev'];
				$fh = fopen('tmp/gammurc', 'w'); 
				fwrite($fh, "[gammu]\n"); 
				fwrite($fh, "port=$ssd1\n");
				fwrite($fh, "connection=at\n");
				fclose ($fh);
			}
  		 	exec("gammu -c tmp/gammurc identify > tmp/gammu_identify_call");
			header("location: " . $_SERVER['REQUEST_URI']);
   		exit();
     } 
?>
<form action="" method="post">
    <button type="submit" name="scan" value="Scan" class="btn btn-primary">Search GSM modem</button>
</form>
<br />
<script type="text/javascript">
$("button").click(function() {
    var $btn = $(this);
    $btn.button('loading');
function submitform()
{
    $btn.button('reset');
}
});
</script>


<div class="panel panel-default"><div class="panel-heading">SMS modem</div>
<div class="panel-body">
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT * FROM sms_settings where id='2'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$name=$a['name'];
}

if (!empty($name)) { ?>
<table><tr><td>
<form class="form-inline" action="" method="post"> 
<select name="sd">
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from sms_settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>
<option <?php echo $a['default_dev'] == 'on' ? 'selected="selected"' : ''; ?> value="<?php echo $a['id']; ?>"><?php echo $a["name"]; ?> <?php echo $a["dev"]; ?> </option>
<?php } ?>
</select>
<input type="hidden" name="sd1" value="sd2" />
</td>

<?php
    if (file_exists("tmp/gammu_identify")) { ?>
    <tr><td><pre><?php include('tmp/gammu_identify'); ?></pre></td></tr>
<?php
    }
?>
</tr></table>

<?php 
} 
$smscff=shell_exec("sudo cat /etc/smsd.conf |grep ^smsc |awk '{print $3}'");
?>


<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="smsc">SMS center number</label>  
  <div class="col-md-2">
    <input id="smsc" name="smsc" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $smscff; ?>">
  </div>
</div>
<br />
<div class="form-group">
  <div class="col-md-1">
    <button id="smsc1" name="smsc1"  value="smsc1" class="btn btn-primary">Save </button>
  </div>
</div>

</fieldset>
</form>
</div>
</div>





<div class="panel panel-default"><div class="panel-heading">Call modem</div>
<div class="panel-body">
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT * FROM call_settings where id='2'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$name=$a['name'];
}

if (!empty($name)) { ?>
<table><tr><td>
<form action="" method="post"> 
<select name="call"  onchange="this.form.submit()" >
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from call_settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>
<option <?php echo $a['default_dev'] == 'on' ? 'selected="selected"' : ''; ?> value="<?php echo $a['id']; ?>"><?php echo $a["name"]; ?> <?php echo $a["dev"]; ?> </option>
<?php } ?>
</select>
<input type="hidden" name="call1" value="call2" />
</td>
</form>
<?php
    if (file_exists("tmp/gammu_identify_call")) { ?>
    <tr><td><pre><?php include('tmp/gammu_identify_call'); ?></pre></td></tr>
<?php
    }
?>
</tr></table>

<?php 
} 
?>
</div>
</div>

