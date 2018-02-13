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
	
// wczytanie danych ups	
	
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT name, tmp, position FROM sensors WHERE rom LIKE '%UPS_id%' ORDER BY position ASC");
$row = $rows->fetchAll();

?>

<div class="grid">
<div class="grid-sizer"></div>
<div class="grid-item">
<div class="panel panel-default">

<div class="panel-heading">PiUPS Status</div>
	<table class="table table-hover table-condensed">
		<tbody>
		<?php
		foreach ($row as $a) { ?>	
		
		<tr>
		<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']); ?></span></td>
		<td><span class="label label-success"><?php echo $a['tmp']; ?></span></td>	
		<td></td>		
		</tr>
		<?php
		}
		?>
		
	

		</tbody>
	</table>

		</div>
	</div>
		
		
		
		
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">PiUPS Settings</div>
								<table class="table table-hover table-condensed">

										<tbody>
												<tr>
												<td><span class="label label-default">Delay ON</span></td>
												<td></td>
<td>
	<form action="" method="post" style="display:inline!important;">
	<input type="text" name="upsdelayon" size="2" maxlength="3" value="<?php echo $nts_ups_delay_on; ?>" />
    
</td>

												</tr>

												<tr>
												<td><span class="label label-default">Delay OFF</span></td>
												<td></td>
<td>

	<input type="text" name="upsdelayoff" size="2" maxlength="3" value="<?php echo $nts_ups_delay_off; ?>" />
    
</td>
												</tr>

												<tr>
												<td><span class="label label-default">Akku. charge start</span></td>
												<td></td>
<td>
	
	<input type="text" name="upsakkuchargestart" size="2" maxlength="3" value="<?php echo $nts_ups_akku_charge_start; ?>" />
    
</td>
												</tr>

												<tr>
												<td><span class="label label-default">Akku. charge stop</span></td>
												<td></td>
<td>
	
	<input type="text" name="upsakkuchargestop" size="2" maxlength="3" value="<?php echo $nts_ups_akku_charge_stop; ?>" />
    
</td>	
												</tr>

												<tr>
												<td><span class="label label-default">Akku. discharged</span></td>
												<td></td>
<td>
	
	<input type="text" name="upsakkudischarged" size="2" maxlength="3" value="<?php echo $nts_ups_akku_discharged; ?>" />
    
</td>
											
												</tr>

												<tr>
												<td><span class="label label-default">LCD Scrolling</span></td>
												<td></td>
<td>
	
	<input class="form-control input-sm" type="text" placeholder=".input-xs" name="upsscroll" size="2" maxlength="3" value="<?php echo $nts_ups_lcd_scroll; ?>" />
	
	 
    
</td>	
												</tr>

												<tr>
												<td><span class="label label-default">LCD Auto Backlight</span></td>
												<td></td>
<td>
	
	<select class="selectpicker" data-width="50px" name="upsbacklight" class="form-control input-sm">
		
		<option value="TAK" <?php echo $nts_ups_lcd_backlight == 'TAK' ? 'selected="selected"' : ''; ?> >Yes</option>
		<option value="NIE" <?php echo $nts_ups_lcd_backlight == 'NIE'? 'selected="selected"' : ''; ?> >No</option>
		
		</select>
	
	
	
    
</td>
												</tr>

<tr>
	<td>
				<button type="submit" name="serviceups" value="serviceups"class="btn btn-xs btn-warning">Service Mode</button>
				<button type="submit" name="infoups" value="infoups" class="btn btn-xs btn-info">Info</button>
		
	</td>
	<td>
				<button type="submit" name="readups" value="readups"class="btn btn-xs btn-success">Read</button>
				
	</td>
	<td>
				<button type="submit" name="savetoups" value="savetoups" class="btn btn-xs btn-danger">Save</button>
				</form>
	</td>
</tr>
											
												
												
												

		</tbody>
	</table>

				</div>
		</div>


</div>