


<div class="grid-item ups">
    <div class="panel panel-default">
    <div class="panel-heading">UPS Status</div>
        <div class="panel-body">
<?php

if ($nts_ups_status != 'on' ) { return; }
else {
	exec("/sbin/apcaccess",$upso);
	foreach($upso as $ar) {
	    $col = explode(":", $ar);
	    $array[$col[0]]=$col[1];
    	}
		
foreach($array as $key => $value){
    if (strpos($key, 'UPSMODE') !== false) {
	echo "Mode: ".$value."<br>";
    }
    if (strpos($key, 'STATUS') !== false) {
	echo "Status: ".$value."<br>";
    }
    if (strpos($key, 'TIMELEFT') !== false) {
	echo "Left time on battery: ".$value."<br>";
    }
    if (strpos($key, 'TONBATT') !== false) {
	echo "Time on baterry: ".$value."<br>";
    }

}
?>			
	</div>
    </div>
</div>

<?php
}
?>
