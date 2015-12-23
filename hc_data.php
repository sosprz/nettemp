<?php
$root = "/var/www/nettemp";
$dir = "$root/db";
$dst = "$root/tmp/highcharts";
$name=$_GET["name"];
$type=$_GET["type"];
$max=$_GET["max"];
$array=null;

function query($max,&$query) {
if ($max == 'hour') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 hour')";
    } 
if ($max == 'day') {
      $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 day')";
    } 
if ($max == 'week') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-7 day')";
    } 
if ($max == 'month') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 months')";
    } 
if ($max == 'months') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-6 months')";
    } 
if ($max == 'year') {
    $query = "select strftime('%s', time),value from def WHERE time >= datetime('now','localtime','-1 year')";
    } 
if ($max == 'all') {
    $query = "select strftime('%s', time),value FROM def";
    }

}

if ($type == 'system') {

    $file='system_'.$name;
    $dirb = "sqlite:$root/db/$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");

    query($max,$query);
    //$query = "select strftime('%s', time),value FROM def ORDER BY time ASC";
             
    foreach ($dbh->query($query) as $row) {
	$line=[($row[0])*1000 . "," . $row[1]];
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
	//$array[]=[($row[0]+3600)*1000 . "," . $row[1]];
	$array[]=[($row[0])*1000 . "," . $row[1]];
	    
    }
    print str_replace('"', "",json_encode($array));
    exit();
}

elseif ($type == 'gonoff') {

    $file=$name;
    $dirb = "sqlite:$root/db/$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");

    query($max,$query);

    foreach ($dbh->query($query) as $row) {
	$array[]=[($row[0])*1000 . "," . $row[1]];
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
	$adj=$a['adj'];
    }

    $dirb = "sqlite:$root/db/$file.sql";
    $dbh = new PDO($dirb) or die("cannot open database");

    query($max,$query);
    //$query = "select strftime('%s', time),value FROM def ORDER BY time ASC";

    foreach ($dbh->query($query) as $row) {
	$line=[($row[0])*1000 . "," . ($row[1]+$adj)];
	$array[]=$line;
    }
    print str_replace('"', "",json_encode($array));
}

?>
