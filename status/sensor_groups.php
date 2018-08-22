<?php
session_start();

if (isset($_GET['ch_g'])) { 
    $ch_g = $_GET['ch_g'];
} 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");

//hide
	$hidegroup = isset($_POST['hidegroup']) ? $_POST['hidegroup'] : '';
	$hideg = isset($_POST['hideg']) ? $_POST['hideg'] : '';
	$hidegstate = isset($_POST['hidegstate']) ? $_POST['hidegstate'] : '';
	
	if (!empty($hidegroup) && $hidegroup == 'hidegroup'){
		if ($hidegstate == 'on') {$hidegstate = 'off';
		}elseif ($hidegstate == 'off') {$hidegstate = 'on';}
		
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE sensors SET ghide='$hidegstate' WHERE ch_group='$hideg'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();

$hide = $db->query("SELECT ghide FROM sensors WHERE ch_group='$ch_g' LIMIT 1");
$hide_res = $hide->fetchAll();
foreach ($hide_res as $h) {
    $hide=$h['ghide'];
}

$rows_meteo = $db->query("SELECT normalized,pressure FROM meteo WHERE id='1'");
$row_meteo = $rows_meteo->fetchAll();
foreach ($row_meteo as $a) {
    $normalized=$a['normalized'];
	$pressure=$a['pressure'];
}

	if(($_SESSION["perms"] == 'adm') || (isset($_SESSION["user"]))) {

		$sth = $db->prepare("SELECT * FROM sensors WHERE hide ='off' AND ch_group='$ch_g' AND type!='gpio' AND type!='elec' AND type!='water' AND type!='gas' AND ch_group!='switch' AND ch_group!='relay' AND (jg!='on' OR jg is null) ORDER BY position ASC");
	} else {
		
		$sth = $db->prepare("SELECT * FROM sensors WHERE hide ='off' AND ch_group='$ch_g' AND type!='gpio' AND type!='elec' AND type!='water' AND type!='gas' AND ch_group!='switch' AND ch_group!='relay' AND logon =='on' AND (jg!='on' OR jg is null) ORDER BY position ASC");
	}
	
	$gname = str_replace('_', ' ', $ch_g);
	$gname2 = '<a href="index.php?id=device&type=device&device_group='.$ch_g.'&device_menu=settings" title="Go to group settings" class="text-muted" >'.$ch_g.'</a>';

    $sth->execute();
    $result = $sth->fetchAll(); 
    $numsen = count($result);
    if ($numsen >= 1 ){
    ?>
    <div class="grid-item sg<?php echo $ch_g ?>">
	<div class="panel panel-default">
	<div class="panel-heading">
	
		<div class="pull-left">
		<?php
		if(isset($_SESSION['user'])){
						echo str_replace("_", " ", $gname2);
					} else {
						echo str_replace("_", " ", $gname);
					}
		
		
		 //echo $gname;
		 ?></div>
		<div class="pull-right">
		<div class="text-right">
			 <form action="" method="post" style="display:inline!important;">
					<input type="hidden" name="hideg" value="<?php echo $ch_g; ?>" />
					<input type="hidden" name="hidegstate" value="<?php echo $hide; ?>" />
					<input type="hidden" name="hidegroup" value="hidegroup"/>
					<?php
					if($hide =='off'){ ?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-top"></span> </button>
					<?php } elseif($hide =='on'){?>
					<button class="hidearrow"><span class="glyphicon glyphicon-triangle-bottom"></span> </button>
					<?php } ?>
				</form>	
		</div>
  </div>
  <div class="clearfix"></div>
	</div>
    <table class="table table-hover table-condensed">
    <tbody>
<?php

if ($hide == 'off') {
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
	$bindsensor=$a['bindsensor'];

	
		foreach($result_t as $ty){
       	if($ty['type']==$a['type']){
     			if($nts_temp_scale == 'F'){
       			$unit=$ty['unit2'];
       		} else {
				
				if (substr($a['type'],0,3) == 'max'){
					
					$val = $db->query("SELECT type FROM sensors WHERE rom='$bindsensor'") or die('virtual max type error');
					$val = $val->fetch(); 
					$local_tp = $val['type'];
					
					$unit2 = $db->query("SELECT unit FROM types WHERE type='$local_tp'") or die('virtual max type error');
					$unit2 = $unit2->fetch(); 
					$unit = $unit2['unit'];
					
				} else {
				$unit=$ty['unit'];
				}
			}
				$type="<img src=\"".$ty['ico']."\" alt=\"\" title=\"".$ty['title']."\"/>";
       	   
			}
		}
		
		$name2='<span class="label label-default" title="'.$a['name'].'">'.$a['name'].'</span>';
		$name3='<a href="index.php?id=device&device_id='.$a['id'].'" title="Go to settings" class="label label-default">'.$a['name'].'</a>';

		if($a['tmp'] > $a['tmp_5ago']) { $updo='<span class="label label-danger" title="5 min stats '.$a['tmp_5ago'].' '.$unit.'"><span class="glyphicon glyphicon-arrow-up"></span></span>';}
		if($a['tmp'] < $a['tmp_5ago']) { $updo='<span class="label label-info" title="5 min stats '.$a['tmp_5ago'].' '.$unit.'"><span class="glyphicon glyphicon-arrow-down"></span></span>';}
		
		if($a['stat_min']) { $stat_min='<span class="label label-info" title="Lowest value from sensor '.$unit.'">'.number_format($a['stat_min'], 1, '.', ',').'</span>';}
		if($a['stat_max']) { $stat_max='<span class="label label-warning" title="Greatest value from sensor '.$unit.'">'.number_format($a['stat_max'], 1, '.', ',').'</span>';}
		

		
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
		if(!empty($a['mail']) || !empty($a['readerrsend']) ) {$mail='<img src="media/ico/message-icon.png" alt="" title="Message was send!"/>';}
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
						if (strtotime($a['time'])<(time()-($a['readerr']*60)) && !empty($a['readerr'])){
							echo 'class="label label-warning"';
						}else { 
								echo "class=\"label ".$a['trigoneclr']."\"";
						}
						
						}elseif ($a['type']=='trigger' && $a['tmp'] == '0.0') {
						if (strtotime($a['time'])<(time()-($a['readerr']*60)) && !empty($a['readerr'])){
							echo 'class="label label-warning"';
						}else { 
								echo "class=\"label ".$a['trigzeroclr']."\"";
						}
						}
				
				    if (($a['tmp'] == 'error') || ($a['status'] == 'error') || ($label=='danger')){
					echo 'class="label label-danger"';
				    } elseif (strtotime($a['time'])<(time()-($a['readerr']*60)) && !empty($a['readerr'])){
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
					elseif (is_numeric($a['tmp']) && $a['type']=='sunrise' || $a['type']=='sunset')  {
						echo    date('H:i', $a['tmp'])." ".$unit." ".$max." ".$min;
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
					<td><img src="media/ico/pressurenorm.png" alt="Pressure"></td>
					<td><?php 
					$pressnorm = '<span class="label label-default" title="'.$a['name'].'">'.$a['name'].' npm'.'</span>';
					echo str_replace("_", " ", $pressnorm);
					 ?></td>
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
						echo number_format($m->getCisnienieZnormalizowane(),2,'.','').' hPa';
						?>
					</span>
					</td>
					<td>
						<?php if (substr($a['type'],0,3) != 'max' || substr($a['type'],0,3) != 'sun'){echo $updo;} ?>
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
