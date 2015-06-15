<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Discovered devices</h3>
            </div>
            <div class="panel-body">
<table class="table table-striped">
<?php
$dir='';
$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
$separator = "\r\n";
foreach ($result as $a) { ?>
	<tr><td>USB  </td> <td><?php echo $a['usb']; ?></td></tr>
	<tr><td>1-wire </td><td><?php echo  $a['onewire']; ?></td></tr>
	<tr><td>Serial </td><td><?php echo  $a['serial']; ?></td></tr>
	<tr><td>I2C </td><td><?php echo  $a['i2c']; ?></td></tr>
	<tr><td>lm-sensors </td><td><?php echo  $a['lmsensors']; ?></td></tr>
	<tr><td>wireless </td><td><?php echo  $a['wireless']; ?></td></tr>
<?php 
    }
?>
</table>

<hr>
<?php
	$scan = isset($_POST['scan']) ? $_POST['scan'] : '';
        if ($scan == "Scan for new sensors"){ 
        shell_exec("/bin/bash modules/sensors/scan > $dir/tmp/scan"); 
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
	}
?>
<pre>
<?php
    if (file_exists("/var/www/nettemp/tmp/scan")) {
    $array = file("/var/www/nettemp/tmp/scan");
    //$last = array_slice($filearray,-100);
    foreach($array as $f){
	echo $f;
	}
    }
?>
</pre>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="submit" name="scan" value="Scan for new sensors" />
</form>

</div>
</div>

