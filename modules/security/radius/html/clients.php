<?php

$myFile = "/usr/local/etc/raddb/clients.conf";
$lines = file($myFile); 

$arr = array('ipaddr','secret','client');

foreach ($lines as $line) {
    if (strpos($line,'ipaddr') !== false) {
	if (strpos($line,'secret') !== false) {
	    if (strpos($line,'client') !== false) {
		$pieces = explode(" ", $line); ?>
		<p>
		<?php
		echo $pieces[1] . $pieces[3];
		?>
		</p>
		<?php
	
    	    }
	}
    }
}
?>