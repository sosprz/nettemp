<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<td><a href="index.php?id=ds_view&type=ds_view&highcharts=day" ><button>day</button></a></td>
<td><a href="index.php?id=ds_view&type=ds_view&highcharts=week" ><button>week</button></a></td>
<td><a href="index.php?id=ds_view&type=ds_view&highcharts=month" ><button>month</button></a></td>
<td><a href="index.php?id=ds_view&type=ds_view&highcharts=year" ><button>year</button></a></td>
</tr>
</table>



<?php $art=$_GET['highcharts']; ?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/highcharts.php'); break;
case 'day': include('modules/highcharts/highcharts.php'); break;
case 'week': include('modules/highcharts/highcharts_week.php'); break;
case 'month': include('modules/highcharts/highcharts_month.php'); break;
case 'year': include('modules/highcharts/highcharts_year.php'); 
}
?>




</span>
</span>
