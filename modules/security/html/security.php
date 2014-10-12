<span class="belka">&nbsp Select action<span class="okno">

<table><tr>
<td><a href="index.php?id=security&type=fw" ><button>Firewall</button></a></td>
<td><a href="index.php?id=security&type=vpn" ><button>VPN</button></a></td>
<td><a href="index.php?id=security&type=authmod" ><button>WWW authmod</button></a></td>
</tr>
</table>
</span>
</span>
<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/security/fw/html/fw.php'); break;
case 'fw': include('modules/security/fw/html/fw.php'); break;
case 'vpn': include('modules/security/vpn/html/vpn.php'); break;
case 'authmod': include('modules/security/authmod/html/authmod.php'); break;


}
?>



