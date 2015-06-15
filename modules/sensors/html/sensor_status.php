<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">Sensros</h3></div><div class="panel-body">
<?php
$dbl=$_SERVER["DOCUMENT_ROOT"]."dbf/nettemp.db";
$db = new PDO("sqlite:$dbl");
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { echo "<span class=\"empty\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
    $sth = $db->prepare("select * from sensors");
    $sth->execute();
    $result = $sth->fetchAll(); ?>
    <table> <?php       
    foreach ($result as $a) {
	$name1=$a['name'];
	$name = str_replace("_", " ", $name1);
 	
	if($a['type'] == 'temp'){ 
		
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/temp_high.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"> <?php echo $name ?></font></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"><?php echo $a['tmp']; echo " C "; echo "max:"; echo $a['tmp_max'];?> &#176;C</font></div>
		</div>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/temp_low.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"> <?php echo $name ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"><?php echo $a['tmp']; echo " C "; echo "min:"; echo $a['tmp_min'];?> &#176;C</font></div>
		</div>
		<?php	}
		else { ?> 
		<div class="row">
		    <div class="col-xs-1 col-sm-1 col-lg-1"><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></div>
		    <div class="col-xs-1 col-sm-1 col-lg-1"><img src="media/ico/temp2-icon.png" /></div>
		    <div class="col-xs-5 col-sm-4 col-lg-5"><font  color="#108218"> <?php echo $name ?> </div>
		    <div class="col-xs-3 col-sm-3 col-lg-3"><font  color="#108218"> <?php echo $a['tmp'];?> &#176;C</div>
		    <div class="col-xs-1 col-sm-1 col-lg-1"><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></div>
		</div></font> 
		<?php }
	}
	if($a['type'] == '1snmp'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/temp_high.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"> <?php echo $name ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"><?php echo $a['tmp'];echo " C "; echo "max:"; $a['tmp_max'];?> &#176;C</font></div>
		</div>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/temp_low.png" /></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"> <?php echo $name ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"><?php echo $a['tmp']; echo " C "; echo "min:"; $a['tmp_min'];?> &#176;C</font></div>
		</div>
		<?php	}
		else { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/temp2-icon.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font  color="#108218"> <?php echo $name ?> </div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font  color="#108218"> <?php echo $a['tmp'];?> &#176;C</font></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></div>
		</div> 
		<?php }
	}
	if($a['type'] == 'humid'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?>
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/rain-icon.png" /></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"> <?php echo $name ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"><?php echo $a['tmp']; echo " % "; echo "max:"; echo $a['tmp_max'];?>&nbsp%</font></div>
		</div>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?>
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/rain-icon.png" /></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"> <?php echo $name ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"><?php echo $a['tmp']; echo " % "; echo "min:"; echo $a['tmp_min'];?>&nbsp%</font></div>
		</div>  
		<?php	}
		else { ?> <div class="row">
		    <div class="col-xs-1 col-sm-1 col-lg-1"><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></div>
		    <div class="col-xs-1 col-sm-2 col-lg-1"><img src="media/ico/rain-icon.png" /></div>
		    <div class="col-xs-5 col-sm-4 col-lg-5"><font  color="#108218"> <?php echo $name ?> </div>
		    <div class="col-xs-3 col-sm-2 col-lg-3"><font  color="#108218"> <?php echo $a['tmp'];?>&nbsp %</div>
		    <div class="col-xs-1 col-sm-2 col-lg-1"><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></div>
		</div></font> 
		<?php }
	}
	if($a['type'] == 'press'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/Science-Pressure-icon.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"> <?php echo $name ?></font></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"><?php echo $a['tmp']; echo " Pa "; echo "max:"; echo $a['tmp_max'];?>&nbspPa</font></div>
		</div>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/Science-Pressure-icon.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"> <?php echo $name ?></font></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"><?php echo $a['tmp']; echo " Pa "; echo "min:"; echo $a['tmp_min'];?>&nbspPa</font></div>
		</div>  <?php	}
		else { ?> 
		<div class="row">
		    <div class="col-xs-1 col-sm-1 col-lg-1"></div>
		    <div class="col-xs-1 col-sm-1 col-lg-1"><img src="media/ico/Science-Pressure-icon.png" /></div>
		    <div class="col-xs-5 col-sm-5 col-lg-5"><font  color="#108218"> <?php echo $name?></font> </div>
		    <div class="col-xs-3 col-sm-3 col-lg-3"><font  color="#108218"> <?php echo $a['tmp'];?>&nbspPa</font></div>
		    <div class="col-xs-1 col-sm-1 col-lg-1"><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></div>
		</div> 
		<?php }
	}
	if($a['type'] == 'altitude'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> <div class="row"><div class="col-xs-2 col-sm-2 col-lg-2"></div><div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/paper-plane-icon.png" /></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"> <?php echo $name ?></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#FF0000"><?php echo $a['tmp']; echo " m "; "max:"; echo $a['tmp_max'];?>&nbspm</font></div></div><?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> <div class="row"><div class="col-xs-2 col-sm-2 col-lg-2"></div><div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/paper-plane-icon.png" /></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"> <?php echo $name ?></div><div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"><?php echo $a['tmp']; echo " m "; echo "min:"; echo $a['tmp_min'];?>&nbspm</font></div></div>  <?php	}
		else { ?> <div class="row"><div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/paper-plane-icon.png" /></div><div class="col-xs-2 col-sm-2 col-lg-2"><font  color="#108218"> <?php echo $name ?> </div><div class="col-xs-2 col-sm-2 col-lg-2"><font  color="#108218"> <?php echo $a['tmp'];?>&nbspm</div></div></font> <?php }
	}
	if($a['type'] == 'lux'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-1 col-sm-2 col-lg-2"><img src="media/ico/sun-icon.png" /></div>
		    <div class="col-xs-5 col-sm-2 col-lg-2"><font color="#FF0000"> <?php echo $name ?></div>
		    <div class="col-xs-3 col-sm-2 col-lg-2"><font color="#FF0000"><?php echo $a['tmp']; echo " lux "; echo "max:"; echo $a['tmp_max'];?>&nbsplux</font></div>
		</div>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<div class="row">
		    <div class="col-xs-2 col-sm-2 col-lg-2"><img src="media/ico/sun-icon.png" /></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"> <?php echo $name ?></div>
		    <div class="col-xs-2 col-sm-2 col-lg-2"><font color="#0095FF"><?php echo $a['tmp']; echo " lux "; echo "min:"; echo $a['tmp_min'];?>&nbsplux</font></div>
		</div>  <?php	}
		else { ?>  
		    <div class="row">
			<div class="col-xs-1 col-sm-1 col-lg-1"><img src="media/ico/sun-icon.png" /></div>
			<div class="col-xs-5 col-sm-5 col-lg-5"><font  color="#108218"> <?php echo $name ?> </div>
			<div class="col-xs-3 col-sm-3 col-lg-3"><font  color="#108218"> <?php echo $a['tmp'];?>&nbsplux</div>
		    </div>
	    </font> <?php }
	}
	

    } ?>
    </table> <?php
?>
</div>
</div>