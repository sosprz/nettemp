<?php 
$dir="modules/gpio/";
$db = new PDO('sqlite:dbf/nettemp.db') or die ("cannot open database");
$sth = $db->prepare("select * from gpio where mode='trigger' or mode='simple' or mode='day' or mode='week' or mode='temp' or mode='call' ");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<div class="panel panel-default">
            <div class="panel-heading">GPIO</div>
<table class="table table-hover">
<?php
foreach ( $result as $a) {
$gpio=$a['gpio'];
?>
    <tr>
    <td <?php echo $a['status'] == 'ALARM' ? 'class="danger"' : '' ?>><img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
    <td <?php echo $a['status'] == 'ALARM' ? 'class="danger"' : '' ?>><?php echo $a['name']; ?></td>
    <td <?php echo $a['status'] == 'ALARM' ? 'class="danger"' : '' ?>><?php echo $a['mode']; ?></td>
    <td <?php echo $a['status'] == 'ALARM' ? 'class="danger"' : '' ?>><?php echo $a['status']; ?></td>
    </tr>
<?php
}

?>
</table>
            </div>
<?php }  ?>