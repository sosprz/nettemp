<?php
//http://172.18.10.8/update.php?key=123456&device=esp&value=12

function esp($ver) {

    $file = glob('modules/update/esp/*.lua')[0];
    $file = basename($file, ".lua");
    if ($file > $ver ) {
    ?><pre><?php
	include(glob('modules/update/esp/*.lua')[0]);
    ?></pre><?php
    } else {
	echo "No update available";
    }
    
}


function check($device,$ver) {
    if ($device=='esp'){
	esp($ver);
	}
} 


//MAIN

if (isset($_GET['key'])) {
	    $key = $_GET['key'];
    }
if (isset($_GET['ver'])) {
            $ver = $_GET['ver'];
    }
if (isset($_GET['device'])) {
            $device = $_GET['device'];
    } else $device='';

$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
$skey=$a['server_key'];
//global $chmin;
//$chmin=$a['charts_min'];
}

if ("$key" != "$skey"){
    echo "wrong key";
} else {
    if  (isset($ver) && isset($device)) {
	check($device,$ver);
    }
}
?>

