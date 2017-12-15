<div class="alert alert-warning" role="alert">Sensors I2C, 1wire gpio, some 1wire USB, 1wire OWFS and lmsensors are detected automatically go to <a href="index.php?id=device&type=sensors" class="btn btn-xs btn-warning">Devices</a></div>

<div class="panel panel-default">
            <div class="panel-heading">Discovered devices</div>
<table class="table table-condensed small">
<?php
$dir='';
$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
$separator = "\r\n";
foreach ($result as $a) { ?>
	<?php 
		$ds=str_replace('i2c-','',$a['i2c']);
	?>
	<?php if (file_exists("/sys/bus/i2c/devices/".$ds."-0018/")) 
	{ ?><tr class="info"><td>1wire DS2482</td><td>on</td></tr><?php } 
	else { ?><tr><td>1wire DS2482</td><td>off</td></tr><?php } ?>
	<tr <?php echo $a['usb'] != 'off' ? 'class="info"' : ''; ?>><td>1wire USB </td> <td><?php echo $a['usb']; ?></td></tr>
	<tr <?php echo $a['onewire'] != 'off' ? 'class="info"' : ''; ?>><td>1-wire gpio</td><td><?php echo  $a['onewire']; ?></td></tr>
	<tr <?php echo $a['serial'] != 'off' ? 'class="info"' : ''; ?>><td>1wire Serial </td><td><?php echo  $a['serial']; ?></td></tr>
	<tr <?php echo $a['i2c'] != 'off' ? 'class="info"' : ''; ?>><td>I2C </td><td><?php echo  $a['i2c']; ?></td></tr>
	<tr <?php echo $a['lmsensors'] != 'off' ? 'class="info"' : ''; ?>><td>lm-sensors </td><td><?php echo  $a['lmsensors']; ?></td></tr>
	<tr <?php echo $a['wireless'] != 'off' ? 'class="info"' : ''; ?>><td>wireless ESP8266 </td><td><?php echo  $a['wireless']; ?></td></tr>
	<?php if (file_exists("/sys/bus/i2c/devices/".$ds."-0068/"))
	{ ?><tr class="info"><td>HW Clock DS1307</td><td>on</td></tr><?php }
	else { ?><tr><td>HW Clock DS1307</td><td>off</td></tr><?php } ?>
	<?php 
}
	?>
</table>

<hr>
<?php
	$scan = isset($_POST['scan']) ? $_POST['scan'] : '';
        if ($scan == "Scan for new sensors"){ 
        shell_exec("/bin/bash modules/sensors/scan > tmp/scan"); 
	header("location: " . $_SERVER['REQUEST_URI']);
        exit();
	}
?>
<div class="panel-body">
<?php
    if (file_exists("tmp/scan")) { ?>
    <pre><?php
    $array = file("tmp/scan");
    foreach($array as $f){
	echo $f;
	}
    ?></pre>
<?php
    }
?>





<form action="" method="post" name="mfo">
<button type="submit" name="scan" value="Scan for new sensors" data-loading-text="Loading..." class="btn btn-xs btn-success">
  Scan
</button>
</form>
</div>

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









