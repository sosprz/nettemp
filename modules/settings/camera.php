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


<span class="belka">&nbsp Add camera<span class="okno">
<table>
	<form action="" method="post">
	<tr>
	    <td></td><td>Name</td><td>Link</td>
	</tr>
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
    </table>
<?php }
?>

		
	
<table>
	<tr><td><font color="grey">ex: rtsp://172.18.10.103:554/play1.sdp</font></td></tr>
	<tr><td><font color="grey">ex: rtsp://guest:guest@172.18.10.103:554/play1.sdp</font></td></tr>
</table>

	
</table>
</span></span>
