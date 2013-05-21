<span class="belka">&nbsp Alarms settings<span class="okno">
<table>
<?php  
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE alarm='on'");
$row = $rows->fetchAll();
$numRows = count($row);

if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }

//$r = $db->query("select * from sensors WHERE alarm='on'");
//while ($a = $r->fetchArray()) { 
$sth = $db1->prepare("select * from sensors WHERE alarm='on'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>


<tr>
	<form action="alarms" method="post"> 
	
	<td><img src="media/ico/TO-220-icon.png" /><?php echo $a[name]; ?></td>
	<input type="hidden" name="tmp_id" value="<?php echo $a[id]; ?>" />
	<td><img src="media/ico/temp2-icon.png" />min:</td>
	<td><input type="text" name="tmp_min_new" size="2" value="<?php echo $a[tmp_min]; ?>" /></td>
	<td><img src="media/ico/temp2-icon.png" />max:</td>
	<td><input type="text" name="tmp_max_new" size="2" value="<?php echo $a[tmp_max]; ?>" /></td>
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
</span></span>

<span class="belka">&nbsp Not configured alarms:<span class="okno">
	<table border="0"><tr>	
	<?php	
//$db = new SQLite3('dbf/nettemp.db');
//$rows = $db->query("SELECT COUNT(*) as count FROM sensors WHERE alarm='off'");
//$row = $rows->fetchArray();
//$numRows = $row['count'];
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE alarm='off'");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }

//$r = $db->query("select * from sensors WHERE alarm='off'");
//while ($a = $r->fetchArray()) {
$sth = $db1->prepare("select * from sensors WHERE alarm='off'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>
   <form action="alarms" method="post">
   <td><img src="media/ico/TO-220-icon.png" />&nbsp</td>
	<td><?php echo $a[name]; ?></td>
	<input type="hidden" name="add_alarm" value="<?php echo $a[id]; ?>" />
	<input type="hidden" name="add_alarm1" value="add_alarm2" />
    <td>&nbsp<input type="image" src="media/ico/Add-icon.png"  /></td>
	</tr>    
    </form>
<?php }  ?>
</table></span></span>




	
	
