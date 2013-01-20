<span class="belka">&nbsp Sensors:<span class="okno"> 
<table>
<?php
//$db = new SQLite3('dbf/nettemp.db');
//$rows = $db->query("SELECT COUNT(*) as count FROM sensors");
//$row = $rows->fetchArray();
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);

if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
//$r = $db->query("select * from sensors");
//while ($a = $r->fetchArray()) {
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from sensors");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 	
	
?>
<tr>
<form action="sensors" method="post">	
<td><img src="media/ico/TO-220-icon.png" /></td>
<td><input type="text" name="name_new" size="12" maxlength="10" value="<?php echo $a["name"]."\t" ; ?>" /></td>
	  <input type="hidden" name="name_id" value="<?php echo $a["id"]."\t"; ?>" />
	   <input type="hidden" name="id_name2" value="id_name3"/>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
</form>
<td><?php 	echo  $a["rom"] ;?></td>
<?php
	$id_rom3 = str_replace(" ", "_", $a["rom"]);
	$id_rom2 = "$id_rom3.rrd";
	$file3 =  "db/$id_rom2";
	if (file_exists($file3))
   { ?>
<td><img src="media/ico/Ok-icon.png" /></td>
</form>
<form  action="sensors" method="post">
<input type="hidden" name="add_graf" value="<?php echo $a["rom"];  ?>" />
<input type="hidden" name="add_graf1" value="add_graf2" />
<td><input type="image" src="media/ico/graph-icon.png"  /></td>
</form>
<form action="sensors" method="post"  >
<input type="hidden" name="usun_czujniki" value="<?php echo $a["rom"]; ?>" />
<input type="hidden" name="usun2" value="usun3" />
<td><input type="image" src="media/ico/Close-2-icon.png" /></td>
</form>
<?php   }
else { ?> 
<td>Error - no rrd base</td>
<form action="sensors" method="post"  >
<input type="hidden" name="usun_czujniki" value="<?php echo $a["rom"]; ?>" />
<input type="hidden" name="usun2" value="usun3" />
<td><input type="image" src="media/ico/Close-2-icon.png" /></td>
</form>
<?php }

?>
</tr>
		

<?php 

}  

?>
</table>
</span></span>
