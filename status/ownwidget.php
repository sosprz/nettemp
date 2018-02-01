<?php 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");


$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM ownwidget");
$row = $rows->fetchAll();
$numRows = count($row);

if ( $numRows > '0' ) { ?>
<div class="grid-item test">
<?php
	foreach ($row as $ow) {?> 	
	
	<?php
	
	$statuson = $ow['onoff'];
	$logon = $ow['iflogon'];
	$bodys = $ow['body'];
	
	if (($statuson == "on") && ($logon == "off"))  { ?>
		<div class="grid-item ow">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $ow['name'];?></div>
			<div class="panel-body"><?php include("$root/tmp/ownwidget".$bodys.".php");?> </div>
		</div>
		</div>
<?php	
	
		} else { if (($statuson == "on") && ($logon == "on"))  {
			
			if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) { ?>

			<div class="grid-item ow">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo $ow['name'];?></div>
				<div class="panel-body"><?php include("$root/tmp/ownwidget".$bodys.".php");?> </div>
			</div>
			</div>

			<?php } 
			
				}
		}
	}?>
	</div> <?php
}?>