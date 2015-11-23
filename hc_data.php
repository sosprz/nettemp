<?php
$root = "/var/www/nettemp";
$dir = "$root/db";
$dst = "$root/tmp/highcharts";
$name=$_GET["name"];
$type=$_GET["type"];
$max=$_GET["max"];

function query($max,&$query) {
if ($max == hour) {
    $query = "select strftime('%s', time),value from def ORDER BY time ASC limit 60";
    } 
if ($max == day) {
    $query = "select strftime('%s', time),value from def ORDER BY time ASC limit 1440";
    } 
if ($max == week) {
    $query = "select strftime('%s', time),value from def ORDER BY time ASC limit 10080";
    } 
if ($max == month) {
    $query = "select strftime('%s', time),value from def ORDER BY time ASC limit 50080";
    } 
if ($max == months) {
    $query = "select strftime('%s', time),value from def where time >= date('now','-6 months')";
    } 
if ($max == year) {
    $query = "select strftime('%s', time),value from def where time >= date('now','start of year')";
    } 
if ($max == all) {
    $query = "select strftime('%s', time),value FROM def ORDER BY time ASC";
    }

}

if ($type == 'system') {

    $file='system_'.$name;
    $dirb = "sqlite:$root/db/$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");

    query($max,$query);
             
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

    query($max,$query);

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

query($max,$query);

foreach ($dbh->query($query) as $row) {
    $line=[$row[0]*1000 . "," . $row[1]];
    $array[]=$line;
    }

print str_replace('"', "",json_encode($array));
}

?>
