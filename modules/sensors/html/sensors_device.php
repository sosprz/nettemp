<span class="belka">&nbsp Temperature sensors device<span class="okno">
<?php

$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
$separator = "\r\n";
foreach ($result as $a) { ?>
	<table>  
	<tr><td>USB <td>is</td> </td> <td><?php echo $a['usb']; ?></td></tr>
	<tr><td>1-wire <td>is</td> </td><td><?php echo  $a['onewire']; ?></td></tr>
	<tr><td>Serial <td>is</td> </td><td><?php echo  $a['serial']; ?></td></tr>
	<tr><td>I2C <td>is</td> </td><td><?php echo  $a['i2c']; ?></td></tr>
	</table>
<?php }
?>
<hr>
<?php
$scan = isset($_POST['scan']) ? $_POST['scan'] : '';
         if ($scan == "Scan for new sensors"){
         passthru("sh modules/sensors/temp_dev_scan");   
         system("chmod 775 scripts/tmp/.digitemprc");
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="submit" name="scan" value="Scan for new sensors" />
</form>
</span></span>
