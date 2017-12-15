<?php
$ROOT=dirname(dirname(dirname(__FILE__)));

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

require($ROOT.'/modules/settings/nt_settings.php');
if( $NT_SETTINGS['lcdmode'] == 'adv' || ( $NT_SETTINGS['lcd'] != 'on' && $NT_SETTINGS['lcd4'] != 'on' ) ){
    exit;
}

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();


$sth = $db->query("SELECT * FROM nt_settings");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
	if($a['option']=='temp_scale') {
		$nts_temp_scale=$a['value'];
	}
}

$sth = $db->prepare("SELECT name,tmp,type FROM sensors WHERE lcd='on' ORDER BY position ASC, id ASC");
$sth->execute();
$result = $sth->fetchAll();

$lcd=array();
foreach ($result as $a) {
    foreach($result_t as $ty){
        if($ty['type']==$a['type']){
            if(($nts_temp_scale == 'F')&&($a['type']=='temp')){
                $unit='F';
            } elseif(($nts_temp_scale == 'C')&&($a['type']=='temp')){
                $unit='C';
            } else {
                $unit=$ty['unit'];
            }
            $lcd[]=$a['name']." ".$a['tmp']." ".$unit."\n";
        }
    }
}

$lfile = "$ROOT/tmp/lcd";
$fh = fopen($lfile, 'w');
fwrite($fh, date("y-m-d H:i")."\n");
foreach ($lcd as $line) {
    fwrite($fh, $line);
}
fclose($fh);

?>
