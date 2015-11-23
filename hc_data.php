<?php
$root = "/var/www/nettemp";
$dir = "$root/db";
$dst = "$root/tmp/highcharts";
$name=$_GET["name"];
$type=$_GET["type"];



//if ($type == 'cpu' || $name == 'memory' || $name == 'memory_cached') {
if ($type == 'system') {

    $file='system_'.$name;
    $dirb = "sqlite:$root/db/$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");
    $query = "select strftime('%s', time),value FROM def ORDER BY time ASC";

             
    foreach ($dbh->query($query) as $row) {
    $line=[$row[0]*1000 . "," . $row[1]];
    $array[]=$line;
    }
    print str_replace('"', "",json_encode($array));
    exit();
}

elseif ($type == 'hosts') {

    $file=$name;
    $dirb = "sqlite:$root/db/$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");
    $query = "select strftime('%s', time),value FROM def ORDER BY time ASC";

    foreach ($dbh->query($query) as $row) {
	$array[]=[$row[0]*1000 . "," . $row[1]];
    }
    print str_replace('"', "",json_encode($array));
    exit();
}

else {

//sensors
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE type='$type' and name='$name'");
$row = $rows->fetchAll();
foreach($row as $a) {
$file=$a['rom'];
}


$dirb = "sqlite:$root/db/$file.sql";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select strftime('%s', time),value FROM def ORDER BY time ASC";

foreach ($dbh->query($query) as $row) {
    $line=[$row[0]*1000 . "," . $row[1]];
    $array[]=$line;
    }


//print json_encode($array, JSON_NUMERIC_CHECK);
print str_replace('"', "",json_encode($array));
}

?>
