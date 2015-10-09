<?php 
$user = $_SESSION["user"];

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
    if ($accesstime == 'yes') { 
?>
<div class="panel panel-success">
<?php
} else {
?>
<div class="panel panel-danger">
<?php
}
?>


<div class="panel-heading">Your access time profil </div>

<div class="table-responsive">
<table class="table table-striped">
<thead><tr>
<th>Mon</th>
<th>Tue</th>
<th>Wed</th>
<th>Thu</th>
<th>Fri</th>
<th>Sat</th>
<th>Sun</th>
<th>Start hour</th>
<th>End hour</th>
</tr></thead>
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from access_time WHERE name='$profil'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
    <tr>
    <td><?php echo $a["Mon"];?></td>
    <td><?php echo $a["Tue"];?></td>
    <td><?php echo $a["Wed"];?></td>
    <td><?php echo $a["Thu"];?></td>
    <td><?php echo $a["Fri"];?></td>
    <td><?php echo $a["Sat"];?></td>
    <td><?php echo $a["Sun"];?></td>
    <td><?php echo $a["stime"];?></td>
    <td><?php echo $a["etime"];?></td>

    </tr>
<?php }
?>
</table>
</div>
</div>

