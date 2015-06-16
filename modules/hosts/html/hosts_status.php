<?php 
$dir="modules/gpio/";
$db = new PDO('sqlite:dbf/hosts.db') or die ("cannot open database");
$sth = $db->prepare("select * from hosts");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Monitoring</h3>
</div>
<div class="panel-body">
<table class="table table-striped">
<?php
foreach ( $result as $a) {
?>
    <tr>
    <td>	<img type="image" src="media/ico/Computer-icon.png" /></td>
    <td><?php echo str_replace("host_","",$a["name"]);?></td>
    <td><?php echo $a['last']; ?> ms</td>
    <td></td>
    <td><?php echo $a['status']; ?></td>
    </tr>

<?php
}

?>
    </table>
</div>
</div>
<?php }  ?>