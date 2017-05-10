<?php
//version 4+ -> exec way

//Def
$ROOT=dirname(dirname(dirname(__FILE__)));
$lcdi2c = "$ROOT/modules/lcd/lcdi2c";

//DB Connect
try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

//obtain server key
$sth = $db->prepare("select lcdmode,lcd4,lcd,server_key from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetch();
$skey=$result['server_key'];

//if basic lcd is configured - run old script
if($result['lcdmode'] != 'adv'){
    if($result['lcd'] == 'on' || $result['lcd4'] == 'on'){
        exec('/usr/bin/nohup '.$ROOT.'/modules/lcd/lcd > /dev/null 2>&1 &');
        exit;
    }else{
        exit;
    }
}
unset($sth,$result);

$settings = settings($db);
//Close DB Connection
unset($db);

//Clean LCD's
foreach (array_keys($settings) as $key){
//init LCD
    exec("$lcdi2c -i -l -a ".$settings[$key]['addr']." -b 1 '".sprintf('%-16.16s%-16.16s', "nettemp.pl", "lcd mod")."'");
//set exec params
    if ( $settings[$key]['rows'] == 4 && $settings[$key]['cols'] == 20 ){
        $settings[$key]['exec']=$lcdi2c.'4 -a '.$key.' -b 1 -r '.$settings[$key]['rows'];
    } else {
        $settings[$key]['exec']=$lcdi2c.' -a '.$key.' -b 1 -r '.$settings[$key]['rows'].' -c '.$settings[$key]['cols'];
    }
    $settings[$key]['position']=0;
    unset($cols);
}
echo "LCD's initialisation...\n";
sleep(3);

//main loop
for($i=0;$i<=75;$i++){

//fetch messages
    if($i % 30 == 0 ){
        $msgs = fetch($settings,$skey);
        echo date('Y-m-d  H:i:s')."\t -> Data was readed\n";
    }

//Reset counter..
    if($i==60){$i=0;}

//Update LCDs
    foreach(array_keys($settings) as $key){
//check available lines
        $lines=$settings[$key]['rows'];
        if($settings[$key]['clock'] == 'on'){$lines--;}

//compose output message
        $msg='';
        for($l=0;$l<$lines;$l++){
            if(($settings[$key]['position']+$l)<count($msgs[$key])){
                $msg[]=$msgs[$key][$settings[$key]['position']+$l];
            }elseif($settings[$key]['loop'] == 'on' && $l < count($msgs[$key]) ){
                $msg[]=$msgs[$key][$settings[$key]['position']+$l-count($msgs[$key])];
            }else{
                $msg[]=format($settings[$key]['cols'],'');
            }
        }

///// Fancy things for 4x20 LCD
        $odd = '';
        $even= '';
        for($l=0;$l<count($msg);$l++){
            $even.= ( $l % 2 == 0 ) ? $msg[$l] : '';
            $odd .= ( $l % 2 == 1 ) ? $msg[$l] : '';
        }
        $msg = $even.$odd;
        unset($even,$odd);

//add clock if needed
        if($settings[$key]['clock'] == 'on'){
            if($settings[$key]['cols']<17){
                $df='ymd';
            }elseif($settings[$key]['cols']<19){
                $df='y-m-d';
            }else{
                $df='Y-m-d';
            }
            $msg.=format($settings[$key]['cols'],date($df),date('H:i:s'));
        }

//push to lcd
        exec($settings[$key]['exec']." '".$msg."'");

//move to the next line
        if($i % 3 == 0){
//print msg to stdout
            echo $key."\t-> ".$msg."\n";
            if($settings[$key]['position']<count($msgs[$key])-1 && $lines<count($msgs[$key])){
                $settings[$key]['position']++;
            }else{
                $settings[$key]['position']=0;
            }
        }

        unset($msg);
    }
//sleep!
    usleep(900000);
}

exit;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

//some function definitions
function settings($db){
    $sth = $db->prepare("SELECT l.*,g.grpkey FROM lcds l,lcd_groups g WHERE l.grp == g.name AND l.active == 'on'");
    $sth->execute();
    $settings = $sth->fetchAll();
    foreach ($settings as $s){
        $out[$s['addr']] = $s;
    }
    unset($sth,$settings,$s);
    return $out;
}

function fetch($settings,$skey){
//Fetch New Data
    $ret='';
//exec way..
    foreach($settings as $s){
//combine options
        global $ROOT;
        $opt = $skey.' '.$s['grpkey'].' csv ';
        $opt.= $s['avg'] == 'on' ? '1' : '';
        exec('/usr/bin/php '.$ROOT.'/lcdfeed.php '.$opt, $execout);
        $tmp[$s['addr']] = implode("\n",$execout);
        unset($execout,$opt);
    }

//do some magic with the response
    foreach(array_keys($tmp) as $key){
        if(preg_match('/\;+/',$tmp[$key])){
            foreach(explode("\n", $tmp[$key]) as $n => $str){
                if($n == 0){
                    $keys=explode(';',$str);
                }else{
                    $vals=explode(';',$str);
                    for($i=0;$i<count($vals);$i++){
//remove degree symbol
                        $arr[$keys[$i]]= preg_match('/°/', $vals[$i]) ? substr($vals[$i], -1) : $vals[$i];
                   }
//set pressure precision to decimals
                    if(preg_match('/hpa/i',$arr['unit'])){
                        $arr['value'] = round($arr['value'],0);
                    }
                    $ret[$key][]=format($settings[$key]['cols'],$arr['name'],$arr['value'],$arr['unit']);
                }
            }
        }else{
            foreach(explode("\n", $tmp[$key]) as $line){
                $ret[$key][]=format($settings[$key]['cols'],$line);
            }
        }
    }
    unset($tmp,$key,$n,$str,$keys,$vals,$i,$arr,$line);
    return $ret;
}

//format message to lcd
function format($cols,$name,$value='',$unit=''){
    $vlen=strlen($value.$unit)+1;
    $format='%-'.($cols-$vlen).".".($cols-$vlen)."s".'%'.($vlen).".".($vlen)."s"; //name & value+unit
    return sprintf($format,$name,$value.$unit);
}

?>
