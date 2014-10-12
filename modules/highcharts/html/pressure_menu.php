<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=pressure&highcharts=hour" ><button>hour</button></a></td>
<td><a href="index.php?id=view&type=pressure&highcharts=day" ><button>day</button></a></td>
<td><a href="index.php?id=view&type=pressure&highcharts=week" ><button>week</button></a></td>
<td><a href="index.php?id=view&type=pressure&highcharts=month" ><button>month</button></a></td>
<td><a href="index.php?id=view&type=pressure&highcharts=year" ><button>year</button></a></td>
</tr>
</table>



<?php 
$art = isset($_GET['highcharts']) ? $_GET['highcharts'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/multi.php'); break;
case 'hour': include('modules/highcharts/html/multi.php'); break;
case 'day': include('modules/highcharts/html/multi.php'); break;
case 'week': include('modules/highcharts/html/multi.php'); break;
case 'month': include('modules/highcharts/html/multi.php'); break;
case 'year': include('modules/highcharts/html/multi.php'); 
}
?>




</span>
</span>
