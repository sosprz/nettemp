<?php
$dir=$_SERVER["DOCUMENT_ROOT"];

$sd = $_POST["sd"];

if ($_POST['sd1'] == "sd2") {
    $ssd1=$sd;
    $fh = fopen('tmp/gammurc', 'w'); 
    fwrite($fh, "[gammu]\n"); 
    fwrite($fh, "port=$ssd1\n");
    fwrite($fh, "connection=at\n");
    fclose ($fh);

    exec("gammu -c tmp/gammurc identify > tmp/gammu_identify");
    $out = preg_replace('/\//',"\/", $ssd1);
    $cmd0="sudo cp -f '$dir'/install/conf/smsd.conf /etc/smsd.conf && sudo sed -i s/changedevice/'$out'/g /etc/smsd.conf";
    passthru($cmd0);

    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}    


$smsc = $_POST["smsc"];
if ($_POST['smsc1'] == "smsc2") {
    $cmd1="sudo sed -i s/changesmsc/'$smsc'/g /etc/smsd.conf";
    passthru($cmd1);
    shell_exec("sudo service smstools restart");

    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
} 



//   if ($_POST['scan'] == "Scan"){
//	   exec("sh modules/settings/modem_scan");   
//		exec("rm tmp/gammu_identify*");
//		header("location: " . $_SERVER['REQUEST_URI']);
// 		exit();
//   } 
      


	$call = $_POST["call"];
        if ($_POST['call1'] == "call2") {
   	//$db = new PDO('sqlite:dbf/nettemp.db');
   	//$db->exec("UPDATE call_settings SET default_dev='off'") or die ($db->lastErrorMsg());
   	//$db->exec("UPDATE call_settings SET default_dev='on' WHERE id='$call'") or die ($db->lastErrorMsg());
   	//$sth = $db->prepare("SELECT * FROM call_settings WHERE id='$call'");
   	//$sth->execute();
   	//$result = $sth->fetchAll();
	//		foreach ($result as $sdd) {
				$ssd1=$call;
				$fh = fopen('tmp/gammurc', 'w'); 
				fwrite($fh, "[gammu]\n"); 
				fwrite($fh, "port=$ssd1\n");
				fwrite($fh, "connection=at\n");
				fclose ($fh);
			//}
 	exec("gammu -c tmp/gammurc identify > tmp/gammu_identify_call");
	shell_exec("sudo touch tmp/reboot");
	header("location: " . $_SERVER['REQUEST_URI']);
   	exit();
        } 


$sms_test = $_POST["sms_test"];
if  ($_POST['sms_test1'] == "sms_test1") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $file = "/var/spool/sms/outgoing/smstest";
    $current = file_get_contents($file);
    $current .= "To: $sms_test\n";
    $current .= " \n";
    $current .= "Test from nettemp\n";
    file_put_contents($file, $current);
    }

?>
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
$sth = $db->prepare("SELECT * FROM usb where device='Modem SMS'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$dev=$a['dev'];
}

if (!empty($dev)) { ?>
    <form class="form-inline" action="" method="post"> 
	<button class="btn btn-xs btn-success"><?php echo $dev." "?><span class="glyphicon glyphicon-refresh"</span></button>
	<input type="hidden" name="sd" value="><?php echo $dev ?>" />	
	<input type="hidden" name="sd1" value="sd2" />
    </form>
    <br>
<?php
    if (file_exists("tmp/gammu_identify")) { ?>
    <pre><?php include('tmp/gammu_identify'); ?></pre>
<?php
    }
?>

<?php 
} 
$smscff=shell_exec("sudo cat /etc/smsd.conf |grep ^smsc |awk '{print $3}'");
?>

<form action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="smsc">SMS center number</label>  
  <div class="col-md-2">
    <input id="smsc" name="smsc" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $smscff; ?>">
  </div>
</div>
<div class="form-group">
  <div class="col-md-1">
    <button id="smsc1" name="smsc1"  value="smsc2" class="btn btn-primary">Save </button>
  </div>
</div>

</fieldset>
</form>

<form action="" method="post">
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="sms_test">Number</label>  
  <div class="col-md-2">
    <input id="sms_test" name="sms_test" placeholder="" class="form-control input-md" required="" type="text" value="">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <div class="col-md-1">
    <button id="sms_test1" name="sms_test1" value="sms_test1" class="btn btn-primary">Send test </button>
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
$sth = $db->prepare("SELECT * FROM usb WHERE device='Modem Call'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$dev=$a['dev'];
}

if (!empty($dev)) { ?>
	    <form action="" method="post">
	    <input type="hidden" name="call1" value="call2" />
	    <input type="hidden" name="call" value="<?php echo $dev ?>" />
	    <button class="btn btn-xs btn-success"><?php echo $dev." "?><span class="glyphicon glyphicon-refresh"</span></button>
	    </form>
<br>
<?php
    if (file_exists("tmp/gammu_identify_call")) { ?>
	    <pre><?php include('tmp/gammu_identify_call'); ?> </pre>
<?php
    }
?>
<?php 
    } 
?>
</div>
</div>

