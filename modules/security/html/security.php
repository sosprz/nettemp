<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<?php $art = (!isset($art) || $art == '') ? 'fw' : $art; ?>

<p>
<a href="index.php?id=security&type=fw" ><button class="btn btn-xs btn-default <?php echo $art == 'fw' ? 'active' : ''; ?>">Firewall</button></a>
<a href="index.php?id=security&type=vpn" ><button class="btn btn-xs btn-default <?php echo $art == 'vpn' ? 'active' : ''; ?>">VPN</button></a>
<a href="index.php?id=security&type=authmod" ><button class="btn btn-xs btn-default <?php echo $art == 'authmod' ? 'active' : ''; ?>">WWW authmod</button></a>
<a href="index.php?id=security&type=radius" ><button class="btn btn-xs btn-default <?php echo $art == 'radius' ? 'active' : ''; ?>">RADIUS</button></a>
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



