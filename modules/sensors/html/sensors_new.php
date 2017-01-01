<?php
$delallnewrom = isset($_POST['delallnewrom']) ? $_POST['delallnewrom'] : '';
if ($delallnewrom=='yes'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM newdev");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$delnewrom = isset($_POST['delnewrom']) ? $_POST['delnewrom'] : '';
$delnew = isset($_POST['delnew']) ? $_POST['delnew'] : '';
if ($delnew=='yes'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM newdev WHERE id='$delnewrom'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<div class="panel panel-default">
<div class="panel-heading">New devices</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead>
	<tr>
		<th>ID</th>
		<th>List*</th>
		<th>Name</th>
		<th>ROM</th>
		<th>Type</th>
		<th>Device</th>
		<th>IP</th>
		<th>GPIO</th>
		<th>I2C</th>
		<th>USB</th>
		<th></th>
		<th></th>
	</tr>
</thead>
<tbody>
<?php	
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT * FROM newdev WHERE list NOT IN (SELECT rom FROM sensors WHERE 1)");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
?>
<tr>
	<td class="col-md-0">
		<?php echo $a['id']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['list']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['name']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['rom']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['type']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['device']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['ip']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['gpio']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['i2c']; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a['usb']; ?>
	</td>
	
	<td class="col-md-0">
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="new_rom" value="<?php echo $a['rom']; ?>" >
			<input type="hidden" name="type" value="<?php echo $a['type']; ?>" >
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
		</form>
	
	</td>
	<td class="col-md-0">
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="delnewrom" value="<?php echo $a['id']; ?>" >
			<input type="hidden" name="delnew" value="yes" >
			<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
		</form>
	</td>
	
</tr>
<?php
	}
	if(count($result)>0) {
?>
<tr>
	<td  colspan = "12">
		<center>
		<form action="" method="post">
			<input type="hidden" name="delallnewrom" value="yes" >
			<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> Remove all new device</button>
		</form>
		</center>
	</td>
</tr>
<?php
	}
?>
</tbody>
</table>
</div>
</div>
