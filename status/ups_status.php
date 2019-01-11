<?php
$upsq = $db->query("SELECT value, option FROM nt_settings WHERE option='ups_status' OR option='hide_ups'");
$upsqr = $upsq->fetchAll();
foreach ($upsqr as $ups) {
	if($ups['option']=='hide_ups') {
       	$nts_hide_ups=$ups['value'];
    }
	if($ups['option']=='ups_status') {
       	$nts_ups_status=$ups['value'];
    }
}
//hide ups in status
	$hideups = isset($_POST['hideups']) ? $_POST['hideups'] : '';
	$hideupsstate = isset($_POST['hideupsstate']) ? $_POST['hideupsstate'] : '';
	
	if (!empty($hideups) && $hideups == 'hideups'){
		if ($hideupsstate == 'on') {$hideupsstate = 'off';
		}elseif ($hideupsstate == 'off') {$hideupsstate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE nt_settings SET value='$hideupsstate' WHERE option='hide_ups'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }	
if ($nts_ups_status != 'on' ) { return; }
else {
?>
<div class="grid-item ups">
<div class="panel panel-default">
<div class="panel-heading"> 
<div class="pull-left">UPS Status</div>
<div class="pull-right">
		<div class="text-right">
			<form action="" method="post" style="display:inline!important;">
					
					<input type="hidden" name="hideupsstate" value="<?php echo $nts_hide_ups; ?>" />
					<input type="hidden" name="hideups" value="hideups"/>
					<?php
					if($nts_hide_ups == 'off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($nts_hide_ups == 'on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
			</form>	
		</div>
 </div>
 <div class="clearfix"></div>
</div>
	
<div class="table-responsive">
<table class="table table-hover table-condensed">
<tbody>      
<?php
if ($nts_hide_ups == 'off') {

	exec("/sbin/apcaccess",$upso);
	foreach($upso as $ar) {
	    $col = explode(":", $ar);
	    $array[$col[0]]=$col[1];
    	}
		
foreach($array as $key => $value){
	
	if (strpos($key, 'MODEL') !== false) { ?>
	<tr>
	<td><span class="label label-default">Model </span></td>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
    </tr>
	<?php }
	
	if (strpos($key, 'STATUS') !== false) { ?>
	<tr>
	<td><span class="label label-default">Status </span></td>
	
	<?php if (trim($value) == 'ONLINE' || trim($value) == 'ONLINE SLAVE' ) { ?>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
	<?php } elseif (trim($value) == 'OFFLINE' || trim($value) == 'OFFLINE SLAVE') { ?>
		<td><span class="label label-success"><?php echo $value; ?></span></td>
	<?php }
	?>
    </tr>
	<?php }
	
	if (strpos($key, 'TIMELEFT') !== false) { ?>
	<tr>
	<td><span class="label label-default">Left time on battery </span></td>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
    </tr>
	<?php }
	
	if (strpos($key, 'BATTV') !== false && strpos($key, 'NOMBATTV') === false ) { ?>
	<tr>
	<td><span class="label label-default">Battery voltage </span></td>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
    </tr>
	<?php }
	
	if (strpos($key, 'LINEV') !== false) { ?>
	<tr>
	<td><span class="label label-default">Line voltage </span></td>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
    </tr>
	<?php }
	
	if (strpos($key, 'LOADPCT') !== false) { ?>
	<tr>
	<td><span class="label label-default">UPS load </span></td>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
    </tr>
	<?php }
	
	if (strpos($key, 'TONBATT') !== false) { ?>
	<tr>
	<td><span class="label label-default">Time on baterry </span></td>
	<td><span class="label label-success"><?php echo $value; ?></span></td>
    </tr>
	<?php }
}
}//hide
?>
</tbody>
</table>
</div>			
</div>
</div>
</div>



<?php
}
?>
