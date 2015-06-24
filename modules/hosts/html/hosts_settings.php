<?php

$rand=substr(rand(), 0, 10);
$host_name = isset($_POST['host_name']) ? $_POST['host_name'] : '';
$host_ip = isset($_POST['host_ip']) ? $_POST['host_ip'] : '';
$host_id = isset($_POST['host_id']) ? $_POST['host_id'] : '';
$host_type = isset($_POST['host_type']) ? $_POST['host_type'] : '';

?>
<div class="panel panel-default">
<div class="panel-heading">Monitoring</div>

<?php // SQlite
	$host_add1 = isset($_POST['host_add1']) ? $_POST['host_add1'] : '';
	if (!empty($host_name)  && !empty($host_ip) && ($host_add1 == "host_add2") ){
	$db = new PDO('sqlite:dbf/hosts.db');
	$host_name=host_ . $host_name;
	$host_name=str_replace(".","",$host_name);
	$db->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type) VALUES ('$host_name', '$host_ip', '$host_name', '$host_type')") or die ("cannot insert to DB" );
	    $dbnew = new PDO("sqlite:db/$host_name.sql");
	    $dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
	    $dbnew==NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}	
?>
	

<?php // SQLite - del
	if (!empty($host_name) && ($_POST['host_del1'] == "host_del2") ){
	$db = new PDO('sqlite:dbf/hosts.db');
	$db->exec("DELETE FROM hosts WHERE name='$host_name'") or die ($db->lastErrorMsg());
	unlink("db/$host_name.sql");
	unlink("tmp/mail/$host_name.mail");
	unlink("tmp/mail/hour/$host_name.mail");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>
<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th></th><th>Name</th><th>IP / Name</th><th>Type</th><th>Add / Rem</tf></tr></thead>
<tr>	
	<form action="" method="post" class="form-horizontal">
	<div class="form-group">
	<td></td>
	<td><input type="text" name="host_name" value="" class="form-control" required=""/></td>
	<td><input type="text" name="host_ip" value="" class="form-control" required=""/></td>
	<td>
	<select name="host_type" class="form-control">
	    <option value="ping">ping</option>
	    <option value="httpping">http ping</option>
        </select>
	</td>
	<input type="hidden" name="host_add1" value="host_add2" class="form-control"/>
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
	</div>
	</form>
</tr>


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
	
	<form action="" method="post" class="form-horizontal">
	<input type="hidden" name="host_name" value="<?php echo $a["name"]; ?>" />
	<input type="hidden" type="submit" name="host_del1" value="host_del2" />
	<td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
	</form>
</tr>
	
<?php 
    }
?>
</table>
</div>
</div>