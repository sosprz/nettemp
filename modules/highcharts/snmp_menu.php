<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<td><a href="index.php?id=view2&highcharts=day" ><button>day</button></a></td>
<td><a href="index.php?id=view2&highcharts=week" ><button>week</button></a></td>
<td><a href="index.php?id=view2&highcharts=month" ><button>month</button></a></td>
<td><a href="index.php?id=view2&highcharts=year" ><button>year</button></a></td>
</tr>
</table>



<?php $art=$_GET['highcharts']; ?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/snmp_highcharts.php'); break;
case 'day': include('modules/highcharts/snmp_highcharts.php'); break;
case 'week': include('modules/highcharts/snmp_highcharts_week.php'); break;
case 'month': include('modules/highcharts/snmp_highcharts_month.php'); break;
case 'year': include('modules/highcharts/snmp_highcharts_year.php'); 
}
?>




</span>
</span>
