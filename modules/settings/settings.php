<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

<p>
<a href="index.php?id=settings&type=mail" ><button class="btn btn-default">Mail</button></a>
<a href="index.php?id=settings&type=sms" ><button class="btn btn-default">SMS</button></a>
<a href="index.php?id=settings&type=gpio" ><button class="btn btn-default">GPIO</button></a>
<a href="index.php?id=settings&type=1wire" ><button class="btn btn-default">1wire</button></a>
<a href="index.php?id=settings&type=time" ><button class="btn btn-default">Time</button></a>
<a href="index.php?id=settings&type=snmpd" ><button class="btn btn-default">SNMPD</button></a>
<a href="index.php?id=settings&type=lcd" ><button class="btn btn-default">LCD</button></a>
<a href="index.php?id=settings&type=camera" ><button class="btn btn-default">IP Cam</button></a>
</p>
<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$mail': include('modules/settings/mail.php'); break;
case 'sms': include('modules/settings/sms.php'); break;
case 'gpio': include('modules/settings/gpio.php'); break;
case 'time': include('modules/settings/time.php'); break;
case 'snmpd': include('modules/settings/snmpd.php'); break;
case 'camera': include('modules/settings/camera.php'); break;
case 'lcd': include('modules/settings/lcd.php'); break;
case '1wire': include('modules/settings/1wire.php'); break;
}
?>
