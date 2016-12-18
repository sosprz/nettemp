<?php 
$dir="modules/gpio/";
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from sensors where type='switch' AND status!='on' AND (ch_group='' OR ch_group is null)");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="grid-item rs">
<div class="panel panel-default">
            <div class="panel-heading">IP switch</div>
<table class="table table-hover table-condensed">
<?php
foreach ( $result as $a) {


$tmp=$a['tmp'];

  
if ( $tmp == '1.0') { $rs='ON'; }
if ( $tmp == '0.0') { $rs='OFF'; }


?>
    <tr>
    <td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
    <td><?php echo $a['name']; ?></td>
    <td><?php echo $rs; ?></td>
    
    </tr>
<?php
}

?>
</table>
</div>
</div>
<?php }  ?>
