<span class="belka">&nbsp Select view<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=temp_view" ><button>Temp view</button></a></td>
<td><a href="index.php?id=view&type=humi_view" ><button>Humi view</button></a></td>
<td><a href="index.php?id=view&type=snmp_view" ><button>Snmp view</button></a></td>
</tr>
</table>
</span>
</span>



<?php $art=$_GET['type']; ?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/view/html/temp_view.php'); break;
case 'temp_view': include('modules/view/html/temp_view.php'); break;
case 'humi_view': include('modules/view/html/humi_view.php'); break;
case 'snmp_view': include('modules/view/html/snmp_view.php'); break;
}
?>




