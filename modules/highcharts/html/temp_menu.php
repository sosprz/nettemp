<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=temp_view&highcharts=day" ><button>day</button></a></td>
<td><a href="index.php?id=view&type=temp_view&highcharts=week" ><button>week</button></a></td>
<td><a href="index.php?id=view&type=temp_view&highcharts=month" ><button>month</button></a></td>
<td><a href="index.php?id=view&type=temp_view&highcharts=year" ><button>year</button></a></td>
</tr>
</table>



<?php 
$art = isset($_GET['highcharts']) ? $_GET['highcharts'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/temp_highcharts.php'); break;
case 'day': include('modules/highcharts/html/temp_highcharts.php'); break;
case 'week': include('modules/highcharts/html/temp_highcharts_week.php'); break;
case 'month': include('modules/highcharts/html/temp_highcharts_month.php'); break;
case 'year': include('modules/highcharts/html/temp_highcharts_year.php'); 
}
?>




</span>
</span>
