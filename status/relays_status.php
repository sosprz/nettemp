<?php 
$dir="modules/gpio/";
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from relays");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="grid-item rs">
<div class="panel panel-default">
            <div class="panel-heading">WiFi Relays</div>
<table class="table table-hover table-condensed">
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
    <td><?php echo $a['status']; ?></td>
    <td><?php echo $rs; ?></td>
    
    </tr>
<?php
}

?>
</table>
            </div>
		</div>
<?php }  ?>
