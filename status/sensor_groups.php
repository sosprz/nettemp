<?php
session_start();

if (isset($_GET['ch_g'])) { 
    $ch_g = $_GET['ch_g'];
} 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();

$rows_meteo = $db->query("SELECT normalized,pressure FROM meteo WHERE id='1'");
$row_meteo = $rows_meteo->fetchAll();
foreach ($row_meteo as $a) {
    $normalized=$a['normalized'];
	$pressure=$a['pressure'];
}

	if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {

		$sth = $db->prepare("SELECT * FROM sensors WHERE position !=0 AND ch_group='$ch_g' AND type!='gpio' AND type!='elec' AND type!='water' AND type!='gas' AND ch_group!='switch' AND ch_group!='relay' AND (jg!='on' OR jg is null) ORDER BY position ASC");
	} else {
		
		$sth = $db->prepare("SELECT * FROM sensors WHERE position !=0 AND ch_group='$ch_g' AND type!='gpio' AND type!='elec' AND type!='water' AND type!='gas' AND ch_group!='switch' AND ch_group!='relay' AND logon =='on' AND (jg!='on' OR jg is null) ORDER BY position ASC");
	}
	
	$gname = str_replace('_', ' ', $ch_g);

    $sth->execute();
    $result = $sth->fetchAll(); 
    $numsen = count($result);
    if ($numsen >= 1 ){
    ?>
    <div class="grid-item sg<?php echo $ch_g ?>">
	<div class="panel panel-default">
	<div class="panel-heading"><?php echo $gname; ?></div>
    <table class="table table-hover table-condensed">
    <tbody>
<?php
    foreach ($result as $a) {
	$name1=$a['name'];
	$name = str_replace("_", " ", $name1);
	$min='';
	$max='';
	$label='';
	$updo='';
	$mm='';
	$device='';
	$type='';
	$mail='';
	$stat_min='';
	$stat_max='';

		if($a['device'] == 'wireless'){ $device='<img src="media/ico/wifi-circle-icon.png" alt="" title="'.$a['ip'].'"/>';}
		elseif($a['device'] == 'remote'||$a['device'] == 'ip'){ $device='<img src="media/ico/remote.png" alt="" title="'.$a['ip'].'"/>';}
		elseif($a['device'] == 'usb'){ $device='<img src="media/ico/usb-icon.png" alt="" title="USB"/>';}
		elseif($a['device'] == 'rpi'){ $device='<img src="media/ico/raspberry-icon.png" alt="" title="Raspberry Pi"/>';}
		elseif($a['device'] == 'banana'){ $device='<img src="media/ico/banana-icon.png" alt="" title="Banana Pi"/>';}
		elseif($a['device'] == 'gpio'){ $device='<img src="media/ico/gpio2.png" alt="" title="GPIO"/>';}
		elseif($a['device'] == 'i2c'||$a['device'] == 'lmsensors'){ $device='<img src="media/ico/i2c_1.png" alt="" title="I2C"/>';}
		elseif($a['device'] == 'snmp'){ $device='<img src="media/ico/snmp-icon.png" alt="" title=SNMP"/>';}
		elseif($a['device'] == '1wire'||$a['device'] == 'owfs'){ $device='<img src="media/ico/1wire.png" alt="" title="1wire"/>';}

		
		
		foreach($result_t as $ty){
       	if($ty['type']==$a['type']){
     			if($nts_temp_scale == 'F'){
       			$unit=$ty['unit2'];
       		} else {
       			$unit=$ty['unit'];
       		}
       		$type="<img src=\"".$ty['ico']."\" alt=\"\" title=\"".$ty['title']."\"/>";
       	}   
		}
		
		$name2='<span class="label label-default" title="'.$a['name'].'">'.$a['name'].'</span>';
		$name3='<a href="index.php?id=device&device_id='.$a['id'].'" title="Go to settings" class="label label-default">'.$a['name'].'</a>';

		if($a['tmp'] > $a['tmp_5ago']) { $updo='<span class="label label-danger" title="5 min stats '.$a['tmp_5ago'].' '.$unit.'"><span class="glyphicon glyphicon-arrow-up"></span></span>';}
		if($a['tmp'] < $a['tmp_5ago']) { $updo='<span class="label label-info" title="5 min stats '.$a['tmp_5ago'].' '.$unit.'"><span class="glyphicon glyphicon-arrow-down"></span></span>';}
		
		if($a['stat_min']) { $stat_min='<span class="label label-info" title="Lowest value from sensor '.$unit.'">'.$a['stat_min'].'</span>';}
		if($a['stat_max']) { $stat_max='<span class="label label-warning" title="Greatest value form sensor '.$unit.'">'.$a['stat_max'].'</span>';}
		

		
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max'])) { 
		    $mm='e'; 
		    $max="max ".$a['tmp_max'];
		    if($a['type'] == 'temp'){ $type='<img src="media/ico/temp_high.png" alt=""/>';}
		    $label='danger';
		}
		if($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min'])) { 
		    $mm='e'; 
		    $min="min ".$a['tmp_min'];
		    if($a['type'] == 'temp'){ $type='<img src="media/ico/temp_low.png" alt=""/>';}
		    $label='danger';
		}
		if(!empty($a['mail'])) {$mail='<img src="media/ico/message-icon.png" alt="" title="Message was send!"/>';}
?>

		    <tr>
			<td>
				<?php echo $type;?>
			</td>
			<td>
				<?php 
					if(isset($_SESSION['user'])){
						echo str_replace("_", " ", $name3);
					} else {
						echo str_replace("_", " ", $name2);
					}
				?>
			</td>
			<td>
			    <a href="index.php?id=view&type=<?php echo $a['type']?>&max=<?php echo $_SESSION['nts_charts_max']; ?>&single=<?php echo $a['name']?>" title="Go to charts, last update: <?php echo $a['time']?>"
				<?php 
				
				
					if ($a['type']=='trigger' && $a['tmp'] == '1.0') {
						
						echo "class=\"label ".$a['trigoneclr']."\"";
						}elseif ($a['type']=='trigger' && $a['tmp'] == '0.0') {
							echo "class=\"label ".$a['trigzeroclr']."\"";
						}
				
				    if (($a['tmp'] == 'error') || ($a['status'] == 'error') || ($label=='danger')){
					echo 'class="label label-danger"';
				    } elseif (strtotime($a['time'])<(time()-($a['readerr']*60))){
					echo 'class="label label-warning"';
				    }else{
					echo 'class="label label-success"';
				    } ?>
				>
				<?php
				    if (is_numeric($a['tmp']) && $a['type']=='elec' || $a['type']=='gas' || $a['type']=='water' )  {
						echo 	number_format($a['tmp'], 3, '.', ',')." ".$unit." ".$max." ".$min;
				    } 
				    elseif (is_numeric($a['tmp']) && $a['type']=='volt' || $a['type']=='amps' || $a['type']=='watt' )  {
						echo 	number_format($a['tmp'], 2, '.', ',')." ".$unit." ".$max." ".$min;
				    } 
				    elseif ($a['type']=='relay' || $a['type']=='switch')  {
						if ( $a['tmp'] == '1.0') { 
							echo 'ON'; 
						} 
						elseif ( $a['tmp'] == '0.0') {
							echo 'OFF'; 
						}
						else {
							echo $a['tmp'];
						}
				    } 
					elseif ($a['type']=='trigger')  {
						if ( $a['tmp'] == '1.0' && $a['trigone']!='' ) { 
							echo $a['trigone']; 
						} 
						elseif ( $a['tmp'] == '0.0' && $a['trigzero']!='') {
							echo $a['trigzero'];
						}
						else {
							echo $a['tmp'];
						}
				    } 
				    elseif (is_numeric($a['tmp'])&&$a['status']!='error') { 
						echo 	number_format($a['tmp'], 1, '.', ',')." ".$unit." ".$max." ".$min;
				    }
				    elseif ($a['status']=='error') { 
						echo "offline";
				    }
				    else {
						echo $a['tmp']." ".$unit." ".$max." ".$min;
				    }
				?>	
			    </a>
			   
			</td>
			<td>
				 <?php
					if($a['minmax']=='light') {
						echo $stat_min;
						echo $stat_max;
					}
					echo $updo; 
				?>
			</td>
			<td>
				<?php 
					echo $mail; 
				?>
			</td>
		    </tr>
			<?php if ($normalized == "on" && $pressure == $a['id']): ?>
				<tr>
					<td></td>
					<td><span 
				<?php if(($a['tmp'] == 'error') || ($label=='danger')) {
				    echo 'class="label label-danger"';
				    } 
				    else {
					echo 'class="label label-success"';
				    } 
					?>
					>
					<?php
						require_once("Meteo.class.php");
						$m=new Meteo();
						echo number_format($m->getCisnienieZnormalizowane(),2,'.','').' hPa npm';
						?>
					</span>
					</td>
					<td>
						<?php echo $updo; ?>
					</td>
					<td>
						<?php echo $mail; ?>
					</td>
				</tr>
			<?php endif; ?>
<?php
    unset($mm);
    unset($max);
    unset($min);
    unset($label);
    unset($updo);
    unset($device);
    unset($unit);
    unset($stat_min);
    unset($stat_max);
     } 
?>
    </tbody>
    </table> 
	</div>
	</div>
<?php 
	}
unset($ch_g);
?>
