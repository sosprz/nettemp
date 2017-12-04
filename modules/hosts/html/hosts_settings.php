<?php

$rand=substr(rand(), 0, 10);
$host_rom = isset($_POST['host_rom']) ? $_POST['host_rom'] : '';
$host_name = isset($_POST['host_name']) ? $_POST['host_name'] : '';
$host_ip = isset($_POST['host_ip']) ? $_POST['host_ip'] : '';
$host_id = isset($_POST['host_id']) ? $_POST['host_id'] : '';
$host_type = isset($_POST['host_type']) ? $_POST['host_type'] : '';
$map_num=substr(rand(), 0, 4);

    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $position_id = isset($_POST['position_id']) ? $_POST['position_id'] : '';
    if (!empty($position_id) && ($_POST['positionok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE hosts SET position='$position' WHERE id='$position_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
 

	//ADD
    $host_add1 = isset($_POST['host_add1']) ? $_POST['host_add1'] : '';
    if (!empty($host_name)  && !empty($host_ip) && ($host_add1 == "host_add2") ){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$rom="host_".$host_name;
		$host_name=str_replace(".","",$host_name);
		//ADD TO HOSTS
		$db->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type, map_pos, map_num, map, position) VALUES ('$host_name', '$host_ip', '$rom', '$host_type', '{left:0,top:0}', '$map_num', 'on', '1')") or die ("cannot insert to DB 01" );
		//ADD TO SENSORS
		$db->exec("INSERT OR IGNORE INTO newdev (name,rom,type,ip,seen) VALUES ('$host_name','$rom','host','$host_ip','1')");
		$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, device, alarm, tmp, ip, adj, charts, sum, position, ch_group) VALUES ('$host_name','$rom', 'host', 'ip','off', 'wait', '$host_ip', '0', 'on', '0', '1', 'host')") or die ("cannot insert to DB 02" );
		//ADD TO MAPS
		$inserted=$db->query("SELECT id FROM sensors WHERE rom='$rom'");
		$inserted_id=$inserted->fetchAll();
		$inserted_id=$inserted_id[0];
		$db->exec("INSERT OR IGNORE INTO maps (element_id, type, map_pos, map_num, map_on) VALUES ('$inserted_id[id]','sensors','{left:0,top:0}','$map_num','on')");
		//ADD DB
		$dbnew = new PDO("sqlite:db/$rom.sql");
		$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");

		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }	

    if (!empty($host_rom) && ($_POST['host_del1'] == "host_del2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	//maps settings
	$to_delete=$db->query("SELECT id FROM sensors WHERE rom='$host_rom'");
	$to_delete_id=$to_delete->fetchAll();
	$to_delete_id=$to_delete_id[0];
	$db->exec("DELETE FROM maps WHERE element_id='$to_delete_id[id]' AND type='host'");
	//sensors
	$db->exec("DELETE FROM sensors WHERE rom='$host_rom'");
	$db->exec("DELETE FROM hosts WHERE rom='$host_rom'");
	unlink("db/$host_rom.sql");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

  

?>

<div class="panel panel-default">
<div class="panel-heading">Host monitoring</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead>
<tr>
<th></th>
<th>Name</th>
<th>IP / Name</th>
<th>Type</th>
<th></th>

</tr>
</thead>
<tr>
	<td class="col-md-0"><img src="media/ico/Global-Network-icon.png" ></td>
	<td class="col-md-1">
	    <form action="" method="post" class="form-horizontal">
		<input type="text" name="host_name" value="" class="form-control input-sm" required=""/>
	</td>
	<td class="col-md-1">
		<input type="text" name="host_ip" value="" class="form-control input-sm" required=""/>
	</td>
	<td class="col-md-1">
	    <select name="host_type" class="form-control input-sm">
		<option value="ping">ping</option>
		<option value="httpping">http ping</option>
    	    </select>
	</td>
	    <input type="hidden" name="host_add1" value="host_add2" class="form-control"/>
	<td class="col-md-10">
	    <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
	</td>
	</form>
</tr>


<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from hosts ORDER BY position ASC ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
<tr>
	<td><img src="media/ico/Global-Network-icon.png" ></td>
	<td><?php echo $a["name"];?></td>
	<td><?php echo $a["ip"];?></td>
	<td><?php echo $a["type"];?></td>

	<td>
	<form action="" method="post" class="form-horizontal">
	    <input type="hidden" name="host_rom" value="<?php echo $a["rom"]; ?>" />
	    <input type="hidden" type="submit" name="host_del1" value="host_del2" />
	    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
	</form>
	</td>
	
</tr>
	
<?php 
    }
?>
</table>
</div>
</div>
