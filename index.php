<?php 
ob_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$dbfile='dbf/nettemp.db';
if ( '' == file_get_contents( $dbfile ) )
{ ?>
<html>
<h1><font color="blue">nettemp.pl</font></h2>
<h2><font color="red">Database not found <?php echo $dbfile; ?></font></h2>
<h3>Go to shell and reset/create nettemp database:<h3>
/var/www/nettemp/modules/tools/db_reset <br />
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
<!-- function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }   -->
</script>
</head>
<!-- <body onload="JavaScript:timedRefresh(6000);"> -->


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
    <li><a href='status' <?php echo $id == 'status' ? ' class="active"' : ''; ?> ><span <?php echo $id == 'status' ? ' class="active"' : ''; ?> >Status</span></a></li>
	<li><a href='view' <?php echo $id == 'view' ? ' class="active"' : ''; ?> ><span <?php echo $id == 'view' ? ' class="active"' : ''; ?> >Charts</span></a></li>
	<?php if ($numRows1 == 1 && ( $perms == "adm" )) { ?>
		<li><a href='devices'<?php echo $id == 'devices' ? ' class="active"' : ''; ?>><span <?php echo $id == 'devices' ? ' class="active"' : ''; ?>>Devices</span></a></li>
		<li><a href='notification'<?php echo $id == 'notification' ? ' class="active"' : ''; ?>><span <?php echo $id == 'notification' ? ' class="active"' : ''; ?>>Notification</span></a></li>
		<li><a href='security'<?php echo $id == 'security' ? ' class="active"' : ''; ?>><span <?php echo $id == 'security' ? ' class="active"' : ''; ?>>Security</span></a></li>
		<li><a href='settings'<?php echo $id == 'settings' ? ' class="active"' : ''; ?>><span <?php echo $id == 'settings' ? ' class="active"' : ''; ?>>Settings</span></a></li>
		<li><a href='tools'<?php echo $id == 'tools' ? ' class="active"' : ''; ?>><span <?php echo $id == 'tools' ? ' class="active"' : ''; ?>>Tools</span></a></li> 
		<li><a href='info'<?php echo $id == 'info' ? ' class="active"' : ''; ?>><span <?php echo $id == 'info' ? ' class="active"' : ''; ?>>Info</span></a></li>
 <?php } 
else {?>
		<li><a href='info'<?php echo $id == 'info' ? ' class="active"' : ''; ?> ><span <?php echo $id == 'info' ? ' class="active"' : ''; ?>>Info</span></a></li>
<?php
} ?>
</ul>
</div>
<div id="center">
<?php  
switch ($id)
{ 
default: case '$id': include('modules/status/html/status.php'); break;
case 'view': include('modules/view/html/view.php'); break;
case 'devices': include('modules/devices/html/devices.php'); break;
case 'notification': include('modules/notification/html/notification.php'); break;
case 'security': include('modules/security/html/security.php'); break;
case 'settings': include('modules/settings/settings.php'); break;
case 'tools': include('modules/tools/html/tools.php'); break;
case 'info': include('modules/info/info.php'); break;
case 'denied': include('modules/login/denied.php'); break;
case 'diag': include('modules/tools/html/tools_file_check.php'); break;
case 'upload': include('modules/tools/backup/html/upload.php'); break;
case 'receiver': include('modules/sensors/html/receiver.php'); break;

}
?>

</div>

	<div id="footer"><center><table><tr><td>Donate for developing</td><td> <?php include('modules/info/paypal.php'); ?></td><td>v <?php passthru("awk '/Changelog/{y=1;next}y' readme.md |head -2 |grep -v '^$' && /usr/bin/git branch |grep [*]|awk '{print $2}';"); ?></td><td>| System time <?php $today=date("H:i:s"); echo $today;?></td></tr></table></center>
</div>
</div>
<center>
</center>

</body>
</html>
<?php } 
ob_end_flush();
?>



