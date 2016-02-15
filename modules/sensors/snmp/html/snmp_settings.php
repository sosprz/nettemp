<?php
$snmp_name = isset($_POST['snmp_name']) ? $_POST['snmp_name'] : '';
$snmp_community = isset($_POST['snmp_community']) ? $_POST['snmp_community'] : '';
$snmp_host = isset($_POST['snmp_host']) ? $_POST['snmp_host'] : '';
$snmp_oid = isset($_POST['snmp_oid']) ? $_POST['snmp_oid'] : '';
$snmp_id = isset($_POST['snmp_id']) ? $_POST['snmp_id'] : '';
$snmp_type = isset($_POST['snmp_type']) ? $_POST['snmp_type'] : '';
$snmp_divider = isset($_POST['snmp_divider']) ? $_POST['snmp_divider'] : '';
$snmp_version = isset($_POST['snmp_version']) ? $_POST['snmp_version'] : '';
$snmpid = isset($_POST['snmpid']) ? $_POST['snmpid'] : '';
$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
	$db = new PDO('sqlite:dbf/snmp.db');
	$dbn = new PDO('sqlite:dbf/nettemp.db');


?>

<?php // SQlite
$snmp_add1 = isset($_POST['snmp_add1']) ? $_POST['snmp_add1'] : '';
	if (!empty($snmp_name)  && !empty($snmp_community) && !empty($snmp_host) && !empty($snmp_oid) && ($snmp_add1 == "snmp_add2") ){
	if (empty($snmp_divider)) {
	    $snmp_divider='1';
	}
	$rom="snmp_".$snmp_name."_".$snmp_type;
	$map_num=substr(rand(), 0, 4);
	$db->exec("INSERT OR IGNORE INTO snmp (name, rom, community, host, oid, divider, type, version ) VALUES ('$snmp_name','$rom','$snmp_community', '$snmp_host', '$snmp_oid', '$snmp_divider', '$snmp_type', '$snmp_version')") or die ("cannot insert to DB 1" );
	$dbn->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$rom')");
        $dbn->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, device, map_pos, map_num, adj, charts) VALUES ('$snmp_name','$rom','$snmp_type', 'off', 'wait', 'snmp', '{left:0,top:0}', '$map_num', 0, 'on')") or die ("cannot insert to DB 2" );

	$dbnew = new PDO("sqlite:db/$rom.sql");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER, current INTEEGER, last INTEEGER)");

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

<div class="panel panel-default">
<div class="panel-heading">Add sensor over SNMP</div>

<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead><tr><th></th><th>Name</th><th>Community</th><th>Version</th><th>Host</th><th>OID</th><th>Divider</th><th>Type</th><th>Add/Rem</th></tr></thead>
    <form action="" method="post" class="form-horizontal">
	<tr>
	<td></td>
	<td class="col-md-1"><input type="text" name="snmp_name" value="" class="form-control input-sm" required=""/></td>
	<td class="col-md-1"><input type="text" name="snmp_community"  value="" class="form-control input-sm" required=""/></td>
	<td class="col-md-1">
	<select name="snmp_version" class="form-control input-sm">
	    <option value="1">v1</option>
	    <option value="2c">v2c</option>
	</select>
	</td>
	<td class="col-md-2"><input type="text" name="snmp_host"  value="" class="form-control input-sm" required=""/></td>
	<td class="col-md-4"><input type="text" name="snmp_oid" value="" class="form-control input-sm" required=""/></td>
	<td class="col-md-1"><input type="text" name="snmp_divider" value="" class="form-control input-sm"/></td>
	<input type="hidden" name="snmp_add1" value="snmp_add2" class="form-control input-sm"/>
	<td class="col-md-3">
	<select name="snmp_type" class="form-control input-sm">
	    <option value="temp">Temp</option>
	    <option value="humid">Humid</option>
	    <option value="press">Pressure</option>
	    <option value="volt">Volt</option>
	    <option value="amps">Amps</option>
	    <option value="watt">Watt</option>
	    <option value="elec">Electricity</option>
	</select>
	</td>
	<td class="col-md-1"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
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
	<td><?php echo $a["version"];?></td>
	<td><?php echo $a["host"]; ?></td>
	<td><?php echo $a["oid"]; ?></td>
	<td><?php echo $a["divider"]; ?></td>
	<td><?php echo $a["type"]; ?></td>
	

	<form action="" method="post">
	<input type="hidden" name="snmp_id" value="<?php echo $a["id"]; ?>"/>
	<input type="hidden" name="snmp_name" value="<?php echo $a["name"]; ?>"/>
	<input type="hidden" type="submit" name="snmp_del1" value="snmp_del2" />
	<td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
	</form>
	</tr>
<?php 
    }
?>
</table>
</div>
</div>