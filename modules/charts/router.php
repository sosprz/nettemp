<?php
if($nts_charts_default=='Highcharts') {
	include('modules/charts/highcharts/highcharts.php');
}
elseif($nts_charts_default=='NVD3') {
	include('modules/charts/nvd3/nvd3.php');
}
?>
