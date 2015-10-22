<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

<p>
<a href="index.php?id=settings&type=users" ><button class="btn <?php echo $art == 'users' ? 'btn-info' : 'btn-default'; ?>">Users</button></a>
<a href="index.php?id=settings&type=mail" ><button class="btn <?php echo $art == 'mail' ? 'btn-info' : 'btn-default'; ?>">Mail</button></a>
<a href="index.php?id=settings&type=accesstime" ><button class="btn <?php echo $art == 'accesstime' ? 'btn-info' : 'btn-default'; ?>">Access time</button></a>
<a href="index.php?id=settings&type=modem" ><button class="btn <?php echo $art == 'modem' ? 'btn-info' : 'btn-default'; ?>">Modem</button></a>
<a href="index.php?id=settings&type=gpio" ><button class="btn <?php echo $art == 'gpio' ? 'btn-info' : 'btn-default'; ?>">GPIO</button></a>
<a href="index.php?id=settings&type=1wire" ><button class="btn <?php echo $art == '1wire' ? 'btn-info' : 'btn-default'; ?>">1wire</button></a>
<a href="index.php?id=settings&type=i2c" ><button class="btn <?php echo $art == 'i2c' ? 'btn-info' : 'btn-default'; ?>">i2c</button></a>
<a href="index.php?id=settings&type=time" ><button class="btn <?php echo $art == 'time' ? 'btn-info' : 'btn-default'; ?>">Time</button></a>
<a href="index.php?id=settings&type=snmpd" ><button class="btn <?php echo $art == 'snmpd' ? 'btn-info' : 'btn-default'; ?>">SNMPD</button></a>
<a href="index.php?id=settings&type=lcd" ><button class="btn <?php echo $art == 'lcd' ? 'btn-info' : 'btn-default'; ?>">LCD</button></a>
<a href="index.php?id=settings&type=meteo" ><button class="btn <?php echo $art == 'meteo' ? 'btn-info' : 'btn-default'; ?>">Meteo</button></a>
<a href="index.php?id=settings&type=smsscript" ><button class="btn <?php echo $art == 'smsscript' ? 'btn-info' : 'btn-default'; ?>">SMS script</button></a>
<a href="index.php?id=settings&type=charts" ><button class="btn <?php echo $art == 'charts' ? 'btn-info' : 'btn-default'; ?>">Charts</button></a>
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
}
?>
