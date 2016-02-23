<?php

$rand=substr(rand(), 0, 10);
$host_name = isset($_POST['host_name']) ? $_POST['host_name'] : '';
$host_ip = isset($_POST['host_ip']) ? $_POST['host_ip'] : '';
$host_id = isset($_POST['host_id']) ? $_POST['host_id'] : '';
$host_type = isset($_POST['host_type']) ? $_POST['host_type'] : '';
$map_num=substr(rand(), 0, 4);

    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $position_id = isset($_POST['position_id']) ? $_POST['position_id'] : '';
    if (!empty($position_id) && ($_POST['positionok'] == "ok")){
    $db = new PDO('sqlite:dbf/hosts.db');
    $db->exec("UPDATE hosts SET position='$position' WHERE id='$position_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 
 


    $host_add1 = isset($_POST['host_add1']) ? $_POST['host_add1'] : '';
    if (!empty($host_name)  && !empty($host_ip) && ($host_add1 == "host_add2") ){
	$db = new PDO('sqlite:dbf/hosts.db');
	$host_name=host_ . $host_name;
	$host_name=str_replace(".","",$host_name);
	$db->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type, map_pos, map_num, map, position) VALUES ('$host_name', '$host_ip', '$host_name', '$host_type', '{left:0,top:0}', '$map_num', 'on', '1')") or die ("cannot insert to DB" );
	    $dbnew = new PDO("sqlite:db/$host_name.sql");
	    $dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
	    $dbnew==NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }	

    if (!empty($host_name) && ($_POST['host_del1'] == "host_del2") ){
	$db = new PDO('sqlite:dbf/hosts.db');
	$db->exec("DELETE FROM hosts WHERE name='$host_name'") or die ($db->lastErrorMsg());
	unlink("db/$host_name.sql");
	unlink("tmp/mail/$host_name.mail");
        unlink("tmp/mail/hour/$host_name.mail");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $map = isset($_POST['map']) ? $_POST['map'] : '';
    $maponoff = isset($_POST['maponoff']) ? $_POST['maponoff'] : '';
    $mapon = isset($_POST['mapon']) ? $_POST['mapon'] : '';
    if (($maponoff == "onoff")){
	$db = new PDO('sqlite:dbf/hosts.db');
	$db->exec("UPDATE hosts SET map='$mapon' WHERE id='$map'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
    $alarm = isset($_POST['alarm']) ? $_POST['alarm'] : '';
    $alarmonoff = isset($_POST['alarmonoff']) ? $_POST['alarmonoff'] : '';
    $alarmon = isset($_POST['alarmon']) ? $_POST['alarmon'] : '';
    if (($alarmonoff == "onoff")){
	$db = new PDO('sqlite:dbf/hosts.db');
	$db->exec("UPDATE hosts SET alarm='$alarmon' WHERE id='$alarm'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

?>

<div class="panel panel-default">
<div class="panel-heading">Host monitoring</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small"">
<thead><tr><th>Pos</th><th>Name</th><th>IP / Name</th><th>Type</th><th>Map</th><th>Alarm</th><th></th></tr></thead>
<tr>
    <td>
    </td>
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
	</td>
	<td>
	    <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button>
	</td>
	</form>
</tr>


<?php

$db = new PDO('sqlite:dbf/hosts.db');
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
	<td><?php echo str_replace("host_","",$a["name"]);?></td>
	<td><?php echo $a["ip"];?></td>
	<td><?php echo $a["type"];?></td>
	<td >
	<form action="" method="post" style="display:inline!important;"> 	
	    <input type="hidden" name="map" value="<?php echo $a["id"]; ?>" />
	    <input type="checkbox" data-toggle="toggle" data-size="mini"  name="mapon" value="on" <?php echo $a["map"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	    <input type="hidden" name="maponoff" value="onoff" />
	</form>
	</td>
	<td >
	<form action="" method="post" style="display:inline!important;"> 	
	    <input type="hidden" name="alarm" value="<?php echo $a["id"]; ?>" />
	    <input type="checkbox" data-toggle="toggle" data-size="mini"  name="alarmon" value="on" <?php echo $a["alarm"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
	    <input type="hidden" name="alarmonoff" value="onoff" />
	</form>
	</td>
	<td>
	<form action="" method="post" class="form-horizontal">
	    <input type="hidden" name="host_name" value="<?php echo $a["name"]; ?>" />
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