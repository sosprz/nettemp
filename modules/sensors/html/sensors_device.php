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
	</table>
<?php }
?>
<hr>
<?php
include('conf.php');

         if ($_POST['scan'] == "Scan for new sensors"){
         exec("sh $global_dir/modules/sensors/temp_dev_scan");   
         system("chmod 777 $global_dir/scripts/tmp/.digitemprc");
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="submit" name="scan" value="Scan for new sensors" />
</form>
 
</span></span>
