<?php
session_start();
$root=$_SERVER["DOCUMENT_ROOT"];
if(isset($_SESSION['user'])){
	
/* SWITCH EasyESP */
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$sth = $db->prepare("SELECT ip,rom,gpio,name,tmp,status FROM sensors WHERE type='gpio' AND ch_group='gpio' ORDER BY position ASC");
$sth->execute();
$ip_gpio = $sth->fetchAll();

/* RELAYS  wireless, nodemcu */
$sth = $db->prepare("SELECT ip,rom,gpio,name,tmp FROM sensors WHERE type='relay' AND ch_group='relay'");
$sth->execute();
$sensors_relay = $sth->fetchAll();

/* Functions */

function label($status){
	if($status == 'on' || $status == 'ON' || $status=substr($status,0,2)== 'ON' )
	{	
		return 'label-success';
	} 
	elseif($status == 'off' || $status == 'OFF') 
	{
		return 'label-danger';
	}
	elseif($status == 'moment')
	{
		return 'label-default';
	}
	elseif($status == 'error')
	{
		return 'label-warning';
	}
	else 
	{
		return 'label-danger';
	}

}




function gpio_db($rom,$action){
	global $root;
	$dbf = new PDO("sqlite:$root/db/$rom.sql");
	$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('$action')");
}

function gpio_status($rom,$tmp,$action,$gpio){
	global $root;
	$db = new PDO("sqlite:$root/dbf/nettemp.db");
	$db->exec("UPDATE sensors SET tmp='$tmp', status='$action' WHERE rom='$rom'");
	$db->exec("UPDATE gpio SET status='$action', simple='$action' WHERE rom='$rom'");
}

function gpio_curl_onoff($ip,$gpio,$rom,$action,$moment_time){
	
	if($action=='on') {
		$set='1';
		$tmp='1.0';
		$method='GPIO';
		$time='0';
	} elseif($action=='off') {
		$set='0';
		$tmp='0.0';
		$method='GPIO';
		$time='0';
	} elseif($action=='moment') {
		$method='Pulse';
		$set='1';
		$tmp='1.0';
	}
		
	$ch = curl_init();
	$optArray = array(
		CURLOPT_URL => "$ip/control?cmd=$method,$gpio,$set,$moment_time",
		CURLOPT_HEADER => true,
		CURLOPT_NOBODY => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 1,
		CURLOPT_TIMEOUT => 3
	);
	curl_setopt_array($ch, $optArray);
	$res = curl_exec($ch);
	
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if($httpcode == 200) {
		gpio_db($rom,$set);
		gpio_status($rom,$tmp,$action,$gpio);
	} else {
		gpio_status($rom,0,error,$gpio);
	}

}

function gpio_onoff($gpio,$rom,$action,$rev){
	
	if($action=='on'&&$rev=='on'){
		$set='0';
	} elseif ($action=='on'&&$rev==''){
		$set='1';
	} elseif ($action=='off'&&$rev=='on'){
		$set='1';
	} elseif ($action=='off'&&$rev==''){
		$set='0';
	}
	
	if ($gpio >= '100') {
		exec("/usr/local/bin/gpio -x mcp23017:$gpio:0x20 mode $gpio out");
		if ($rev == 'on') { 
			exec("/usr/local/bin/gpio -x mcp23017:$gpio:0x20 write $gpio $set");
		}
		else { 
			exec("/usr/local/bin/gpio -x mcp23017:$gpio:0x20 write $gpio $set");
		}
	} else {	
		exec("/usr/local/bin/gpio -g mode $gpio output");
		if ($rev == 'on') { 
			exec("/usr/local/bin/gpio -g write $gpio $set");	
		}
		else { 
			exec("/usr/local/bin/gpio -g write $gpio $set");	
		}
	}

	gpio_db($rom,$set);
	gpio_status($rom,$tmp,$action,$gpio);
}

function gpio_moment($gpio,$rom,$rev,$moment_time) {
	$tmp='';
	$action='moment';
	if ($rev == 'on') {
		$faction='0';
		$laction='1';
	} else {
		$faction='1';
		$laction='0';
	}
	$set='1';
	exec("/usr/local/bin/gpio -g mode $gpio output && /usr/local/bin/gpio -g write $gpio $faction && sleep $moment_time && /usr/local/bin/gpio -g write $gpio $laction");
	gpio_db($rom,$set);
	gpio_status($rom,$tmp,$action,$gpio);
}


/* END FUNCTIONS */

if(!empty($ip_gpio)||!empty($sensors_relay)) {
?>

<div class="grid-item swcon">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO</h3>
</div>
<table class="table table-hover table-condensed small" border="0">
	<tbody>
	<?php
	/* EasyESP */
	$numRows = count($ip_gpio);
	if ( $numRows > '0' ) { 
		/* FORMS */
		$ip_post = isset($_POST['ip']) ? $_POST['ip'] : '';
		$switch = isset($_POST['switch']) ? $_POST['switch'] : '';
		$rom_post = isset($_POST['rom']) ? $_POST['rom'] : '';
		$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
		$rev = isset($_POST['rev']) ? $_POST['rev'] : '';
		$onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
		$moment_time = isset($_POST['moment_time']) ? $_POST['moment_time'] : '';
		$rom_lock = isset($_POST['rom_lock']) ? $_POST['rom_lock'] : '';
		$trun = isset($_POST['trun']) ? $_POST['trun'] : '';
		$time_offset = isset($_POST['time_offset']) ? $_POST['time_offset'] : '';
		
		
		/* SIMPLE IP */
		if ($onoff == "simpleip"){
			if ($switch == 'on' ){
				gpio_curl_onoff($ip_post,$gpio_post,$rom_post,'on','0');
			} else { 
				gpio_curl_onoff($ip_post,$gpio_post,$rom_post,'off','0');
			}
		$db->exec("UPDATE gpio SET locked='user' WHERE gpio='$gpio_post' AND rom='$rom_post'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		/* MOMENT IP */
		if ($onoff == "momentip"){
			if($moment_time>10){
				$moment_time=10;
			}
			$moment_time=$moment_time*1000;	
			
			gpio_curl_onoff($ip_post,$gpio_post,$rom_post,'moment',$moment_time);
	
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		
		/* TIME IP */
		if ($trun == "timerunip") {
			if ($switch == 'on' ){
				gpio_curl_onoff($ip_post,$gpio_post,$rom_post,'on','0');
				$date = new DateTime();
				$time_start=$date->getTimestamp();
				$db->exec("UPDATE gpio SET time_run='on', status='ON $time_offset min', time_offset='$time_offset',time_start='$time_start' WHERE gpio='$gpio_post' AND rom='$rom_post'") or die("exec error");
				header("location: " . $_SERVER['REQUEST_URI']);
				exit();
			} else {
				gpio_curl_onoff($ip_post,$gpio_post,$rom_post,'off','0');
				$date = new DateTime();
				$time_start=$date->getTimestamp();
				$db->exec("UPDATE gpio SET time_run='', time_start='', status='OFF' WHERE gpio='$gpio_post' AND rom='$rom_post'") or die("exec error");
				header("location: " . $_SERVER['REQUEST_URI']);
				exit();
			}
	
		}
		

		
        $value_update_from_status = isset($_POST['value_update_from_status']) ? $_POST['value_update_from_status'] : '';
		$id_value_update_from_status = isset($_POST['id_value_update_from_status']) ? $_POST['id_value_update_from_status'] : '';
		$update_from_status = isset($_POST['update_from_status']) ? $_POST['update_from_status'] : '';
		$time_update_from_status = isset($_POST['time_update_from_status']) ? $_POST['time_update_from_status'] : '';
		
		$lock_update_from_status = isset($_POST['lock_update_from_status']) ? $_POST['lock_update_from_status'] : '';
		$gpio_lock_update_from_status = isset($_POST['gpio_lock_update_from_status']) ? $_POST['gpio_lock_update_from_status'] : '';
		$rom_lock = isset($_POST['rom_lock']) ? $_POST['rom_lock'] : '';

		if($update_from_status=='switch_update_from_status') {
			$db->exec("UPDATE g_func SET value='$value_update_from_status' WHERE id='$id_value_update_from_status'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		
		if($update_from_status=='lock_update_from_status') {
			$db->exec("UPDATE gpio SET locked='$lock_update_from_status' WHERE gpio='$gpio_lock_update_from_status' AND rom='$rom_lock'");
			header("location: " . $_SERVER['REQUEST_URI']);
			exit();
		}
		
		if($update_from_status=='time_update_from_status') {
			$db->exec("UPDATE gpio SET time_offset='$value_update_from_status' WHERE gpio='$gpio_post' AND rom='$rom_post'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		
		/* MOMENT */
		if ($onoff == "bi")  {
			if($moment_time>10){
				$moment_time=10;
			}
			gpio_moment($gpio_post,$rom_post,$rev,$moment_time);
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		/* SIMPLE */
		if ($onoff == "simple") {
			if ($switch == 'on' ){
				gpio_onoff($gpio_post,$rom_post,'on',$rev);
			} else {
				gpio_onoff($gpio_post,$rom_post,'off',$rev);
			}
		$db->exec("UPDATE gpio SET locked='user' WHERE gpio='$gpio_post' AND rom='$rom_post'");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
		}
		
		/* TIME */
		if ($trun == "timerun") {
			if ($switch == 'on' ){
				gpio_onoff($gpio_post,$rom_post,'on',$rev);
				$date = new DateTime();
				$time_start=$date->getTimestamp();
				$db->exec("UPDATE gpio SET time_run='on', status='ON $time_offset min', time_offset='$time_offset',time_start='$time_start' WHERE gpio='$gpio_post' AND rom='$rom_post'") or die("exec error");
				header("location: " . $_SERVER['REQUEST_URI']);
				exit();
			} else {
				gpio_onoff($gpio_post,$rom_post,'off',$rev);
				$date = new DateTime();
				$time_start=$date->getTimestamp();
				$db->exec("UPDATE gpio SET time_run='', time_start='', status='OFF' WHERE gpio='$gpio_post' AND rom='$rom_post'") or die("exec error");
				header("location: " . $_SERVER['REQUEST_URI']);
				exit();
			}
	
		}
  		    

		foreach ( $ip_gpio as $s) {
			?>
			

			<tr>
				<?php		
				/* GPIO */
				$sth = $db->prepare("SELECT * FROM gpio WHERE gpio='$s[gpio]' AND rom='$s[rom]' AND (mode='simple' OR mode='temp' OR mode='moment' OR mode='read' OR mode='day' OR mode='time') ");
				$sth->execute();
				$gpio = $sth->fetchAll();
				foreach ($gpio as $g) {
				?>
					<td class="col-md-1">
						<a href="index.php?id=device&type=gpio&gpios=<?php echo $s['gpio'] ?>&ip=<?php echo $s['ip'] ?>&roms=<?php echo $s['rom'] ?>"><img <?php if (!$s['ip']) {echo 'src="media/ico/switch-icon.png"';} else {echo 'src="media/ico/switchip-icon.png"';}  ?> alt="" title="<?php if(!empty($s['ip'])){echo "Last IP: ".$s['ip']." GPIO: ".$s['gpio']." Mode: ".$g['mode'];} else {echo "GPIO: ".$s['gpio']." Mode: ".$g['mode'];}?>" /></a>
					</td>
					<td class="col-md-1">
						<a href="index.php?id=view&type=gpio&max=day&single=<?php echo $s['name']?>" class="label <?php echo label($g['status']) ?>" title="Charts" ><?php echo str_replace("_", " ", $s['name'])?></a>
					</td>
				<?php
				/* SIMPLE AND DAY IP */
				if(($g['mode']=='simple'&&!empty($s['ip']))||($g['mode']=='temp'&&!empty($s['ip'])) ||($g['mode']=='day'&&!empty($s['ip']))) {
					?>
					<td class="col-md-1">
                   	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input id="onoffstatus" type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="<?php echo $s['tmp'] == '1.0'  ? 'off' : 'on'; ?>" <?php echo $s['tmp'] == '1.0' ? 'checked="checked"' : ''; ?>  />
                        <input type="hidden" name="ip" value="<?php echo $s['ip']; ?>"/>
                        <input type="hidden" name="rev" value="<?php echo $g['rev']; ?>"/>
                        <input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
                        <input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
                        <input type="hidden" name="onoff" value="simpleip" />
                    </form>
                    </td>  
					
                   <?php 
				   if($g['mode']!='temp' & $g['mode']=='simple') { echo '<td></td><td></td><td></td>';}
				   elseif($g['mode']!='temp' & $g['mode']=='day')                 {?>
					
					<?php
					$sth = $db->prepare("SELECT name,stime,etime FROM day_plan WHERE  active='on' AND rom='$s[rom]' ");
					$sth->execute();
					$activedp = $sth->fetchAll();
					$numRows = count($activedp);
					if($numRows > 0) {
					foreach ($activedp as $adp) {
						
						$activenamedp=$adp[name];
						$stime=$adp[stime];
						$etime=$adp[etime];
					?>
					<td class="col-md-2">
					<span class="label label-info"><?php echo $activenamedp; ?> </span> 
					<!--
					<td class="col-md-1">
					<span style=" display:inline!important" class="label label-warning"><?php echo $stime." ".$etime;?> </span>
					</td>
					-->
					</td>
					<?php
					 echo '<td class="col-md-1"></td>';
					}
					} else {echo '<td></td><td></td>';}
					?>

				   
				   <td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="hidden" name="gpio_lock_update_from_status" value="<?php echo $s['gpio']; ?>"/>
						<input id="lockstatus" type="checkbox"  data-toggle="toggle" data-size="mini" data-on="lock" data-off="lock" onchange="this.form.submit()" name="lock_update_from_status" value="<?php echo $g['locked'] == 'user'  ? '' : 'user'; ?>" <?php echo $g['locked'] == 'user' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="rom_lock" value="<?php echo $s['rom']; ?>"/>
						<input type="hidden" name="update_from_status" value="lock_update_from_status" />
					</form>
					</td>

					<?php } 

				   
				}
				/* SIMPLE AND DAY*/
				elseif(($g['mode']=='simple')||($g['mode']=='temp')||($g['mode']=='day')) {
				
					?>
					<td class="col-md-1">
					 <?php
						exec('/usr/local/bin/gpio -g read '.$g['gpio'], $state);
						$set=$state[0];
						if ($g['rev']=='on'){
							
							if ($set==1){$set=0;
							
							} else {$set=1;}
						}
					?>	
                   	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input id="onoffstatus" type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="on" <?php echo $set == '1' ? 'checked="checked"' : ''; ?>  />
                        <input type="hidden" name="rev" value="<?php echo $g['rev']; ?>"/>
                        <input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
                        <input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
                        <input type="hidden" name="onoff" value="simple" />
                    </form>
                    </td>
                    <?php 
                    unset($set);
                    unset($state);
                    
					if($g['mode']!='temp' & $g['mode']=='simple') { echo '<td class="col-md-1"></td><td></td><td></td>';}
                    elseif($g['mode']!='temp' & $g['mode']=='day') {?>
					
					
					
					<?php
					$sth = $db->prepare("SELECT name,stime,etime FROM day_plan WHERE  active='on' AND rom='$s[rom]' ");
					$sth->execute();
					$activedp = $sth->fetchAll();
					$numRows = count($activedp);
					if($numRows > 0) {
					foreach ($activedp as $adp) {
						
						$activenamedp=$adp[name];
						$stime=$adp[stime];
						$etime=$adp[etime];
					?>
					<td class="col-md-2">
					<span class="label label-info"><?php echo $activenamedp; ?> </span> 
					<!--
					<td class="col-md-1">
					<span style=" display:inline!important" class="label label-warning"><?php echo $stime." ".$etime;?> </span>
					</td>
					-->
					</td>
					<?php
					 echo '<td class="col-md-1"></td>';
					}
					} else {echo '<td></td><td></td>';}
					?>
					
					
					<td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="hidden" name="gpio_lock_update_from_status" value="<?php echo $s['gpio']; ?>"/>
						<input id="lockstatus" type="checkbox"  data-toggle="toggle" data-size="mini" data-on="lock" data-off="lock" onchange="this.form.submit()" name="lock_update_from_status" value="<?php echo $g['locked'] == 'user'  ? '' : 'user'; ?>" <?php echo $g['locked'] == 'user' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="rom_lock" value="<?php echo $s['rom']; ?>"/>
						<input type="hidden" name="update_from_status" value="lock_update_from_status" />
					</form>
					</td>

					<?php } 
	
				}
				
				/* TIME IP */
				elseif ($g['mode']=='time' && !empty($s['ip'])) {
				
					?>
					<td class="col-md-1">
					 <?php
						exec('/usr/local/bin/gpio -g read '.$g['gpio'], $state);
						$set=$state[0];
						if ($g['rev']=='on'){
							
							if ($set==1){$set=0;
							
							} else {$set=1;}
						}
					?>	
                   	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input id="onoffstatus" type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="<?php echo $s['tmp'] == '1.0'  ? 'off' : 'on'; ?>" <?php echo $s['tmp'] == '1.0' ? 'checked="checked"' : ''; ?>  />
                        <input type="hidden" name="ip" value="<?php echo $s['ip']; ?>"/>
						<input type="hidden" name="rev" value="<?php echo $g['rev']; ?>"/>
                        <input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
                        <input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
						<input type="hidden" name="time_offset" value="<?php echo $g['time_offset']; ?>"/>
                        <input type="hidden" name="trun" value="timerunip" />
                    </form>
                    </td>
                    <?php 
                    unset($set);
                    unset($state);
					?>
					
					<td style="vertical-align:middle">
						Mins:
					</td>
					
					<td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="number" style="width: 4em;" onchange="this.form.submit()" name="value_update_from_status" value="<?php echo $g['time_offset'] ?>" />
						<input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
                        <input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
						<input type="hidden" name="update_from_status" value="time_update_from_status" />
					</form>
					</td>
					
					<td>
					<?php
					if (substr($g['status'],0,2) == 'ON') {
					?>
						<span class="label <?php echo label($g['status']) ?>"> <?php echo str_replace("ON","",str_replace("min","",$g['status'])).min ?> </span>
					</td>
					<?php 
					}
				
				}
				/* TIME */
				elseif ($g['mode']=='time') {
				
					?>
					<td class="col-md-1">
					 <?php
						exec('/usr/local/bin/gpio -g read '.$g['gpio'], $state);
						$set=$state[0];
						if ($g['rev']=='on'){
							
							if ($set==1){$set=0;
							
							} else {$set=1;}
						}
					?>	
                   	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input id="onoffstatus" type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="on" <?php echo $set == '1' ? 'checked="checked"' : ''; ?>  />
                        <input type="hidden" name="rev" value="<?php echo $g['rev']; ?>"/>
                        <input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
                        <input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
						<input type="hidden" name="time_offset" value="<?php echo $g['time_offset']; ?>"/>
                        <input type="hidden" name="trun" value="timerun" />
                    </form>
                    </td>
                    <?php 
                    unset($set);
                    unset($state);
					?>
					<td style="vertical-align:middle">
						Mins:
					</td>
					<td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="number" style="width: 4em;" onchange="this.form.submit()" name="value_update_from_status" value="<?php echo $g['time_offset'] ?>" />
						<input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
                        <input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
						<input type="hidden" name="update_from_status" value="time_update_from_status" />
					</form>
					</td>
					
					<td>
					<?php
					if (substr($g['status'],0,2) == 'ON') {
					?>
						<span class="label <?php echo label($g['status']) ?>"> <?php echo str_replace("ON","",str_replace("min","",$g['status'])).min ?> </span>
					</td>
					<?php 
					}
												
					} 
	
				/* MOMENT IP*/
				elseif($g['mode']=='moment'&&!empty($s['ip'])) {
					?>
					<td class="col-md-1">
                   	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input id="onoffstatus" data-onstyle="default" type="checkbox" data-size="mini" data-toggle="toggle" name="bi" value="on" onchange="this.form.submit()" title=""   onclick="this.form.submit()" />
						<input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
                        <input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
						<input type="hidden" name="rev" value="<?php echo $g['rev']; ?>"/>
						<input type="hidden" name="ip" value="<?php echo $s['ip']; ?>"/>
						<input type="hidden" name="onoff" value="momentip" />
						<input type="hidden" name="moment_time" value="<?php echo $g['moment_time']; ?>" />    
                    </form>
                    </td>
                    <td></td><td></td><td></td>
				<?php
				}
				/* MOMENT */
				elseif($g['mode']=='moment') {
					?>
					<td class="col-md-1">
                   	<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input id="onoffstatus" data-onstyle="default" type="checkbox" data-size="mini" data-toggle="toggle" name="bi" value="on" onchange="this.form.submit()" title=""   onclick="this.form.submit()" />
						<input type="hidden" name="gpio" value="<?php echo $s['gpio']; ?>"/>
						<input type="hidden" name="rom" value="<?php echo $s['rom']; ?>"/>
						<input type="hidden" name="rev" value="<?php echo $g['rev']; ?>"/>
						<input type="hidden" name="onoff" value="bi" />
						<input type="hidden" name="moment_time" value="<?php echo $g['moment_time']; ?>" />    
                    </form>
                    </td>
                    <td></td><td></td><td></td>
				<?php
				}
				/* READ */
				elseif($g['mode']=='read') {
					?>
					<td class="col-md-1">
                   <?php
						exec('/usr/local/bin/gpio -g read '.$g['gpio'], $state);
					?>
					<input type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="" <?php echo $state[0] == '1' ? 'checked="checked"' : ''; unset($state); ?> disabled="disabled" />

                    </td>
                    <td></td><td></td><td></td>
				<?php
				}
				/*READ IP */
				elseif($g['mode']=='simple'&&!empty($ip)) {
					?>
					<td class="col-md-1">
						<input type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="switch" value="<?php echo $s['tmp'] == '1.0'  ? 'off' : 'on'; ?>" <?php echo $s['tmp'] == '1.0' ? 'checked="checked"' : ''; ?>  disabled="disabled" />
                    </td>
                    <td></td><td></td><td></td>
				<?php
				}
				/* TEMP */
				if($g['mode']=='temp') {
					/* TEMP */
					$sth = $db->prepare("SELECT id,value FROM g_func WHERE gpio='$s[gpio]' AND active='on' AND rom='$s[rom]' ORDER BY position ASC LIMIT 1 ");
					$sth->execute();
					$g_func = $sth->fetchAll();
					$numRows = count($g_func);
					$gpio_locked=$g['locked'];
			if ( $numRows > '0' ) {
					foreach ($g_func as $gf) {
					?>
					<td style="vertical-align:middle">
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
						<input id="lockstatus" type="checkbox"  data-toggle="toggle" data-size="mini" data-on="lock" data-off="lock" onchange="this.form.submit()" name="lock_update_from_status" value="<?php echo $g['locked'] == 'user'  ? '' : 'user'; ?>" <?php echo $g['locked'] == 'user' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="rom_lock" value="<?php echo $s['rom']; ?>"/>
						<input type="hidden" name="update_from_status" value="lock_update_from_status" />
					</form>
					</td>
					<?php
					} 
			}else {
					?>
					<td style="vertical-align:middle">
						Value:
					</td>
					<td class="col-md-2">
					<span class="label label-warning">NO DP</span>
					</td>
					
					<td>
					<form class="form-horizontal" action="" method="post" style=" display:inline!important;">
						<input type="hidden" name="gpio_lock_update_from_status" value="<?php echo $s['gpio']; ?>"/>
						<input id="lockstatus" type="checkbox"  data-toggle="toggle" data-size="mini" data-on="lock" data-off="lock" onchange="this.form.submit()" name="lock_update_from_status" value="<?php echo $g['locked'] == 'user'  ? '' : 'user'; ?>" <?php echo $g['locked'] == 'user' ? 'checked="checked"' : ''; ?>  />
						<input type="hidden" name="rom_lock" value="<?php echo $s['rom']; ?>"/>
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
				<a href="index.php?id=view&type=gpio&max=day&single=<?php echo $r['name']?>" class="label label-default" title=""><?php echo $r['name']?></a>
			</td>
			<td>
				<input id="onoffstatus" type="checkbox"  data-toggle="toggle" data-size="mini" onchange="this.form.submit()" name="relay" value="<?php echo $o == 'on'  ? 'off' : 'on'; ?>" <?php echo $o == 'on' ? 'checked="checked"' : ''; ?>  />
				<input type="hidden" name="ip" value="<?php echo $r['ip']; ?>"/>
				<input type="hidden" name="rom" value="<?php echo $r['rom']; ?>"/>
				<input type="hidden" name="gpio_post" value="<?php echo $r['gpio']; ?>"/>
				<input type="hidden" name="ronoff" value="ronoff" />
			</td>
			<td></td><td></td><td></td>
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



