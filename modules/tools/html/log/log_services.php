<?php
$service=isset($_GET['service']) ? $_GET['service'] : '';
?>
<p>
    <a href="index.php?id=tools&type=log&log=services&service=smstools" class="btn btn-default btn-xs" <?php echo $service == 'smstools' ? 'active' : ''; ?> ">SMStools </a>
    <a href="index.php?id=tools&type=log&log=services&service=msmtp" class="btn btn-default btn-xs" <?php echo $service == 'msmtp' ? 'active' : ''; ?> ">msmtp </a>
    <a href="index.php?id=tools&type=log&log=services&service=lighttpd" class="btn btn-default btn-xs" <?php echo $service == 'lighttpd' ? 'active' : ''; ?> ">lighttpd </a>
</p>

<pre>
<?php
switch ($service)
{ 
default: case '$service': include('/var/log/msmtp.log'); break;
case 'msmtp': include('/var/log/msmtp.log'); break;
case 'smstools': include('/var/log/smstools/smsd.log'); break;
case 'lighttpd': include('/var/log/lighttpd/error.log'); break;

}
?>
</pre>