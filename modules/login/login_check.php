<?php 
  
$logged=$_SESSION["logged"];     

$db1 = new PDO('sqlite:dbf/nettemp.db');
$rows1 = $db1->query("SELECT * FROM users WHERE login='$logged'");
$row1 = $rows1->fetchAll();
$numRows1 = count($row1);

$sth = $db1->prepare("select * from users WHERE login='$logged'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $row) { 
 	$perms=$row["perms"]; 
}


?>
