<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$dbmaps = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$dir="modules/gpio/";
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';

	$position = isset($_POST['position']) ? $_POST['position'] : '';
    $position_id = isset($_POST['position_id']) ? $_POST['position_id'] : '';
    if (!empty($position_id) && ($_POST['positionok'] == "ok")){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE gpio SET position='$position' WHERE id='$position_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    } 

?>

<div class="panel panel-default">
<div class="panel-heading">Status</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">


<?php 
$db = new PDO('sqlite:dbf/nettemp.db'); 
$dbmaps = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$rows = $db->query("SELECT * FROM gpio ORDER BY position ASC"); 
$row = $rows->fetchAll();

?>

<thead>
<tr>
<th>Pos</th>
<th>Name</th>
<th>Settings</th>
<th>Function</th>
<th>Status</th>
</tr>
</thead>

<?php foreach ($row as $b) {
	?>

<tr>
	<td class="col-md-1">
    		<form action="" method="post" style="display:inline!important;">
        	<input type="hidden" name="position_id" value="<?php echo $b["id"]; ?>" />
        	<input type="text" name="position" size="1" maxlength="3" value="<?php echo $b['position']; ?>" />
        	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
        	<input type="hidden" name="positionok" value="ok" />
    		</form>
	</td>
	<td class="col-md-1">
                <span class="label label-default"><?php echo $b["name"]; ?></span>
    </td>

	<td class="col-md-1">
		<a href="index.php?id=device&type=gpio&gpios=<?php echo $b['gpio']?>&ip=<?php echo $b['ip']?>" class="btn btn-xs btn-success ">GPIO <?php echo $b['gpio']; if(!empty($b['ip'])){echo " ".$b['ip'];}?></a>
	</td>

	<td class="col-md-1">
                <span class="label label-default"><?php echo $b["mode"]; ?></span>
        </td>

	<td class="col-md-8"> 
		<?php
		    if (strpos($b['status'],'ON') !== false||strpos($b['status'],'on') !== false) {
		?>
			<span class="label label-success">
			<?php
			} else {
			?> <span class="label label-danger">

 		<?php }?>
			<?php
			echo $b['status']; ?> </span>
	</td>
</tr>

<?php } ?>

</table> </div> </div>

