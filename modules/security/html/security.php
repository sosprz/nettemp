<span class="belka">&nbsp Select action<span class="okno">

<table><tr>
<td><a href="index.php?id=security&type=fw" ><button>Firewall</button></a></td>
<td><a href="index.php?id=security&type=vpn" ><button>VPN</button></a></td>
<td><a href="index.php?id=security&type=authmod" ><button>WWW authmod</button></a></td>
</tr>
</table>
</span>
</span>
<?php $art=$_GET['type']; ?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/fw/html/fw.php'); break;
case 'fw': include('modules/fw/html/fw.php'); break;
case 'vpn': include('modules/vpn/html/vpn.php'); break;
case 'authmod': include('modules/authmod/html/authmod.php'); break;


}
?>



