<?php
$root=$_SERVER["DOCUMENT_ROOT"];
if(isset($_SESSION['user'])){
	
/* SWITCH EasyESP */
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$sth = $db->prepare("SELECT ip,rom,gpio,name,tmp FROM sensors WHERE type='switch' AND ch_group='switch'");
$sth->execute();
$sensors_switch = $sth->fetchAll();

/* RELAYS  wireless, nodemcu */
$sth = $db->prepare("SELECT ip,rom,gpio,name,tmp FROM sensors WHERE type='relay' AND ch_group='relay'");
$sth->execute();
$sensors_relay = $sth->fetchAll();


if(!empty($sensors_switch)||!empty($sensors_relay)) {
?>
<div class="grid-item swcon">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Switch</h3>
</div>
<table class="table table-hover table-condensed small" border="0">
	<tbody>
	<?php
	/* SWITCH EasyESP */
	$numRows = count($sensors_switch);
	if ( $numRows > '0' ) { 
		$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
		$switch = isset($_POST['switch']) ? $_POST['switch'] : '';
		$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
		$gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';
		$sonoff = isset($_POST['sonoff']) ? $_POST['sonoff'] : '';

		if (($sonoff == "sonoff")){
			if ($switch == 'on' ){
				$ch = curl_init();
				$optArray = array(
					CURLOPT_URL => "$ip/control?cmd=GPIO,$gpio,1",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 1,
					CURLOPT_TIMEOUT => 3
				);
				curl_setopt_array($ch, $optArray);
				$res = curl_exec($ch);

				$dbf = new PDO("sqlite:db/$rom.sql");
				$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('1')");
				$db->exec("UPDATE sensors SET tmp='1.0' WHERE rom='$rom'");
			} else { 
				$ch = curl_init();
				$optArray = array(
					CURLOPT_URL => "$ip/control?cmd=GPIO,$gpio,0",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 1,
					CURLOPT_TIMEOUT => 3
				);
				curl_setopt_array($ch, $optArray);
				$res = curl_exec($ch);
		
				$dbf = new PDO("sqlite:db/$rom.sql");
				$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('0')");
				$db->exec("UPDATE sensors SET tmp='0.0' WHERE rom='$rom'");
			}
		$db->exec("UPDATE gpio SET locked='user' WHERE gpio='$gpio'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		
		/* FORMS */
        $value_update_from_status = isset($_POST['value_update_from_status']) ? $_POST['value_update_from_status'] : '';
		$id_value_update_from_status = isset($_POST['id_value_update_from_status']) ? $_POST['id_value_update_from_status'] : '';
		$update_from_status = isset($_POST['update_from_status']) ? $_POST['update_from_status'] : '';
		
		$lock_update_from_status = isset($_POST['lock_update_from_status']) ? $_POST['lock_update_from_status'] : '';
		$gpio_lock_update_from_status = isset($_POST['gpio_lock_update_from_status']) ? $_POST['gpio_lock_update_from_status'] : '';

		if($update_from_status=='switch_update_from_status') {
			$db->exec("UPDATE g_func SET value='$value_update_from_status' WHERE id='$id_value_update_from_status'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		
		if($update_from_status=='lock_update_from_status') {
			$db->exec("UPDATE gpio SET locked='$lock_update_from_status' WHERE gpio='$gpio_lock_update_from_status'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		    

		foreach ( $sensors_switch as $s) {
		?>
		<tr>
			<td class="col-md-2">
				<?php echo $s['name']; ?>
			</td>
			<td class="col-md-2">
				<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
					<input type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="<?php echo $s['tmp'] == '1.0'  ? 'off' : 'on'; ?>" <?php echo $s['tmp'] == '1.0' ? 'checked="checked"' : ''; ?>  />
					<input type="hidden" name="ip" value="<?php echo $s['ip']; ?>"/>
					<input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
					<input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
					<input type="hidden" name="sonoff" value="sonoff" />
				</form>
			</td>
			<?php
		
			/* SWITCH EasyESP ADDON TEMP*/
			$sth = $db->prepare("SELECT mode,locked FROM gpio WHERE gpio='$s[gpio]'");
			$sth->execute();
			$gpio = $sth->fetchAll();
			foreach ($gpio as $g) {
			
				if($g['mode']=='temp') {
					/* TEMP */
					$sth = $db->prepare("SELECT id,value FROM g_func WHERE gpio='$s[gpio]' ORDER BY position ASC LIMIT 1 ");
					$sth->execute();
					$g_func = $sth->fetchAll();
					$numRows = count($result);
					$gpio_locked=$g['locked'];
			
					foreach ($g_func as $gf) {
					?>
					<td>
						Value:
					</td>
					<td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="number" style="width: 4em;" onchange="this.form.submit()" name="value_update_from_status" value="<?php echo $gf['value'] ?>" />
						<input type="hidden" name="id_value_update_from_status" value="<?php echo $gf['id']; ?>"/>
						<input type="hidden" name="update_from_status" value="switch_update_from_status" />
					</form>
					</td>
					<td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="hidden" name="gpio_lock_update_from_status" value="<?php echo $s['gpio']; ?>"/>
						<input type="checkbox"  data-toggle="toggle" data-size="mini" data-on="lock" data-off="lock" onchange="this.form.submit()" name="lock_update_from_status" value="<?php echo $g['locked'] == 'user'  ? '' : 'user'; ?>" <?php echo $g['locked'] == 'user' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="update_from_status" value="lock_update_from_status" />
					</form>
					</td>
					<?php
					} 
					?>
					</tr>	
					<?php
				}
			}
		}
	}


	/* RELAYS  wireless, nodemcu */
	$numRows = count($sensors_relay);
	if ( $numRows > '0' ) { 
		$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
		$relay = isset($_POST['relay']) ? $_POST['relay'] : '';
		$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
		$ronoff = isset($_POST['ronoff']) ? $_POST['ronoff'] : '';
		if (($ronoff == "ronoff")){
			if ($relay == 'on' ){
				$ch = curl_init();
				$optArray = array(
					CURLOPT_URL => "$ip/seton",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CONNECTTIMEOUT => 1,
					CURLOPT_TIMEOUT => 3
				);
				curl_setopt_array($ch, $optArray);
				$res = curl_exec($ch);
				$dbf = new PDO("sqlite:db/$rom.sql");
				$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('1')");
				$db->exec("UPDATE sensors SET tmp='1' WHERE rom='$rom'");
		} else { 
			$ch = curl_init();
			$optArray = array(
				CURLOPT_URL => "$ip/setoff",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CONNECTTIMEOUT => 1,
				CURLOPT_TIMEOUT => 3
			);
			curl_setopt_array($ch, $optArray);
			$res = curl_exec($ch);
			$dbf = new PDO("sqlite:db/$rom.sql");
			$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('0')");
			$db->exec("UPDATE sensors SET tmp='0' WHERE rom='$rom'");
		}
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}

		foreach ( $sensors_relay as $r) {
		$ip=$r['ip'];
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/showstatus",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);
		$o1=str_replace('status', '', $res);
		$o=strtolower(trim($o1));
		?>
		<tr>
			<td>
				<?php echo $r['name']; ?>
			</td>
			<td>
				<input type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="relay" value="<?php echo $o == 'on'  ? 'off' : 'on'; ?>" <?php echo $o == 'on' ? 'checked="checked"' : ''; ?>  />
				<input type="hidden" name="ip" value="<?php echo $r['ip']; ?>"/>
				<input type="hidden" name="rom" value="<?php echo $r['rom']; ?>"/>
				<input type="hidden" name="gpio" value="<?php echo $r['gpio']; ?>"/>
				<input type="hidden" name="ronoff" value="ronoff" />
			</td>
		</tr>
		<?php
		unset($i);
		}
	}

	/* GPIO */
?>



<!--END-->
	</tbody>
</table>
</div>
</div>
<?php
} /*user*/

} /* end check if empty */
?>



