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
	$host_name=host_ . $host_name;
	$host_name=str_replace(".","",$host_name);
	$db->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type, map_pos, map_num, map, position) VALUES ('$host_name', '$host_ip', '$host_name', '$host_type', '{left:0,top:0}', '$map_num', 'on', '1')") or die ("cannot insert to DB" );
	//maps settings
	//$inserted=$db->query("SELECT id FROM hosts WHERE name='$host_name'");
	//$inserted_id=$inserted->fetchAll();
	//$inserted_id=$inserted_id[0];
	//$db->exec("INSERT OR IGNORE INTO maps (element_id, type, map_pos, map_num, map_on) VALUES ('$inserted_id[id]','hosts','{left:0,top:0}','$map_num','on')");
	
	//add to sensors
	$db->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$host_name')");
	$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, ip, adj, charts, sum, map_pos, map_num, position, map, status) VALUES ('$host_name','$host_name', 'host', 'off', 'wait', '$host_ip', '0', 'on', '0', '{left:0,top:0}', '$map_num', '1', 'on', 'on')") or die ("cannot insert to DB" );
	
    $dbnew = new PDO("sqlite:db/$host_name.sql");
    $dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
    $dbnew==NULL;
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
	//header("location: " . $_SERVER['REQUEST_URI']);
	//exit();
	echo $host_rom."\n";
    }

  
    $alarm = isset($_POST['alarm']) ? $_POST['alarm'] : '';
    $alarmonoff = isset($_POST['alarmonoff']) ? $_POST['alarmonoff'] : '';
    $alarmon = isset($_POST['alarmon']) ? $_POST['alarmon'] : '';
    if (($alarmonoff == "onoff")){
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE hosts SET alarm='$alarmon' WHERE rom='$host_rom'") or die ($db->lastErrorMsg());
		if($alarmon!='on') {
		$db->exec("UPDATE hosts SET mail='' WHERE rom='$host_name'");
   	}
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
    }

?>

<div class="panel panel-default">
<div class="panel-heading">Host monitoring</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small"">
<thead>
<tr>
<th>Pos</th>
<th>Name</th>
<th>IP / Name</th>
<th>Type</th>
<th>Alarm</th>
<th></th>
</tr>
</thead>
<tr>
	<td></td>
	<td>
	    <form action="" method="post" class="form-horizontal">
		<input type="text" name="host_name" value="" class="form-control input-sm" required=""/>
	</td>
	<td>
		<input type="text" name="host_ip" value="" class="form-control input-sm" required=""/>
	</td>
	<td>
	    <select name="host_type" class="form-control input-sm">
		<option value="ping">ping</option>
		<option value="httpping">http ping</option>
    	    </select>
	</td>
	    <input type="hidden" name="host_add1" value="host_add2" class="form-control"/>
	<td>
	</td>
	<td>
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
        <td>
	<form action="" method="post" style="display:inline!important;">
	    <input type="hidden" name="position_id" value="<?php echo $a["id"]; ?>" />
    	    <input type="text" name="position" size="1" maxlength="3" value="<?php echo $a['position']; ?>" />
    	    <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	    <input type="hidden" name="positionok" value="ok" />
	</form>
	</td>
	<td><?php echo $a["name"];?></td>
	<td><?php echo $a["ip"];?></td>
	<td><?php echo $a["type"];?></td>
	<td >
	<form action="" method="post" style="display:inline!important;">
	    <input type="hidden" name="host_rom" value="<?php echo $a["rom"]; ?>" />
	    <input type="hidden" name="alarm" value="<?php echo $a["id"]; ?>" />
	    <input type="checkbox" data-toggle="toggle" data-size="mini"  name="alarmon" value="on" <?php echo $a["alarm"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	    <input type="hidden" name="alarmonoff" value="onoff" />
	</form>
	</td>
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
