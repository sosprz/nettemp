<p>
    <a href="index.php?id=tools&type=log&log=services&service=smstools"><button class="btn btn-default btn-xs">SMStools </button></a>
    <a href="index.php?id=tools&type=log&log=services&service=msmtp"><button class="btn btn-default btn-xs">msmtp </button></a>
</p>

</pre>
<?php
$service=isset($_GET['service']) ? $_GET['service'] : '';
switch ($log)
{ 
default: case '$service': include('/var/log/msmtp.log'); break;
case 'msmtp': include('/var/log/msmtp.log'); break;
case 'smstools': include('/var/log/smstools/smsd.log'); break;

}
?>
</pre>