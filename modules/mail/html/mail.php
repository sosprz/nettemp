<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$mail=$a["mail"];
}
?>


<?php
    if ($mail == "on" ) { 
    include("mail_settings.php"); 
    include("mail_test.php"); 
    } 
    //else { echo "OFF"; }
    
    //else { 
//	    header("Location: diened");
//    } 
?>