<?php
$db = new PDO('sqlite:../../dbf/nettemp.db');
$rows = $db->query("SELECT * FROM gpio WHERE gpio='4'");
$row = $rows->fetchAll();
foreach ($row as $s) {
    $fnum=$s['fnum'];
    echo $fnum."<br>";
}

foreach ($row as $a) {
    echo $a['temp_sensor1'];
}
?>
