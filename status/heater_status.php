<?php 
$dir="modules/gpio/";
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from heaters");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="grid-item heat">
<div class="panel panel-default">
            <div class="panel-heading">WiFi Heaters</div>
<table class="table table-responsive table-hover table-condensed">

<thead>
<tr>
<th></th>
<th><small>Name</small></th>
<th><small>Temp</small></th>
<th><small>Set</small></th>
<th><small>Mode</small></th>
<th><small>Status</small></th>
</tr>
</thead>

<tbody>
<?php
foreach ( $result as $a) {
$ip=$a['ip'];
$cmd="curl --connect-timeout 3 $ip/showstatus";
exec($cmd, $i);
$s=$i[0];
$o1=str_replace('status', '', $s);
$o = str_replace(' ', '', $o1);
if ( $o == 'on') { $rs='ON'; }
if ( $o == 'off') { $rs='OFF'; }


?>
    <tr>
    <td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
    <td><?php echo $a['name']; ?></td>
	<td><?php echo $a['temp_actual']; ?></td>
	<td><?php echo $a['temp_set']; ?></td>
    <td><?php echo $a['work_mode']; ?></td>
	<td><?php echo $a['status']; ?></td>
    <td><?php echo $rs; ?></td>
    
    </tr>
<?php
}

?>
</tbody>
</table>
</div>
</div>
<?php }  ?>
