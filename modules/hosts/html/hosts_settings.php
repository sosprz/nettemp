<?php

$host_name = isset($_POST['host_name']) ? $_POST['host_name'] : '';
$host_ip = isset($_POST['host_ip']) ? $_POST['host_ip'] : '';
$host_id = isset($_POST['host_id']) ? $_POST['host_id'] : '';
$host_type = isset($_POST['host_type']) ? $_POST['host_type'] : '';

?>

<?php // SQlite
	$host_add1 = isset($_POST['host_add1']) ? $_POST['host_add1'] : '';
	if (!empty($host_name)  && !empty($host_ip) && ($host_add1 == "host_add2") ){
	$db = new PDO('sqlite:dbf/hosts.db');
	$host_name=host_ . $host_name;
	$host_name=str_replace(".","",$host_name);
	$db->exec("INSERT OR IGNORE INTO hosts (name, ip, type) VALUES ('$host_name', '$host_ip', '$host_type')") or die ("cannot insert to DB" );
	    $dbnew = new PDO("sqlite:db/$host_name.sql");
	    $dbnew->exec('CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)');
	    $dbnew==NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}	
	elseif ($host_add1 == "host_add2") { echo " Please input name and IP"; }
	?>
	

<?php // SQLite - del
	if (!empty($host_name) && ($_POST['host_del1'] == "host_del2") ){
	$db = new PDO('sqlite:dbf/hosts.db');
	$db->exec("DELETE FROM hosts WHERE name='$host_name'") or die ($db->lastErrorMsg());
	unlink("db/$host_name.sql");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>


<span class="belka">&nbsp Add host to monitoring<span class="okno">
<table>
<tr><td></td><td>name</td><td>ip or name</td><td>type</td></tr>
<tr>	
	<form action="" method="post">
	<td></td>
	<td><input type="text" name="host_name" size="10" value="" /></td>
	<td><input type="text" name="host_ip" size="7" value="" /></td>
	<td>
	<select name="host_type" >
	    <option value="ping">ping</option>
	    <option value="httpping">http ping</option>
        </select>
	</td>
	<input type="hidden" name="host_add1" value="host_add2" />
	<td><input type="image" src="media/ico/Add-icon.png" /></td>
	</tr>
	</form>

<?php

$db = new PDO('sqlite:dbf/hosts.db');
$sth = $db->prepare("select * from hosts ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
	<tr>
	<td><img src="media/ico/Computer-icon.png" ></td>
	<td><?php echo str_replace("host_","",$a["name"]);?></td>
	<td><?php echo $a["ip"];?></td>
	<td><?php echo $a["type"];?></td>
	
	<form action="" method="post"> 	
	<input type="hidden" name="host_name" value="<?php echo $a["name"]; ?>" />
	<input type="hidden" type="submit" name="host_del1" value="host_del2" />
   <td><input type="image" src="media/ico/Close-2-icon.png"  /></td></tr>
	</form>
<?php }


		
	
		?>
	
</tr></table>
</span></span>
