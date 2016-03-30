<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

<p>
<a href="index.php?id=settings&type=users" ><button class="btn btn-xs btn-default <?php echo $art == 'users' ? 'active' : ''; ?>">Users</button></a>
<a href="index.php?id=settings&type=mail" ><button class="btn btn-xs btn-default <?php echo $art == 'mail' ? 'active' : ''; ?>">Mail</button></a>
<a href="index.php?id=settings&type=accesstime" ><button class="btn btn-xs btn-default <?php echo $art == 'accesstime' ? 'active' : ''; ?>">Access time</button></a>
<a href="index.php?id=settings&type=modem" ><button class="btn btn-xs btn-default <?php echo $art == 'modem' ? 'active' : ''; ?>">Modem</button></a>
<a href="index.php?id=settings&type=gpio" ><button class="btn btn-xs btn-default <?php echo $art == 'gpio' ? 'active' : ''; ?>">GPIO</button></a>
<!-- <a href="index.php?id=settings&type=1wire" ><button class="btn btn-xs btn-default <?php echo $art == '1wire' ? 'active' : ''; ?>">1wire</button></a> 
<a href="index.php?id=settings&type=i2c" ><button class="btn btn-xs btn-default <?php echo $art == 'i2c' ? 'active' : ''; ?>">i2c</button></a>
<a href="index.php?id=settings&type=lcd" ><button class="btn btn-xs btn-default <?php echo $art == 'lcd' ? 'active' : ''; ?>">LCD</button></a>
-->
<a href="index.php?id=settings&type=time" ><button class="btn btn-xs btn-default <?php echo $art == 'time' ? 'active' : ''; ?>">Time</button></a>
<a href="index.php?id=settings&type=snmpd" ><button class="btn btn-xs btn-default <?php echo $art == 'snmpd' ? 'active' : ''; ?>">SNMPD</button></a>
<a href="index.php?id=settings&type=meteo" ><button class="btn btn-xs btn-default <?php echo $art == 'meteo' ? 'active' : ''; ?>">Meteo</button></a>
<a href="index.php?id=settings&type=smsscript" ><button class="btn btn-xs btn-default <?php echo $art == 'smsscript' ? 'active' : ''; ?>">SMS script</button></a>
<a href="index.php?id=settings&type=charts" ><button class="btn btn-xs btn-default <?php echo $art == 'charts' ? 'active' : ''; ?>">Charts</button></a>
<a href="index.php?id=settings&type=ownwidget" ><button class="btn btn-xs btn-default <?php echo $art == 'ownwidget' ? 'active' : ''; ?>">OwnWidget</button></a>
<a href="index.php?id=settings&type=server_node" ><button class="btn btn-xs btn-default <?php echo $art == 'server_node' ? 'active' : ''; ?>">Server - Node</button></a>
<a href="index.php?id=settings&type=stats" ><button class="btn btn-xs btn-default <?php echo $art == 'stats' ? 'active' : ''; ?>">Stats</button></a>
<a href="index.php?id=settings&type=mysql" ><button class="btn btn-xs btn-default <?php echo $art == 'mysql' ? 'active' : ''; ?>">MySQL</button></a>
</p>
<?php  
switch ($art)
{ 
default: case '$mail': include('modules/settings/mail.php'); break;
case 'smsscript': include('modules/settings/sms_script.php'); break;
case 'accesstime': include('modules/settings/accesstime.php'); break;
case 'gpio': include('modules/settings/gpio.php'); break;
case 'time': include('modules/settings/time.php'); break;
case 'snmpd': include('modules/settings/snmpd.php'); break;
case 'lcd': include('modules/settings/lcd.php'); break;
case '1wire': include('modules/settings/1wire.php'); break;
case 'i2c': include('modules/settings/i2c.php'); break;
case 'meteo': include('modules/settings/meteo.php'); break;
case 'modem': include('modules/settings/modem.php'); break;
case 'users': include('modules/settings/users.php'); break;
case 'charts': include('modules/settings/charts.php'); break;
case 'ownwidget': include('modules/settings/ownwidget_edit.php'); break;
case 'server_node': include('modules/settings/server_node.php'); break;
case 'stats': include('modules/settings/stats.php'); break;
case 'mysql': include('modules/mysql/mysql.php'); break;
}
?>
