<?php
$ROOT=dirname(dirname(dirname(__FILE__)));

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();

$rows = $db->query("SELECT * FROM settings WHERE id='1'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $temp_scale=$a['temp_scale'];
}

$sth = $db->prepare("SELECT name,tmp,type FROM sensors WHERE lcd='on' ORDER BY position ASC, id ASC");
$sth->execute();
$result = $sth->fetchAll();

foreach ($result as $a) {
    foreach($result_t as $ty){
	if($ty['type']==$a['type']){
	    if($temp_scale == 'F'){
		$unit=$ty['unit2'];
	    } else {
		$unit=$ty['unit'];
	    }
	$lcd[]=$a['name']." ".$a['tmp']." ".$unit."\n";
	}
    }
}

$lfile = $ROOT.'/tmp/lcd';
$fh = fopen($lfile, 'w');
fwrite($fh, date("Y-m-d H:i")."\n");
foreach ($lcd as $line) {
    fwrite($fh, $line);
}
fclose($fh);
?>
