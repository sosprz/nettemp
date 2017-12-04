<?php 
$db = new PDO("sqlite:../../dbf/nettemp.db") or die ("cannot open database");
$db->exec("UPDATE statistics SET agreement='yes' WHERE id='1'");
?>
