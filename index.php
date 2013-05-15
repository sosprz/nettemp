<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="media/style.css" type="text/css"/>
<link href="media/menu.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
    //   -->
</script>
</head>
<body onload="JavaScript:timedRefresh(60000);">

<?php ob_start(); ?>
<div id="top">
<div id="header">
<table border="0" width="1024">
<tr>
<td><span class="logo"><img src="media/png/nettemp.pl.png" alt="" ></span></td>
<td valign="top"><?php include("modules/login/login.php"); ?></td>
</tr>
</table></div>
<div id="tabs22">
<ul> 
	<li><a href='status'><span>Status</span></a></li>
	<li><a href='view'><span>View</span></a></li>
	<li><a href='relays'><span>Relays</spam></a></li>
      <?php
	session_start();
	  include('include/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { ?>
		  <li><a href='sensors'><span>Sensors</span></a></li>
   	   <li><a href='alarms'><span>Alarms</span></a></li>
   		<li><a href='notification'><span>Notification</span></a></li>
   		<li><a href='mail'><span>Mail settings</span></a></li>
   		<li><a href='log'><span>Log</span></a></li>
   		<li><a href='password'><span>Password</span></a></li>
   		<?php } ?>
 <?php if ($numRows1 == 1 && ( $perms == "adm" )) { ?>
 <li><a href='diag'><span>Diagnostic</span></a></li> 
 <?php } ?>
 			
			<li><a href='info'><span>Info</span></a></li>
</ul>
</div>
<div id="center">
<?php $id=$_GET['id']; ?>
<?php  
switch ($id)
{ 
default: case '$id': include('modules/status/html/status.php'); break;
case 'alarms': include('modules/alarms/html/alarms.php'); break;
case 'notification': include('modules/notification/html/notification.php'); break;
case 'mail': include('modules/mail/html/mail.php'); break;
case 'sensors': include('modules/sensors/html/sensors.php'); break;
case 'view': include('modules/view/html/view.php'); break;
case 'diened': include('modules/login/diened.php'); break;
case 'diag': include('modules/diag/html/diag.php'); break;
case 'password': include('modules/login/login_change_pass.php'); break;
case 'log': include('modules/log/html/log.php'); break;
case 'info': include('modules/info/info.php'); break;
case 'relays': include('modules/relays/html/relays.php'); break;
}
?>

</div>

	<div id="footer">www.nettemp.pl
	</div>
</div>

</body>
</html>



