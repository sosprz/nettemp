<?php 
$dir="modules/gpio/";
$db = new PDO('sqlite:dbf/nettemp.db') or die ("cannot open database");
$sth = $db->prepare("select * from gpio");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<span class="belka">&nbsp Gpio status<span class="okno"> 
<?php
foreach ( $result as $a) {
$gpio=$a['gpio'];
?>
    <table><tr>
    <td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
    <td><?php echo $a['name']; ?></td>
    <td><?php echo $a['mode']; ?></td>
    <td><?php echo $a['status']; ?></td>
    </tr></table>
<?php
}

?>

</span></span>
<?php }  ?>