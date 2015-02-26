<?php



$snmp_name = isset($_POST['snmp_name']) ? $_POST['snmp_name'] : '';
$snmp_community = isset($_POST['snmp_community']) ? $_POST['snmp_community'] : '';
$snmp_host = isset($_POST['snmp_host']) ? $_POST['snmp_host'] : '';
$snmp_oid = isset($_POST['snmp_oid']) ? $_POST['snmp_oid'] : '';
$snmp_id = isset($_POST['snmp_id']) ? $_POST['snmp_id'] : '';
$snmp_divider = isset($_POST['snmp_divider']) ? $_POST['snmp_divider'] : '';
$snmpid = isset($_POST['snmpid']) ? $_POST['snmpid'] : '';
	$db = new PDO('sqlite:dbf/snmp.db');
	$dbn = new PDO('sqlite:dbf/nettemp.db');


?>

<?php // SQlite
$snmp_add1 = isset($_POST['snmp_add1']) ? $_POST['snmp_add1'] : '';
	if (!empty($snmp_name)  && !empty($snmp_community) && !empty($snmp_host) && !empty($snmp_oid) && ($snmp_add1 == "snmp_add2") ){
	if (empty($snmp_divider)) {
	    $snmp_divider='1';
	}
	$snmp_name=snmp_ . $snmp_name . _temp;
	$db->exec("INSERT OR IGNORE INTO snmp (name, community, host, oid, divider) VALUES ('$snmp_name', '$snmp_community', '$snmp_host', '$snmp_oid', '$snmp_divider')") or die ("cannot insert to DB" );
	$dbn->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$snmp_name')");
        $dbn->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio) VALUES ('$snmp_name','$snmp_name','snmp', 'off', 'wait', '$gpio_post' )") or die ("cannot insert to " );

	$dbnew = new PDO("sqlite:db/$snmp_name");
	$dbnew->exec('CREATE TABLE def (time DATETIME DEFAULT CURRENT_TIMESTAMP, value INTEEGER)');

	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}	
	elseif ($snmp_add1 == "snmp_add2") { echo " Please input name, community, host and oid"; }
	?>
	
	<?php 
	$notif_update1 = isset($_POST['notif_update1']) ? $_POST['notif_update1'] : '';
	// SQLite - update 
	if ( $notif_update1 == "notif_update2"){
	$db = new PDO('sqlite:dbf/snmp.db');
	$db->exec("UPDATE recipient SET sms_alarm='$notif_update_sms' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE recipient SET mail_alarm='$notif_update_mail' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?>
	

<?php // SQLite - del
	if (!empty($snmp_id) && ($_POST['snmp_del1'] == "snmp_del2") ){
	$db->exec("DELETE FROM snmp WHERE id='$snmp_id'") or die ($db->lastErrorMsg());
	$dbn->exec("DELETE FROM newdev WHERE list='$snmp_name'"); 
	header("location: " . $_SERVER['REQUEST_URI']);
	echo $snmp_id;
	exit();
	}
	?>


<span class="belka">&nbsp Add sensor over SNMP<span class="okno">
<table>
<tr><td></td><td>name</td><td>community</td><td>host</td><td>OID</td><td>Divider</td></tr>
<tr>	
	<form action="" method="post">
	<td></td>
	<td><input type="text" name="snmp_name" size="10" value="" /></td>
	<td><input type="text" name="snmp_community" size="7" value="" /></td>
	<td><input type="text" name="snmp_host" size="7" value="" /></td>
	<td><input type="text" name="snmp_oid" size="60" value="" /></td>
	<td><input type="text" name="snmp_divider" size="1" value="" /></td>
	<input type="hidden" name="snmp_add1" value="snmp_add2" />
	<td><input type="image" src="media/ico/Add-icon.png" /></td>
	</tr>
	</form>

<?php

$db = new PDO('sqlite:dbf/snmp.db');
$sth = $db->prepare("select * from snmp ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
	<tr>
	<td><img src="media/ico/snmp-icon.png" ></td>
	<td><?php echo $a["name"];?></td>
	<td><?php echo $a["community"];?></td>
	<td><?php echo $a["host"]; ?></td>
	<td><?php echo $a["oid"]; ?></td>
	<td><?php echo $a["divider"]; ?></td>
	
	<form action="" method="post"> 	
	<input type="hidden" name="snmp_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="snmp_name" value="<?php echo $a["name"]; ?>" />
	<input type="hidden" type="submit" name="snmp_del1" value="snmp_del2" />
   <td><input type="image" src="media/ico/Close-2-icon.png"  /></td></tr>
	</form>
<?php }


		
	
		?>
	
</tr></table>
</span></span>
