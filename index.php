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


<div id="top">
<div id="header">
<table border="0" width="1024">
<tr>
<td><span class="logo"><img src="media/png/nettemp.pl.png" alt="" ></span></td>
<td valign="top"><?php include("include/login.php"); ?></td>
</tr>
</table></div>
<div id="tabs22">
<ul> 
	<li><a href='status'><span>Status</span></a></li>
	<li><a href='view'><span>View</span></a></li>
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
default: case '$id': include('include/status.php'); break;
case 'alarms': include('include/alarms.php'); break;
case 'notification': include('include/notification.php'); break;
case 'mail': include('include/mail.php'); break;
case 'sensors': include('include/sensors.php'); break;
case 'view': include('include/view.php'); break;
case 'diened': include('include/diened.php'); break;
case 'diag': include('include/diag.php'); break;
case 'db_reset': include('include/admin_db_reset.php'); break;
case 'password': include('include/login_change_pass.php'); break;
case 'log': include('include/log.php'); break;
case 'info': include('include/info.php'); break;
}
?>

</div>

	<div id="footer">www.nettemp.pl</div>
	</div>
</body>
</html>



