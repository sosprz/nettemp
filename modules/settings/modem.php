<?php
$dir=$_SERVER["DOCUMENT_ROOT"];

$smsdev = $_POST["smsdev"];
$smsc = $_POST["smsc"];
if ($_POST['smsc1'] == "smsc2") {
    $out = preg_replace('/\//',"\/", $smsdev);
    $cmd0="sudo cp -f '$dir'/install/conf/smsd.conf /etc/smsd.conf && sudo sed -i s/changedevice/'$out'/g /etc/smsd.conf";
    passthru($cmd0);
    $cmd1="sudo sed -i s/changesmsc/'$smsc'/g /etc/smsd.conf";
    passthru($cmd1);
    shell_exec("sudo service smstools restart");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
} 

$call = $_POST["call"];
if ($_POST['call1'] == "call2") {
	$ssd1=$call;
	$fh = fopen('tmp/gammurc_call', 'w'); 
	fwrite($fh, "[gammu]\n"); 
	fwrite($fh, "port=$ssd1\n");
	fwrite($fh, "connection=at\n");
	fclose ($fh);
 	exec("gammu -c tmp/gammurc_call identify > tmp/gammu_identify_call");
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

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT dev  FROM usb WHERE device='Modem SMS'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$smsdev=$a['dev'];
}

if (empty($smsdev) || $smsdev == 'none') { ?>
<div class="panel panel-default">
    <div class="panel-heading">SMS modem</div>
	<div class="panel-body">
	    No SMS modem set
  <a href="index.php?id=devices&type=usb" class="btn btn-xs btn-default" role="button">Go to USB/Serial</a>
	</div>
</div>
<?php
} else {
?>

<div class="panel panel-default"><div class="panel-heading">SMS modem <?php echo $smsdev." "?></div>
<div class="panel-body">


<form class="form-inline" action="" method="post">
<?php 
$smscff=shell_exec("sudo cat /etc/smsd.conf |grep ^smsc |awk '{print $3}'");
$devf=shell_exec("sudo cat /etc/smsd.conf |grep -w ^device |awk '{print $3}'");

if (strcmp(trim($smsdev),trim($devf)) != 0 ) { ?>
<span class="label label-warning">Dev <?php echo $smsdev ?> not configured in config file <?php echo $devf?> Press Reload</span>
<br>
<br>
<button name="smsc1"  value="smsc2" class="btn btn-warning">Reload</button>
<br>
<br>
<?php 
}
?>
    
    <label class="col-md-2 control-label" for="smsc">SMS center number</label>
    <input id="smsc" name="smsc" placeholder="" required="" type="text" value="<?php echo $smscff; ?>">
    <input type="hidden" name="smsdev" value="<?php echo $smsdev ?>" />
    <button id="smsc1" name="smsc1"  value="smsc2" class="btn btn-xs btn-default">Save </button>
</form>
<br>
<form class="form-inline" action="" method="post">
    <label class="col-md-2 control-label" for="sms_test">Number</label>  
    <input id="sms_test" name="sms_test" placeholder="" class="form-control input-md" required="" type="text" value="">
    <button id="sms_test1" name="sms_test1" value="sms_test1" class="btn btn-xs btn-default">Send test </button>
</form>


</div>
</div>
<?php
}

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT dev FROM usb WHERE device='Modem Call'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$dev=$a['dev'];
}

if (empty($dev) || $dev == 'none') { ?>
<div class="panel panel-default">
    <div class="panel-heading">Call modem</div>
	<div class="panel-body">
	    No Call modem set <a href="index.php?id=devices&type=usb" class="btn btn-xs btn-default" role="button">Go to USB/Serial</a>
	</div>
</div>
<?php
} else {
?>

<div class="panel panel-default"><div class="panel-heading">Call modem <?php echo $dev ?></div>
<div class="panel-body">
	    <form action="" method="post">
	    <input type="hidden" name="call1" value="call2" />
	    <input type="hidden" name="call" value="<?php echo $dev ?>" />
	    <button class="btn btn-xs btn-success">Refresh modem info <span class="glyphicon glyphicon-refresh"</span></button>
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

