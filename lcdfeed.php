<?php
/*
    Export data to remote system

    proper usage:
    http(s)://{NettempIP}/lcdfeed.php?key=${server_key}&group=${group_key}
    http(s)://{NettempHostname}/lcdfeed.php?key=${server_key}&group=${group_key}

    or from CLI:
    php lcdfeed.php {server_key} {group_key} {format} {average}
    php-cgi -f lcdfeed.php key={server_key} group={group_key} format={format} avg={average}
    format: csv or null
    average: 1 or null
*/

if(php_sapi_name() === 'cli' && count($argv) >= 3 && count($argv) <=5){
// Run from CLI
    $_GET['key'] = $argv['1'];
    $_GET['group'] = $argv['2'];
    $_GET['format'] = isset($argv['3']) ? $argv['3'] : '';
    $_GET['avg'] = isset($argv['4']) ? $argv['4'] : '';
}

//required params
foreach (array('key', 'group') as $val) {
    if(isset($_GET[$val])){
       ${$val} = checkdata($_GET[$val]);
    }else{
       print("Nie przeslano parametru $val");
       exit;
    }
}
unset($val);

//optional params
$format = isset($_GET['format']) ? checkdata($_GET['format']) : '';
$avg = isset($_GET['avg']) ? checkdata($_GET['avg']) : '';

$root = ( isset($_SERVER["DOCUMENT_ROOT"]) && !empty($_SERVER["DOCUMENT_ROOT"]) ) ? $_SERVER["DOCUMENT_ROOT"] : __DIR__;

//DB Connect
try {
    $db = new PDO("sqlite:".$root."/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n".$e;
    exit;
}

$sth = $db->prepare("select server_key,temp_scale from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetch();
$skey=$result['server_key'];
$scale=$result['temp_scale'];

//main loop
if ("$key" != "$skey"){
    echo "wrong key";
} else {
    if (isset($group)) {
   lcd($db,$group,$format,$avg);
    }
} //end main

exit;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

//functions
function checkdata($data) {
    preg_match('/^[a-z0-9]+$/i',$data) ? : $data='Nieprawidlowe dane wejsciowe';
    return $data;
}

function types($db){
//fetch types from db
    global $scale;
    $sth = $db->prepare("SELECT type,unit,unit2 FROM types");
    $sth->execute();
    $types = $sth->fetchAll();
    foreach ($types as $type) {
        $t[$type['type']] = $scale == 'F' ? $type['unit2'] : $type['unit'];
    }
    return $t;
}

function lcd($db,$group,$format,$avg){
    $units=types($db);
    $g = $avg == '1' ? ' GROUP BY type ' : '';
    $q = "SELECT name, ROUND(tmp,1) as tmp, type, time FROM sensors WHERE rom IN (SELECT rom FROM lcd_group_assign WHERE grpkey = '".$group."') ".$g." ORDER BY position ASC";
    $sth = $db->prepare($q) or die ("Blad przygotowania danych");
    $sth->execute();
    $result = $sth->fetchall();
    $out='';
    if($format == 'csv'){
        if(count($result)>0){
            $out[] = ("name;value;unit;time");
        }
        foreach($result as $r){
            if($avg == '1'){
                $out[]='Avg'.ucfirst($r['type']).';'.$r['tmp'].';'.$units[$r['type']].';'.$r['time'];
            }else{
                $out[]=$r['name'].';'.$r['tmp'].';'.$units[$r['type']].';'.$r['time'];
            }
        }
    }else{
        foreach($result as $r){
            if($avg == '1'){
                $out[]='Avg'.ucfirst($r['type'])." $r[tmp]".$units[$r['type']];
            }else{
                $out[]="$r[name] $r[tmp]".$units[$r['type']];
            }
        }
    }
    if(!empty($out)&&count($out)>0){
        print(join("\n",$out));
    }else{
        print("No data, or no\nsensors in group..");
    }
}
?>
