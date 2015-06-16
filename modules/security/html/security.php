<p>
<a href="index.php?id=security&type=fw" ><button class="btn btn-default">Firewall</button></a>
<a href="index.php?id=security&type=vpn" ><button class="btn btn-default">VPN</button></a>
<a href="index.php?id=security&type=authmod" ><button class="btn btn-default">WWW authmod</button></a>
</p>
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



