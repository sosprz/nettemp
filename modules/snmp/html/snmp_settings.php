<?php
$snmp_name = $_POST["snmp_name"];  
$snmp_community = $_POST["snmp_community"];  
$snmp_host = $_POST["snmp_host"];  
$snmp_oid = $_POST["snmp_oid"];  
$snmp_id = $_POST["snmp_id"];  
$snmp_divider = $_POST["snmp_divider"];  
$snmpid = "snmp_$snmp_name"


?>

<?php // SQlite
	
	if (!empty($snmp_name)  && !empty($snmp_community) && !empty($snmp_host) && !empty($snmp_oid) && ($_POST['snmp_add1'] == "snmp_add2") ){
	$db = new PDO('sqlite:dbf/snmp.db');
	$db->exec("INSERT OR IGNORE INTO snmp (name, community, host, oid, divider) VALUES ('$snmpid', '$snmp_community', '$snmp_host', '$snmp_oid', '$snmp_divider')") or die ("cannot insert to DB" );
	$file = 'tmp/onewire';
	$current = file_get_contents($file);
	$current .= "$snmpid\n";
	file_put_contents($file, $current);
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}	
	elseif ($_POST['snmp_add1'] == "snmp_add2") { echo " Please input name, community, host and oid"; }
	?>
	
	<?php 
	
	// SQLite - update 
	if ( $_POST['notif_update1'] == "notif_update2"){
	$db = new PDO('sqlite:dbf/snmp.db');
	$db->exec("UPDATE recipient SET sms_alarm='$notif_update_sms' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	$db->exec("UPDATE recipient SET mail_alarm='$notif_update_mail' WHERE id='$notif_update'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	 ?>
	

<?php // SQLite - del
	if (!empty($snmp_id) && ($_POST['snmp_del1'] == "snmp_del2") ){
	$db = new PDO('sqlite:dbf/snmp.db');
	$db->exec("DELETE FROM snmp WHERE id='$snmp_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>


<span class="belka">&nbsp Add sensor over SNMP<span class="okno">
<table>
<tr><td></td><td>name</td><td>community</td><td>host</td><td>OID</td><td>Divider</td></tr>
<tr>	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<td></td>
	<td><input type="text" name="snmp_name" size="20" value="" /></td>
	<td><input type="text" name="snmp_community" size="20" value="" /></td>
	<td><input type="text" name="snmp_host" size="20" value="" /></td>
	<td><input type="text" name="snmp_oid" size="20" value="" /></td>
	<td><input type="text" name="snmp_divider" size="20" value="" /></td>
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
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"> 	
	<input type="hidden" name="snmp_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" type="submit" name="snmp_del1" value="snmp_del2" />
   <td><input type="image" src="media/ico/Close-2-icon.png"  /></td></tr>
	</form>
<?php }


		
	
		?>
	
</tr></table>
</span></span>
