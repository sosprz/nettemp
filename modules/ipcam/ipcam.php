<div class="panel panel-default">
<div class="panel-heading">Camera</div>
<?php
$link = isset($_POST['link']) ? $_POST['link'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$name_del = isset($_POST['name_del']) ? $_POST['name_del'] : '';
?>

<?php 
	if (!empty($name)  && !empty($link) && ($_POST['add'] == "add")){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO camera (name, link) VALUES ('$name', '$link')") or die ($db->lastErrorMsg());
	$fi = explode("/",$link);
	$link = explode(":",$fi[2]);
	$ip=$link[0];
		
        $dbhost = new PDO("sqlite:dbf/hosts.db");	
	$dbhost->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type) VALUES ('host_cam_$name', '$ip', 'host_$name', 'ping')") or die ("cannot insert host to DB" );	
	$dbnew = new PDO("sqlite:db/host_$name.sql");
        $dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
        $dbnew==NULL;

	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>
	
<?php // SQLite - usuwanie notification
	if (!empty($name_del) && ($_POST['del'] == "del") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM camera WHERE name='$name_del'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Name</th><th>link</th><th></th></tr></thead>
<tbody>
	<form action="" method="post">
	<tr>
	<td class="col-md-2"><input type="text" name="name" size="20" value="" class="form-control" required=""/></td>
	<td class="col-md-4"><input type="text" name="link" size="30" value="" class="form-control" required=""/></td>
	<input type="hidden" name="add" value="add" />
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	</form>
	</tr>

<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from camera");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
$link=$a['link'];
?>
    
	<tr>
	<td><img type="image" src="media/ico/Security-Camera-icon.png" />
	<?php echo $a["name"];?></td>
	<td><?php echo $a["link"];?></td>
	<form action="" method="post">
	    
	    <input type="hidden" name="name_del" value="<?php echo $a["name"]; ?>" />
	    <input type="hidden" type="submit" name="del" value="del" />
	    <td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
	</form>
	</tr>

<?php }


?>
</tbody>
</table>
</div>
		
<div class="panel-body">
<span id="helpBlock" class="help-block">rtsp://172.18.10.103:554/play1.sdp</span>
<span id="helpBlock" class="help-block">rtsp://guest:guest@172.18.10.103:554/play1.sdp</span>
</div>
</div>
