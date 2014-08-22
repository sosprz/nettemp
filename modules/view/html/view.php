<span class="belka">&nbsp Select view<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=ds_view" ><button>DS view</button></a></td>
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
default: case '$art': include('modules/view/html/ds_view.php'); break;
case 'ds_view': include('modules/view/html/ds_view.php'); break;
case 'humi_view': include('modules/view/html/humi_view.php'); break;
case 'snmp_view': include('modules/view/html/snmp_view.php'); break;
}
?>




