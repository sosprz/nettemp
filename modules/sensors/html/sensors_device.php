<span class="belka">&nbsp Device:<span class="okno">
<?php

$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
$separator = "\r\n";
foreach ($result as $a) {  
 	 echo "USB: {$a['usb']}";
	?>  <br /> <?php 
	 echo "1-wire: {$a['onewire']}";
}
?>
 
</span></span>
