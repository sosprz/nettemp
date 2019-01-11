<?php
	$service=isset($_GET['service']) ? $_GET['service'] : '';
?>
<p>
    <a href="index.php?id=tools&type=log&log=services&service=smstools"><button class="btn btn-default btn-xs <?php echo $service == 'smstools' ? 'active' : ''; ?> ">SMStools </button></a>
    <a href="index.php?id=tools&type=log&log=services&service=msmtp"><button class="btn btn-default btn-xs <?php echo $service == 'msmtp' ? 'active' : ''; ?> ">msmtp </button></a>
    <a href="index.php?id=tools&type=log&log=services&service=lighttpd"><button class="btn btn-default btn-xs <?php echo $service == 'lighttpd' ? 'active' : ''; ?> ">lighttpd </button></a>
</p>

<pre>
<?php


switch ($service)
{ 
default: case '$lighttpd': $filearray = file("/var/log/lighttpd/error.log"); $last = array_slice($filearray,-40); foreach($last as $f){ echo $f; }; break;
case 'msmtp': $filearray = file("/var/log/msmtp.log"); $last = array_slice($filearray,-40); foreach($last as $f){ echo $f; }; break;
case 'smstools': $filearray = file("/var/log/smstools/smsd.log"); $last = array_slice($filearray,-40); foreach($last as $f){ echo $f; }; break;
case 'lighttpd': $filearray = file("/var/log/lighttpd/error.log"); $last = array_slice($filearray,-40); foreach($last as $f){ echo $f; }; break;


}
?>
</pre>