<?php
//  
//  remote_name_i2c_48_temp
// 	        i2c_58_temp
// 	        i2c_45_humid	
//		i2c_34_press
//		i2c_23_lux
//		gpio_23_temp
//		gpio_23_humid
//		

if (isset($_POST['key'])) {
	    $key = $_POST['key'];
    }
if (isset($_POST['value'])) {
            $val = $_POST['value'];
    }
if (isset($_POST['rom'])) {
            $rom = $_POST['rom'];
    }

$file = "$rom.sql";



$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select server_key from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) {
$skey=$a['server_key'];
}

if ($key != $skey){
    echo "dienied";
} else {

// main
if  ( !empty($rom) && !empty($val) ) {
	$db = new PDO('sqlite:dbf/nettemp.db');
        $rows = $db->query("SELECT rom FROM sensors WHERE rom='$rom'");
        $row = $rows->fetchAll();
        $c = count($row);
        if ( $c >= "1") {
	    $db = new PDO("sqlite:db/$file");
	    $db->exec("INSERT OR IGNORE INTO def (value) VALUES ('$val')") or die ("cannot insert to DB 1" );
	
	    $dbn = new PDO("sqlite:dbf/nettemp.db");
	    $dbn->exec("UPDATE sensors SET tmp='$val' WHERE rom='$rom'") or die ("cannot insert to status" );
	    echo "ok";
	}
	else {
	    $dbnew = new PDO("sqlite:dbf/nettemp.db");
	    $dbnew->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
	    $dbnew==NULL;
	    echo "Added $rom to new sensors";
	}
} 
else { 
    echo "no values";
    }


} //end main
?>

