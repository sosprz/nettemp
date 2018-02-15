<style type="text/css">


/* ---- grid-item ---- */

.grid-item {
    width: 340px;
    float: left;
    border-radius: 5px;
	margin-right: 10px;
	margin-bottom: 20px;
}

</style>
<?php

//$ ls -l /dev/ttyUSB0
//crw-rw---- 1 root dialout 188, 0 2011-03-30 22:11 /dev/ttyUSB0
//$ sudo usermod -G www-data,dialout www-data

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
	
// write to PiUPS
	$arr = array('U',$upsdelayon,$upsdelayoff,$upsakkuchargestart,$upsakkuchargestop,$upsakkudischarged,$upsscroll,$upsbacklight);
    $values=implode(" ",$arr);
	$fp = fopen('/dev/ttyUSB0','r+');
	fwrite($fp, "\r$values\r");
	fclose($fp);
	
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
// read from PiUPS

$readups = isset($_POST['readups']) ? $_POST['readups'] : '';
if  ($readups == "readups") {
$cmd=("exec 3</dev/ttyUSB0 && echo -n '\r' >/dev/ttyUSB0 && echo -n 'O\r' >/dev/ttyUSB0 && head -1 <&3; exec 3<&-");
$out=shell_exec($cmd);

   $out=trim($out);
   $data=explode(" ",$out);	
   
   for($i=0;$i<count($data);$i++){         
		$d1=$data[0];
		$d2=$data[1];
		$d3=$data[2];
		$d4=$data[3];
		$d5=$data[4];
		$d6=$data[5];
		$d7=$data[6];        
   }

}

// service mode PiUPS
$serviceups = isset($_POST['serviceups']) ? $_POST['serviceups'] : '';
if  ($serviceups == "serviceups") {
	$fp = fopen('/dev/ttyUSB0','r+');
	fwrite($fp, "\rT\r");
	fclose($fp);
}
// normal mode PiUPS
$normalups = isset($_POST['normalups']) ? $_POST['normalups'] : '';
if  ($normalups == "normalups") {
	$fp = fopen('/dev/ttyUSB0','r+');
	fwrite($fp, "\rN\r");
	fclose($fp);
}
// factory mode PiUPS
$factoryups = isset($_POST['factoryups']) ? $_POST['factoryups'] : '';
if  ($factoryups == "factoryups") {
	$fp = fopen('/dev/ttyUSB0','r+');
	fwrite($fp, "\rF\r");
	fclose($fp);
}
// info PiUPS
$infoups = isset($_POST['infoups']) ? $_POST['infoups'] : '';
if  ($infoups == "infoups") {
	$fp = fopen('/dev/ttyUSB0','r+');
	fwrite($fp, "\rI\r");
	fclose($fp);
}
// reset PiUPS
$resetups = isset($_POST['resetups']) ? $_POST['resetups'] : '';
if  ($resetups == "resetups") {
	$fp = fopen('/dev/ttyUSB0','r+');
	fwrite($fp, "\rR\r");
	fclose($fp);
}

//***********************************************************

$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT name, tmp, rom, position FROM sensors WHERE rom LIKE '%UPS_id%' ORDER BY position ASC");
$row = $rows->fetchAll();

?>

<div class="grid">
<div class="grid-sizer"></div>
<div class="grid-item">
<div class="panel panel-default">

<div class="panel-heading">PiUPS Status</div>
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<tbody>
		<?php
		foreach ($row as $a) { ?>	
		
		<tr>
		<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']); ?></span></td>
		<td><span class="label label-success">
		
		<?php
		
		if ($a['rom'] == 'UPS_id8' & $a['tmp'] == '1') { echo 'Charging';}
		else {
		
		 echo $a['tmp']; 
		}
		
		
		?>
		
		</span></td>	
		<td></td>		
		</tr>
		<?php
		}
		?>
		
	

		</tbody>
	</table>
</div>
		</div>
	</div>
		
		
		
		
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">PiUPS Settings</div>
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
								
								

										<tbody>
												<tr>
												<td><span class="label label-default">Delay ON</span></td>
												<td> <span class="label label-success"><?php echo $d1 ?></span></td>
<td>
	<form action="" method="post" style="display:inline!important;">
	<input type="text" name="upsdelayon" size="2" maxlength="3" value="<?php echo $nts_ups_delay_on; ?>" />
    
</td>

												</tr>

												<tr>
												<td><span class="label label-default">Delay OFF</span></td>
												<td><span class="label label-success"><?php echo $d2  ?></span></td>
<td>

	<input type="text" name="upsdelayoff" size="2" maxlength="3" value="<?php echo $nts_ups_delay_off; ?>" />
    
</td>
												</tr>

												<tr>
												<td><span class="label label-default">Akku. charge start</span></td>
												<td><span class="label label-success"><?php echo $d3 ?></span></td>
<td>
	
	<input type="text" name="upsakkuchargestart" size="2" maxlength="3" value="<?php echo $nts_ups_akku_charge_start; ?>" />
    
</td>
												</tr>

												<tr>
												<td><span class="label label-default">Akku. charge stop</span></td>
												<td><span class="label label-success"><?php echo $d4  ?></span></td>
<td>
	
	<input type="text" name="upsakkuchargestop" size="2" maxlength="3" value="<?php echo $nts_ups_akku_charge_stop; ?>" />
    
</td>	
												</tr>

												<tr>
												<td><span class="label label-default">Akku. discharged</span></td>
												<td><span class="label label-success"><?php echo $d5 ?></span></td>
<td>
	
	<input type="text" name="upsakkudischarged" size="2" maxlength="3" value="<?php echo $nts_ups_akku_discharged; ?>" />
    
</td>
											
												</tr>

												<tr>
												<td><span class="label label-default">LCD Scrolling</span></td>
												<td><span class="label label-success"><?php echo $d6  ?></span></td>
<td>
	
	<input type="text" name="upsscroll" size="2" maxlength="3" value="<?php echo $nts_ups_lcd_scroll; ?>" />
	
	 
    
</td>	
												</tr>

												<tr>
												<td><span class="label label-default">LCD Auto Backlight</span></td>
												<td><span class="label label-success"><?php echo $d7  ?></span></td>
<td>
	
	<select class="selectpicker" data-width="50px" name="upsbacklight" class="form-control input-sm">
		
		<option value="1" <?php echo $nts_ups_lcd_backlight == '1' ? 'selected="selected"' : ''; ?> >Yes</option>
		<option value="0" <?php echo $nts_ups_lcd_backlight == '0'? 'selected="selected"' : ''; ?> >No</option>
		
		</select>
	
	
	
    
</td>
												</tr>

<tr>
	<td>
			
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

<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<tbody>
		<tr>
		<td>
		
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="normalups" value="normalups" />
			<button class="btn btn-xs btn-warning">Normal</button>
		</form>
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="serviceups" value="serviceups" />
			<button class="btn btn-xs btn-warning">Service</button>
		</form>
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="factoryups" value="factoryups" />
			<button class="btn btn-xs btn-danger">Factory</button>
		</form>
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="infoups" value="infoups"/>
			<button class="btn btn-xs btn-info">Info</button>
		</form>
<!--
		<form action="" method="post" style="display:inline!important;">
			<input type="hidden" name="resetups" value="resetups" />
			<button class="btn btn-xs btn-info">Reset</button>
		</form>
-->
			
		</td>
		<tr>
		</tbody>
		</table>
		</div>

</div>



		</div>


</div>