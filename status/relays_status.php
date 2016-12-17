<?php 
$dir="modules/gpio/";
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from sensors where type='relay' AND status!='on' AND (ch_group='' OR ch_group is null)");
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
  
$ch = curl_init();
$optArray = array(
    CURLOPT_URL => "$ip/showstatus",
    CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array($ch, $optArray);
$res = curl_exec($ch);

$o1=str_replace('status', '', $res);
$o=trim($o1);

if ( $o == 'on') { $rs='ON'; }
if ( $o == 'off') { $rs='OFF'; }


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
