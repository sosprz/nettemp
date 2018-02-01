<?php 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");


$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM ownwidget");
$row = $rows->fetchAll();
$numRows = count($row);

if ( $numRows > '0' ) { 

	foreach ($row as $ow) {?> 	
	
	<?php
	
	$statuson = $ow['onoff'];
	$logon = $ow['iflogon'];
	
	if ($statuson == "on") {
	
	
	?>
	
	
		<div class="grid-item ">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $ow['name'];?></div>
			<div class="panel-body"><?php echo $ow[body]; ?></div>
		</div>
		</div>
	
<?php	
	
	}
	}




}?>