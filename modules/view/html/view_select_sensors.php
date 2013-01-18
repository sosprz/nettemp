<?php

$hour = $_POST["hour"];
$day = $_POST["day"];
$week = $_POST["week"];
$month = $_POST["month"];
$year = $_POST["year"];
$ss = $_POST["ss"];

	// SQLite - update 
	if ( $_POST['ss1'] == "ss2"){

	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET hour='$hour' WHERE id='$ss'") ;
  $db->exec("UPDATE sensors SET day='$day' WHERE id='$ss'") ;
	$db->exec("UPDATE sensors SET week='$week' WHERE id='$ss'") ;
  $db->exec("UPDATE sensors SET month='$month' WHERE id='$ss'") ;
 $db->exec("UPDATE sensors SET year='$year' WHERE id='$ss'") ;
  exec("bash modules/view/view_gen");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
 ?>



<span class="belka">&nbsp Select sensors:<span class="okno">
<table>
<tr><td></td><td>Name</td><td>hour</td>   <td>day</td> <td>week</td> <td>month</td> <td>year</td>     
</tr>
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from sensors ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>

	<tr>
	<td><img src="media/ico/graph-icon.png" ></td>
	<td><?php echo $a["name"];?></td>

	
	<form action="view" method="post"> 	
	<input type="hidden" name="ss" value="<?php echo $a["id"]; ?>" />
	<td><input type="checkbox" name="hour" value="on" <?php echo $a["hour"] == 'on' ? 'checked="checked"' : ''; ?> /></td>
	<td><input type="checkbox" name="day" value="on" <?php echo $a["day"] == 'on' ? 'checked="checked"' : ''; ?> /></td>
	<td><input type="checkbox" name="week" value="on" <?php echo $a["week"] == 'on' ? 'checked="checked"' : ''; ?> /></td>
	<td><input type="checkbox" name="month" value="on" <?php echo $a["month"] == 'on' ? 'checked="checked"' : ''; ?> /></td>
		<td><input type="checkbox" name="year" value="on" <?php echo $a["year"] == 'on' ? 'checked="checked"' : ''; ?> /></td>
	<input type="hidden" name="ss1" value="ss2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" /></td>
	</form>
	

<?php }


		
	
		?>
	
</tr></table>
</span></span>