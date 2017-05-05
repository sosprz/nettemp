<?php
// http://php.net/manual/en/pdo.transactions.php

$date = date("Y-m-d H:i:s");

if(empty($ROOT)){
    $ROOT=dirname(dirname(dirname(__FILE__)));
}


//Check ACTUAL DB VERSION
try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try{
    $ver = $db->query("SELECT * FROM version LIMIT 1");
} catch (Exception $e) {
//if there is no 'version' table:
    require('update_db_old.php');
    $db->exec("CREATE TABLE IF NOT EXISTS 'version' (`db_ver` DATE NOT NULL,`lastupdate` DATE NOT NULL);");
    $db->exec("DELETE FROM `version`;");
    $db->exec("INSERT INTO `version` (`db_ver`, `lastupdate`) VALUES ('2017-03-16 10:00:00', datetime('now','localtime'));");
    unset($db);
    master_update($ROOT);
    $recheck=1;
}

if(isset($recheck)){
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    try{
	$ver = $db->query("SELECT * FROM version LIMIT 1");
    } catch (Exception $e) {
	header("Location: html/errors/db_error.php");
    }
}

$version = $ver->fetch(PDO::FETCH_ASSOC);
unset($ver,$recheck);

require('update_db_new.php');
ksort($updates);

//MAIN UPDATE SYSTEM
foreach (array_keys($updates) as $key){
    if(!isset($error) && $key > $version['db_ver']){
        echo "Update $key is NOT applied. Applying...\n";
        $needupdate = 1;
        $dbver = $key;
        try {
//            $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
//            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
//Do The Update!
            foreach ( $updates[$key] as $sql ){
                $db->exec($sql);
            }
            $db->exec("UPDATE version SET `db_ver`='$dbver',`lastupdate`=datetime('now','localtime') WHERE db_ver<'$dbver'");
            $db->commit();
        } catch (Exception $e) {
            echo "Update: $dbver was unsuccessful.";
            echo "\n\nFailed reason: \n$e";
            $db->rollBack();
            $error=1;
        }
//    }else{
// Do nothing..
    }
}

echo (isset($needupdate) && !isset($error)) ? "Nettemp DB update OK \n" : '';
echo (!isset($needupdate) && !isset($error)) ? "Nettemp DB update not needed \n" : '';
unset($needupdate,$error,$updates);
unset($db);

?>
