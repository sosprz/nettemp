<?php 
$user = $_SESSION["user"];
$accesstime=null;
$mon=null;
$tue=null;
$wed=null;
$thu=null;
$fri=null;
$sat=null;
$sun=null;

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT at FROM users WHERE login='$user'");
$row = $rows->fetchAll();
foreach ($row as $at) {
$profil = $at['at'];
}

$day = date("D");
$time = date("H:i");

$rows = $db->query("SELECT * FROM access_time WHERE name='$profil'");
$row = $rows->fetchAll();
foreach ($row as $d) {
$mon=$d['Mon'];
$tue=$d['Tue'];
$wed=$d['Wed'];
$thu=$d['Thu'];
$fri=$d['Fri'];
$sat=$d['Sat'];
$sun=$d['Sun'];

$stime=$d['stime'];
$etime=$d['etime'];

//echo date("D M d, Y G:i a");

}


if  (($fri == $day) || ($thu == $day) || ($wed == $day) || ($tue == $day) || ($mon == $day) || ($sat == $day) || ($sun ==$day) && $time >= $stime && $time <= $etime) {
$accesstime = yes;
}
?>
<?php 
    if ($accesstime == 'yes' && !empty($user) && $user != 'admin') { 
?>
<span class="label label-info" role="success">Access profile:<?php echo $mon . " " .  $tue . " " . $wed . " " .  $thu . " " . $fri . " " . $sat . " " . $sun  . " " . $stime . " " . $etime ; ?></span>
<?php
} 
    elseif (!empty($user) && $user != 'admin') {
?>
<span class="label label-danger" role="alert">Access profile:<?php echo $mon . " " .  $tue . " " . $wed . " " .  $thu . " " . $fri . " " . $sat . " " . $sun  . " " . $stime . " " . $etime ; ?></span>
<?php
}
?>



