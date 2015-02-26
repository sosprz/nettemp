<span class="belka">&nbsp Devices<span class="okno">
<?php

$dir='';

$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
$separator = "\r\n";
foreach ($result as $a) { ?>
	<table>  
	<tr><td>USB  </td> <td><?php echo $a['usb']; ?></td></tr>
	<tr><td>1-wire </td><td><?php echo  $a['onewire']; ?></td></tr>
	<tr><td>Serial </td><td><?php echo  $a['serial']; ?></td></tr>
	<tr><td>I2C </td><td><?php echo  $a['i2c']; ?></td></tr>
	<tr><td>lm-sensors </td><td><?php echo  $a['lmsensors']; ?></td></tr>
	<tr><td>wireless </td><td><?php echo  $a['wireless']; ?></td></tr>
	</table>
<?php 
    }
?>
<hr>
<?php
	$scan = isset($_POST['scan']) ? $_POST['scan'] : '';
        if ($scan == "Scan for new sensors"){ 
        shell_exec("/bin/bash modules/sensors/temp_dev_scan > $dir/tmp/temp_dev_scan"); 
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
	}
?>
<pre>
<?php
    
    if (file_exists("$dir/tmp/temp_dev_scan")) {
    $array = file("$dir/tmp/temp_dev_scan");
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
</span></span>
