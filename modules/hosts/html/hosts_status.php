<?php 
$dir="modules/gpio/";
$db = new PDO('sqlite:dbf/hosts.db') or die ("cannot open database");
$sth = $db->prepare("select * from hosts");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
?>
<?php if ( $numRows > '0' ) { ?>
<span class="belka">&nbsp Host status<span class="okno"> 
    <table>
<?php
foreach ( $result as $a) {
?>
    <tr>
    <td>	<img type="image" src="media/ico/Computer-icon.png" /></td>
    <td><?php echo str_replace("host_","",$a["name"]);?></td>
    <td><?php echo $a['last']; ?></td>
    <td><?php echo $a['type']; ?></td>
    <td><?php echo $a['status']; ?></td>
    </tr>

<?php
}

?>
    </table>
</span></span>
<?php }  ?>