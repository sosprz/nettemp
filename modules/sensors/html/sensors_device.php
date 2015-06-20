<div class="panel panel-default">
            <div class="panel-heading">Discovered devices</div>
<table class="table">
<?php
$dir='';
$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
$separator = "\r\n";
foreach ($result as $a) { ?>
	<tr <?php echo $a['usb'] != 'off' ? 'class="info"' : ''; ?>><td>USB  </td> <td><?php echo $a['usb']; ?></td></tr>
	<tr <?php echo $a['onewire'] != 'off' ? 'class="info"' : ''; ?>><td>1-wire </td><td><?php echo  $a['onewire']; ?></td></tr>
	<tr <?php echo $a['serial'] != 'off' ? 'class="info"' : ''; ?>><td>Serial </td><td><?php echo  $a['serial']; ?></td></tr>
	<tr <?php echo $a['i2c'] != 'off' ? 'class="info"' : ''; ?>><td>I2C </td><td><?php echo  $a['i2c']; ?></td></tr>
	<tr <?php echo $a['lmsensors'] != 'off' ? 'class="info"' : ''; ?>><td>lm-sensors </td><td><?php echo  $a['lmsensors']; ?></td></tr>
	<tr <?php echo $a['wireless'] != 'off' ? 'class="info"' : ''; ?>><td>wireless </td><td><?php echo  $a['wireless']; ?></td></tr>
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
<div class="panel-body">
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="submit" name="scan" value="Scan for new sensors" class="btn btn-primary"/>
</form>
</div>

</div>

