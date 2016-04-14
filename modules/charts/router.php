<?php
$rows1 = $db->query("SELECT charts FROM charts WHERE id='1'");
$row1 = $rows1->fetchAll();
foreach($row1 as $hi){
$charts=$hi['charts'];
}
if($charts=='Highcharts') {
	include('modules/charts/highcharts/highcharts.php');
}
elseif($charts=='NVD3') {
	include('modules/charts/nvd3/nvd3.php');
}
?>