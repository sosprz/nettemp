<?php 
$dir="modules/gpio/";
$db = new PDO('sqlite:dbf/nettemp.db') or die ("cannot open database");
$sth = $db->prepare("select * from relays");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="panel panel-default">
            <div class="panel-heading">WiFi Relays</div>
<table class="table table-striped">
<?php
foreach ( $result as $a) {
$ip=$a['ip'];
$cmd="curl $ip/status";
exec($cmd, $i);
$s=$i[0];
$o=str_replace('status', '', $s);
if ( $o == '1') { $rs='ON'; }
if ( $o == '0') { $rs='OFF'; }


?>
    <tr>
    <td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
    <td><?php echo $a['name']; ?></td>
    <td><?php echo $a['status']; ?></td>
    <td><?php echo $rs; ?></td>
    
    </tr>
<?php
}

?>
</table>
            </div>
<?php }  ?>