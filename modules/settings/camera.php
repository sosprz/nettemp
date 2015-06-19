<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Camera</h3>
</div>
<div class="panel-body">
<?php
$link = isset($_POST['link']) ? $_POST['link'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$name_del = isset($_POST['name_del']) ? $_POST['name_del'] : '';
?>

<?php 
	if (!empty($name)  && !empty($link) && ($_POST['add'] == "add")){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT OR IGNORE INTO camera (name, link) VALUES ('$name', '$link')") or die ($db->lastErrorMsg());
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


<table class="table table-striped">
<thead><tr><th></th><th>Name</th><th>link</th><th>Add/Rem</th></tr></thead>
<tbody>
	<form action="" method="post">
	<tr>
	<td><img type="image" src="media/ico/Security-Camera-icon.png" /></td>
	<td><input type="text" name="name" size="20" value="" /></td>
	<td><input type="text" name="link" size="30" value="" /></td>
	<input type="hidden" name="add" value="add" />
	<td><input type="image" src="media/ico/Add-icon.png" /></td>
	</form>
	</tr>

<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from camera");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
    
	<tr>
	<td></td>
	<td><?php echo $a["name"];?></td>
	<td><?php echo $a["link"];?></td>
	
	<form action="" method="post"> 	
	    <input type="hidden" name="name_del" value="<?php echo $a["name"]; ?>" />
	    <input type="hidden" type="submit" name="del" value="del" />
        <td><input type="image" src="media/ico/Close-2-icon.png"  /></td>
	</form>
	</tr>

<?php }
?>
</tbody>
</table>
		
	
<span id="helpBlock" class="help-block">rtsp://172.18.10.103:554/play1.sdp</span>
<span id="helpBlock" class="help-block">rtsp://guest:guest@172.18.10.103:554/play1.sdp</span>
</div>
</div>
