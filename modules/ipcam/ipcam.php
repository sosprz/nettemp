<div class="panel panel-default">
<div class="panel-heading">Camera</div>
<?php
$link = isset($_POST['link']) ? $_POST['link'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$name_del = isset($_POST['name_del']) ? $_POST['name_del'] : '';

if (!empty($name)  && !empty($link) && ($_POST['add'] == "add")){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO camera (name, link) VALUES ('$name', '$link')") or die ($db->lastErrorMsg());
	$fi = explode("/",$link);
	$link = explode(":",$fi[2]);
	$ip=$link[0];
	$map_num=substr(rand(), 0, 4);
		
        $dbhost = new PDO("sqlite:dbf/hosts.db");	
	$dbhost->exec("INSERT OR IGNORE INTO hosts (name, ip, rom, type, map_num, map_pos) VALUES ('host_cam_$name', '$ip', 'host_$name', 'ping', '$map_num', '{left:0,top:0}')") or die ("cannot insert host to DB" );	
	$dbnew = new PDO("sqlite:db/host_$name.sql");
        $dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
        $dbnew==NULL;

	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
}

if (!empty($name_del) && ($_POST['del'] == "del") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM camera WHERE name='$name_del'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
}

$access_all = isset($_POST['access_all']) ? $_POST['access_all'] : '';
$access_allonoff = isset($_POST['access_allonoff']) ? $_POST['access_allonoff'] : '';
$access_allon = isset($_POST['access_allon']) ? $_POST['access_allon'] : '';
if (($access_allonoff == "onoff")){
    $db->exec("UPDATE camera SET access_all='$access_allon' WHERE id='$access_all'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead><tr><th>Name</th><th>Link</th><th>Access all</th><th></th></tr></thead>
<tbody>
    <tr>
	<form action="" method="post">
	    <td class="col-md-2"><input type="text" name="name" size="20" value="" class="form-control input-sm" required=""/></td>
	    <td class="col-md-4"><input type="text" name="link" size="30" value="" class="form-control input-sm" required=""/></td>
	    <input type="hidden" name="add" value="add" />
	    <td class="col-md-1"></td>
	    <td class="col-md-4"><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
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
	<td class="col-md-2">
	    <img type="image" src="media/ico/Security-Camera-icon.png" />
	    <?php echo $a["name"];?>
	</td>
	<td class="col-md-4">
	    <?php echo $a["link"];?>
	</td>
	<td class="col-md-1">
	    <form action="" method="post" style="display:inline!important;"> 	
		<input type="hidden" name="access_all" value="<?php echo $a["id"]; ?>" />
		<input type="checkbox" data-toggle="toggle" data-size="mini"  name="access_allon" value="on" <?php echo $a["access_all"] == 'on' ? 'checked="checked"' : ''; ?> onchange="this.form.submit()" /></td>
		<input type="hidden" name="access_allonoff" value="onoff" />
    	    </form>
	</td>
	<td class="col-md-4">
	    <form action="" method="post">
		<input type="hidden" name="name_del" value="<?php echo $a["name"]; ?>" />
		<input type="hidden" type="submit" name="del" value="del" />
		<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
	    </form>
	</td>
</tr>

<?php }


?>
</tbody>
</table>
</div>
		
<div class="panel-body">
<span id="helpBlock" class="help-block">examples:</span>
<span id="helpBlock" class="help-block">rtsp://192.168.1.1:554/play1.sdp</span>
<span id="helpBlock" class="help-block">rtsp://guest:guest@192.168.1.1:554/play1.sdp</span>
<span id="helpBlock" class="help-block">rtsp://192.168.1.1:554/11</span>
<span id="helpBlock" class="help-block">http://192.168.1.1:8080/video</span>
</div>
</div>
