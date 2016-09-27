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
<div class="grid-item rs">
<div class="panel panel-default">
            <div class="panel-heading">WiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi HeatersWiFi Heaters</div>
<table class="table table-hover table-condensed">

    <tr>
    <td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
    <td><?php echo $a['name']; ?></td>
    <td><?php echo $a['work_mode']; ?></td>
    <td><?php echo $rs; ?></td>
    
    </tr>
<?php
}

?>
</table>
</div>
</div>
<?php }  ?>
