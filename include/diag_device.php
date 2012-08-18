<span class="belka">&nbsp Device:<span class="okno">
<?php

$db1 = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from device");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
 	echo  $a["temp"] ;
}
?>
 
</span></span>