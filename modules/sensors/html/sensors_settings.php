<span class="belka">&nbsp Sensors<span class="okno"> 
<table>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);

if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db1->prepare("select * from sensors");
$sth->execute();
$result = $sth->fetchAll();

$sth1 = $db->prepare("select * from settings ");
$sth1->execute();
$result2 = $sth1->fetchAll();
foreach ($result2 as $a) {
$rrd=$a["rrd"];
}
if ( $rrd == 'on' ) { ?>
<tr>
<td></td>
<td><center>Name</center></td>
<td><center>Color</center></td>
<td></td>
<td><center>Sensor id</center></td>
<td>DB</td>
<td></td>
<td>Hour</td>
<td>Day</td>
<td>Week</td>
<td>Month</td>
<td>Year</td>
<td></td>
<td></td>
</tr>
<?php } else { ?>
<tr>
<td></td>
<td><center>Name</center></td>
<td></td>
<td><center>Sensor id</center></td>
<td>DB</td>
<td></td>
<td></td>
<td></td>
</tr>
<?php } ?>
<?php foreach ($result as $a) { 	
	
?>
<tr>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<td><img src="media/ico/TO-220-icon.png" /></td>
<td><input type="text" name="name_new" size="12" maxlength="10" value="<?php echo $a["name"]."\t"; ?>" /></td>
<?php if ( $rrd == 'on' ) { ?>
<td><input type='color' name='color' value ="<?php echo $a["color"]; ?>" size="7" />
<?php } ?>
<input type="hidden" name="name_id" value="<?php echo $a["id"]."\t"; ?>" />
<input type="hidden" name="id_name2" value="id_name3"/>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" /></td>
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
<?php   }
else { ?> 
<td>Error - no rrd base</td>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="usun_czujniki" value="<?php echo $a["rom"]; ?>" />
<input type="hidden" name="usun2" value="usun3" />
<td><input type="image" src="media/ico/Close-2-icon.png" /></td>
</form>

<?php }

if ( $rrd == 'on' ) { 

?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"> 	
    <input type="hidden" name="ss" value="<?php echo $a["id"]; ?>" />
    <td><img src="media/ico/Chart-Graph-Ascending-icon.png" /></td>
    <td><input type="checkbox" name="hour" value="on" <?php echo $a["hour"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <td><input type="checkbox" name="day" value="on" <?php echo $a["day"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <td><input type="checkbox" name="week" value="on" <?php echo $a["week"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <td><input type="checkbox" name="month" value="on" <?php echo $a["month"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <td><input type="checkbox" name="year" value="on" <?php echo $a["year"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="ss1" value="ss2" />
    </form>
<?php } ?>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="usun_czujniki" value="<?php echo $a["rom"]; ?>" />
<input type="hidden" name="usun2" value="usun3" />
<td><input type="image" src="media/ico/Close-2-icon.png" /></td>
</form>

</tr>
		

<?php 

}  

?>
</table>
</span></span>
