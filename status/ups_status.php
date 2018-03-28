<?php
$upsq = $db->query("SELECT value FROM nt_settings WHERE option='ups_status'");
$upsqr = $upsq->fetchAll();
foreach ($upsqr as $ups) {
    $nts_ups_status=$ups['value'];
}

if ($nts_ups_status != 'on' ) { return; }
else {
	exec("/sbin/apcaccess",$upso);
	foreach($upso as $ar) {
	    $col = explode(":", $ar);
	    $array[$col[0]]=$col[1];
    	}

?>


<div class="grid-item ups">
    <div class="panel panel-default">
    <div class="panel-heading">UPS Status</div>
        <div class="panel-body">
<?php
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
	 if (strpos($key, 'DATE') !== false) {
	echo "Test: ".$value."<br>";
    }

}
?>			
	</div>
    </div>
</div>

<?php
}
?>
