<?php 
$file_path='dbf/nettemp.db';
if ( '' == file_get_contents( $file_path ) )
{ ?>
<html>
<h1><font color="blue">nettemp.pl</font></h2>
<h2><font color="red">Database not found <?php echo $file_path; ?></font></h2>
<h3>Go to shell and reset/create nettemp database:<h3>
/var/www/nettemp/modules/reset/reset <br />
</html>
<?php }
else {
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!--<link rel="stylesheet" href="media/style.css" type="text/css"/>
<link href="media/menu.css" rel="stylesheet" type="text/css"> -->

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />
<link media="Screen" href="media/menu.css" type="text/css" rel="stylesheet" />
<link media="Screen" href="media/style.css" type="text/css" rel="stylesheet" /> 
<link media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)" href="media/mobile.css" type="text/css" rel="stylesheet" />



<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
    //   -->
</script>
</head>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->


<div id="top">
<div id="header">
<table border="0" width="1024">
<tr>
<td><span class="logo"><a href="http://nettemp.pl" target="_blank"><img src="media/png/nettemp.pl.png" alt="Monitoring Temperatury"></a></span></td>
<td valign="top"><?php include("modules/login/login.php"); ?></td>
</tr>
</table></div>
<div id="tabs22">
<ul> 
	<li><a href='status'><span>Status</span></a></li>
	<li><a href='view'><span>Charts</span></a></li>
	<?php if ($numRows1 == 1 && ( $perms == "adm" )) { ?>
		<li><a href='devices'><span>Devices</span></a></li>
		<li><a href='notification'><span>Notification</span></a></li>
		<li><a href='security'><span>Security</span></a></li>
		<li><a href='settings'><span>Settings</span></a></li>
		<li><a href='tools'><span>Tools</span></a></li> 
		<li><a href='info'><span>Info</span></a></li>
 <?php } 
else {?>
		<li><a href='info'><span>Info</span></a></li>
<?php
} ?>
</ul>
</div>
<div id="center">
<?php $id=$_GET['id']; ?>
<?php  
switch ($id)
{ 
default: case '$id': include('modules/status/html/status.php'); break;
case 'notification': include('modules/notification/html/notification.php'); break;
case 'sensors': include('modules/sensors/html/sensors.php'); break;
case 'view': include('modules/view/html/view.php'); break;
case 'humi_view': include('modules/view/html/humi_view.php'); break;
case 'temp_view': include('modules/view/html/temp_view.php'); break;
case 'snmp_view': include('modules/view/html/snmp_view.php'); break;
case 'diened': include('modules/login/diened.php'); break;
case 'diag': include('modules/tools/html/tools_file_check.php'); break;
case 'tools': include('modules/tools/html/tools.php'); break;
case 'info': include('modules/info/info.php'); break;
case 'gpio': include('modules/gpio/html/gpio.php'); break;
case 'sms': include('modules/notification/html/notification.php'); break;
case 'mail': include('modules/notification/html/notification.php'); break;
case 'alarms': include('modules/notification/html/notification.php'); break;
case 'settings': include('modules/settings/settings.php'); break;
case 'ups': include('modules/ups/html/ups.php'); break;
case 'kwh': include('modules/kwh/html/kwh.php'); break;
case 'snmp': include('modules/snmp/html/snmp.php'); break;
case 'vpn': include('modules/vpn/html/vpn.php'); break;
case 'fw': include('modules/fw/html/fw.php'); break;
case 'security': include('modules/security/html/security.php'); break;
case 'devices': include('modules/devices/html/devices.php'); break;
case 'backup': include('modules/backup/html/backup.php'); break;
case 'upload': include('modules/backup/html/upload.php'); break;
}
?>

</div>

	<div id="footer"><center><table><tr><td>Donate for developing</td><td> <?php include('modules/info/paypal.php'); ?></td><td>nettemp.pl v8.0</td></tr></table></center>
</div>
</div>

</body>
</html>
<?php } ?>



