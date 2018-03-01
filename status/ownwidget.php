<?php 
session_start();

if (isset($_GET['owb'])) { 
    $owb = $_GET['owb'];
} 

if (isset($_GET['own'])) { 
    $own = $_GET['own'];
} 


$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");

if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {

$rows = $db->query("SELECT * FROM ownwidget WHERE body='$owb'");

}else
{
	
$rows = $db->query("SELECT * FROM ownwidget WHERE iflogon='off' AND body='$owb'");	
}
$row = $rows->fetchAll();
$numRows = count($row);

if ( $numRows > '0' ) {  ?>


		<div class="grid-item ow<?php echo $owb ?>">
		<div class="panel panel-default">
		<div class="panel-heading"><?php echo str_replace('_', ' ', $own);?></div>

	<?php
	
	foreach ($row as $ow) {?> 	
	
		
			<div class="panel-body"><?php include("$root/tmp/ownwidget".$owb.".php");?> </div>
		</div>
		</div>

			<?php
				}
		}
		unset($owb);
		unset($own);
?>