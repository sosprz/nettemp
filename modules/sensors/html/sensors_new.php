<div class="panel panel-default">
<div class="panel-heading">New devices</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small"><tr>	
<thead>
	<tr>
		<th>Name</th>
		<th>ROM</th>
		<th>Type</th>
		<th>Device</th>
		<th>IP</th>
		<th>GPIO</th>
		<th>I2C</th>
		<th>USB</th>
		<th></th>
	</tr>
</thead>
<?php	
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT * FROM newdev t1 WHERE NOT EXISTS (SELECT * FROM sensors t2 WHERE t1.rom = t2.rom)");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
	?>
<tr>
	<td class="col-md-1">
		<?php echo $a['name']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['rom']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['type']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['device']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['ip']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['gpio']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['i2c']; ?>
	</td>
	<td class="col-md-1">
		<?php echo $a['usb']; ?>
	</td>
	
	<td class="col-md-2">
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="new_rom" value="<?php echo $a['rom']; ?>" > 
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
		</form>
	</td>
</tr>    
<?php 
	} 					
?>
</table>
</div>
</div>




