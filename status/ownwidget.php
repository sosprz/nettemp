<?php 
session_start();

if (isset($_GET['owb'])) { 
    $owb = $_GET['owb'];
} 

if (isset($_GET['own'])) { 
    $own = $_GET['own'];
} 

if (isset($_GET['owh'])) { 
    $owh = $_GET['owh'];
} 


$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");

//hide ownwidget in status
	$hideow = isset($_POST['hideow']) ? $_POST['hideow'] : '';
	$hideowstate = isset($_POST['hideowstate']) ? $_POST['hideowstate'] : '';
	$hideowbod = isset($_POST['hideowbod']) ? $_POST['hideowbod'] : '';

	
	if (!empty($hideow) && $hideow == 'hideow'){
		if ($hideowstate == 'on') {$hideowstate = 'off';
		}elseif ($hideowstate == 'off') {$hideowstate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE ownwidget SET hide='$hideowstate' WHERE body='$hideowbod'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }	


if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {

$rows = $db->query("SELECT * FROM ownwidget WHERE body='$owb' AND onoff='on'");

}else
{
	
$rows = $db->query("SELECT * FROM ownwidget WHERE iflogon='off' AND body='$owb' AND onoff='on'");	
}
$row = $rows->fetchAll();
$numRows = count($row);

if ( $numRows > '0' ) {  ?>

		<div class="grid-item ow<?php echo $owb ?>">
		<div class="panel panel-default">
		<div class="panel-heading">
		
		<div class="pull-left"><?php echo str_replace('_', ' ', $own);?></div>
		<div class="pull-right">
		<div class="text-right">
			 <form action="" method="post" style="display:inline!important;">
					<input type="hidden" name="hideowbod" value="<?php echo $owb; ?>" />
					<input type="hidden" name="hideowstate" value="<?php echo $owh; ?>" />
					<input type="hidden" name="hideow" value="hideow"/>
					<?php
					if($owh == 'off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($owh == 'on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
				</form>	
		</div>
  </div>
  <div class="clearfix"></div>
		
		
		</div>

	<?php
	
	
	
	foreach ($row as $ow) {?> 	
	
		<?php if ($owh == 'off') { ?>
			<div class="panel-body"><?php include("$root/tmp/ownwidget".$owb.".php");?> </div>
			
			<?php
		}
		?>
		</div>
		</div>

			<?php
				}
		}
		unset($owb);
		unset($own);
?>