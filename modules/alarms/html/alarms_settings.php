<?php
$tmp_id = $_POST["tmp_id"]; 				//sql
$tmp_min_new = $_POST["tmp_min_new"];  //sql
$tmp_max_new = $_POST["tmp_max_new"];  //sql
$add_alarm = $_POST["add_alarm"];  //sql
$del_alarm = $_POST["del_alarm"];  //sql
?>
<?php	// SQLite - dodawania alarmu
    if (!empty($add_alarm) && ($_POST['add_alarm1'] == "add_alarm2")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='on' WHERE id='$add_alarm'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
     ?> 
<?php	// SQLite - usuwanie alarmu
    if (!empty($del_alarm) && ($_POST['del_alarm1'] == "del_alarm2")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='off' WHERE id='$del_alarm'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
     ?> 
<?php	// SQLite - zmiana alarmow
    if (!empty($tmp_id) && ($_POST['ok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET tmp_min='$tmp_min_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE sensors SET tmp_max='$tmp_max_new' WHERE id='$tmp_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
     ?> 



<span class="belka">&nbsp Set the temperature range<span class="okno">
<table>
<?php  
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE alarm='on'");
$row = $rows->fetchAll();
$numRows = count($row);

if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
	$sth = $db1->prepare("select * from sensors WHERE alarm='on'");
	$sth->execute();
	$result = $sth->fetchAll();
		foreach ($result as $a) { ?>


	<tr>
	<form action="alarms" method="post"> 
	<td><img src="media/ico/TO-220-icon.png" /></td>
	<td><?php echo $a[name]; ?></td>
	<input type="hidden" name="tmp_id" value="<?php echo $a[id]; ?>" />
	<td><img src="media/ico/temp2-icon.png" />min:</td>
	<td><input type="text" name="tmp_min_new" size="4" value="<?php echo $a[tmp_min]; ?>" />&deg;C</td>
	<td><img src="media/ico/temp2-icon.png" />max:</td>
	<td><input type="text" name="tmp_max_new" size="4" value="<?php echo $a[tmp_max]; ?>" />&deg;C</td>
	<input type="hidden" name="ok" value="ok" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
	<form action="alarms" method="post"> 
	<input type="hidden" name="del_alarm1" value="del_alarm2" />
	<input type="hidden" name="del_alarm" value="<?php echo $a[id]; ?>" />
	<td><input type="image" src="media/ico/Close-2-icon.png"  /></td>
	<td></form></td></tr>  							
		 <?php	} 

?>
</table>
<hr>
<table>
<?php	
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE alarm='off'");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }

$sth = $db1->prepare("select * from sensors WHERE alarm='off'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>
    <tr>
   <form action="alarms" method="post">
   <td><img src="media/ico/TO-220-icon.png" /></td>
	<td><?php echo $a[name]; ?></td>
	<input type="hidden" name="add_alarm" value="<?php echo $a[id]; ?>" />
	<input type="hidden" name="add_alarm1" value="add_alarm2" />
    <td>&nbsp<input type="image" src="media/ico/Add-icon.png"  /></td>
	</tr>    
    </form>
<?php }  ?>
</table></span></span>




	
	
