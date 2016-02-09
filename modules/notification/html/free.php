<?php
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$add_alarm = isset($_POST['add_alarm']) ? $_POST['add_alarm'] : '';
$add_alarm1 = isset($_POST['add_alarm1']) ? $_POST['add_alarm1'] : '';

?>
<?php	// SQLite - dodawania alarmu
    if (!empty($add_alarm) && ($_POST['add_alarm1'] == "add_alarm2")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET alarm='on' WHERE id='$add_alarm'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
 ?> 

<div class="panel panel-default">
<div class="panel-heading">Free sensors</div>

<table class="table table-hover">
<tbody>
 <tr>
    <th>Name</th>
    <th></th>
 </tr>
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
    <td class="col-sm-2">
	<img src="media/ico/TO-220-icon.png" /><?php echo $a['name']; ?>
    </td>
    <td class="col-sm-10">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="add_alarm" value="<?php echo $a['id']; ?>" />
	<input type="hidden" name="add_alarm1" value="add_alarm2" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    </td>
</tr>
<?php }  ?>
</tbody>
</table>

</div>




