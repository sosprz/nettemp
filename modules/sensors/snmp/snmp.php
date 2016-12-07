<?php
$ROOT=(dirname(dirname(dirname(dirname(__FILE__)))));
$date = date("Y-m-d H:i:s"); 


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

$sth = $db->prepare("SELECT tmp FROM sensors ORDER BY position ASC, id ASC");
$sth->execute();
$result = $sth->fetchAll();

foreach ($result as $a) {   
      		$sn[]=$a['tmp'];
}

$sn=implode(":",$sn);
$sfile = 'tmp/results';
$fh = fopen($sfile, 'w');
	fwrite($fh, $sn);
fclose($fh);
if(!empty($sn) && file_exists($sfile)) {
	echo $date." SNMP OK - file ".$sfile." exist\n";
}

?>

