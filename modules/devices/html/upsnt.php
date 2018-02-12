<style type="text/css">


/* ---- grid-item ---- */

.grid-item {
    width: 340px;
    float: left;
    border-radius: 5px;
	margin-right: 10px;
}

</style>
<?php
$root=$_SERVER["DOCUMENT_ROOT"];

$upsdelayon = isset($_POST['upsdelayon']) ? $_POST['upsdelayon'] : '';
$upsdelayoff = isset($_POST['upsdelayoff']) ? $_POST['upsdelayoff'] : '';
$upsakkuchargestart = isset($_POST['upsakkuchargestart']) ? $_POST['upsakkuchargestart'] : '';
$upsakkuchargestop = isset($_POST['upsakkuchargestop']) ? $_POST['upsakkuchargestop'] : '';
$upsakkudischarged = isset($_POST['upsakkudischarged']) ? $_POST['upsakkudischarged'] : '';
$upsscroll = isset($_POST['upsscroll']) ? $_POST['upsscroll'] : '';
$upsbacklight = isset($_POST['upsbacklight']) ? $_POST['upsbacklight'] : '';
$savetoups = isset($_POST['savetoups']) ? $_POST['savetoups'] : '';

 if  ($savetoups == "savetoups") {
    $db = new PDO("sqlite:$root/dbf/nettemp.db");
    $db->exec("UPDATE nt_settings SET value='$upsdelayon' WHERE option='ups_delay_on'");
	$db->exec("UPDATE nt_settings SET value='$upsdelayoff' WHERE option='ups_delay_off'");
	$db->exec("UPDATE nt_settings SET value='$upsakkuchargestart' WHERE option='ups_akku_charge_start'");
	$db->exec("UPDATE nt_settings SET value='$upsakkuchargestop' WHERE option='ups_akku_charge_stop'");
	$db->exec("UPDATE nt_settings SET value='$upsakkudischarged' WHERE option='ups_akku_discharged'");
	$db->exec("UPDATE nt_settings SET value='$upsscroll' WHERE option='ups_lcd_scroll'");
	$db->exec("UPDATE nt_settings SET value='$upsbacklight' WHERE option='ups_lcd_backlight'");
	
	// tutaj zapis do UPSA
	
	
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>

<div class="grid">
<div class="grid-sizer"></div>
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">UPS NT Status</div>
								<table class="table table-hover table-condensed">

										<tbody>
												<tr>
												<td >DC Input</td>
												<td></td>
												
												</tr>

												<tr>
												<td >DC Output</td>
												<td></td>
												
												</tr>

												<tr>
												<td >DC Akku.</td>
												<td></td>
											
												</tr>


												<tr>
												<td >Current output</td>
												<td></td>
												
												</tr>

												<tr>
												<td >Power Output</td>
												<td></td>
												
												</tr>

												<tr>
												<td >Akku. Temp</td>
												<td></td>
												
												</tr>

												<tr>
												<td >Akku. Capacity</td>
												<td></td>
												
												</tr>

												<tr>
												<td >Akku. Charge</td>
												<td></td>
												
												</tr>

												<tr>
												<td >UPS AC Power</td>
												<td></td>
												
												</tr>

												<tr>
												<td >Akku. Health</td>
												<td></td>
												
												</tr>

										</tbody>
								</table>

				</div>
		</div>
		
		
		
		
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">UPS NT Settings</div>
								<table class="table table-hover table-condensed">

										<tbody>
												<tr>
												<td >Delay ON</td>
												<td></td>
<td>
	<form action="" method="post" style="display:inline!important;">
	<input type="text" name="upsdelayon" size="2" maxlength="5" value="<?php echo $nts_ups_delay_on; ?>" />
    
</td>

												</tr>

												<tr>
												<td >Delay OFF</td>
												<td></td>
<td>

	<input type="text" name="upsdelayoff" size="2" maxlength="5" value="<?php echo $nts_ups_delay_off; ?>" />
    
</td>
												</tr>

												<tr>
												<td >Akku. charge start</td>
												<td></td>
<td>
	
	<input type="text" name="upsakkuchargestart" size="2" maxlength="5" value="<?php echo $nts_ups_akku_charge_start; ?>" />
    
</td>
												</tr>

												<tr>
												<td >Akku. charge stop</td>
												<td></td>
<td>
	
	<input type="text" name="upsakkuchargestop" size="2" maxlength="5" value="<?php echo $nts_ups_akku_charge_stop; ?>" />
    
</td>	
												</tr>

												<tr>
												<td >Akku. discharged</td>
												<td></td>
<td>
	
	<input type="text" name="upsakkudischarged" size="2" maxlength="5" value="<?php echo $nts_ups_akku_discharged; ?>" />
    
</td>
											
												</tr>

												<tr>
												<td >LCD Scrolling</td>
												<td></td>
<td>
	
	<input type="text" name="upsscroll" size="2" maxlength="5" value="<?php echo $nts_ups_lcd_scroll; ?>" />
    
</td>	
												</tr>

												<tr>
												<td >LCD Auto Backlight</td>
												<td></td>
<td>
	
	<select name="upsbacklight" class="form-control input-sm">
		
		<option value="yes" <?php echo $nts_ups_lcd_backlight ? 'selected="selected"' : ''; ?> >Yes</option>
		<option value="no" <?php echo $nts_ups_lcd_backlight ? 'selected="selected"' : ''; ?> >No</option>
		
		</select>
	
	
	
    
</td>
												</tr>

												<tr>
												<td></td>
												<td><button type="submit" class="btn btn-xs btn-info">Read</button></td>
												<td>
												<input type="hidden" name="savetoups" value="savetoups" />
												<button type="submit" class="btn btn-xs btn-danger">Save</button>
												
												</form></td>
												</tr>

										</tbody>
								</table>

				</div>
		</div>


</div>