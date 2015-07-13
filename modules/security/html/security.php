<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

<p>
<a href="index.php?id=security&type=fw" ><button class="btn <?php echo $art == 'fw' ? 'btn-info' : 'btn-default'; ?>">Firewall</button></a>
<a href="index.php?id=security&type=vpn" ><button class="btn <?php echo $art == 'vpn' ? 'btn-info' : 'btn-default'; ?>">VPN</button></a>
<a href="index.php?id=security&type=authmod" ><button class="btn <?php echo $art == 'authmod' ? 'btn-info' : 'btn-default'; ?>">WWW authmod</button></a>
<a href="index.php?id=security&type=radius" ><button class="btn <?php echo $art == 'radius' ? 'btn-info' : 'btn-default'; ?>">RADIUS</button></a>
</p>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/security/fw/html/fw.php'); break;
case 'fw': include('modules/security/fw/html/fw.php'); break;
case 'vpn': include('modules/security/vpn/html/vpn.php'); break;
case 'authmod': include('modules/security/authmod/html/authmod.php'); break;
case 'radius': include('modules/security/radius/html/settings.php'); break;

}
?>



