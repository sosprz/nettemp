
<div class="panel panel-default">
<div class="panel-heading">Notifications</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small">
<thead>
	<tr>
		<th>Type</th>
		<th>When</th>
		<th>Active systems</th>
		<th>Custom message</th>
		<th>Priority</th>
		<th>Ignore interval</th>
		<th>Recovery</th>
		<th>Active</th>
	</tr>
</thead>

	

</table>
</div>
<table class="table table-hover table-condensed small">
<thead>
</thead>
<tbody>
<tr>
<td>
<a href="index.php?id=<?php echo $id ?>&type=devices&device_group=<?php echo $device_group?>&device_type=<?php echo $device_type?>&device_menu=settings&device id=<?php  if($device_group == '' && $device_type == '' && $device_id == '') {echo '';} else {echo $a["id"];} ?>" ><button class="btn btn-xs btn-info">Back</button></a>
</td>
</tr>
</tbody>

</table>
</div>