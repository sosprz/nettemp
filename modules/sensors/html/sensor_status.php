          <div class="panel panel-default">
            <div class="panel-heading">Sensors</div>
<?php
$dbl=$_SERVER["DOCUMENT_ROOT"]."dbf/nettemp.db";
$db = new PDO("sqlite:$dbl");
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { ?>
<div class="panel-body">
Go to device scan!
<a href="index.php?id=devices&type=scan" class="btn btn-success">GO!</a>
</div>
<?php 
    }

    $sth = $db->prepare("select * from sensors");
    $sth->execute();
    $result = $sth->fetchAll(); ?>
    <table class="table table-striped"> 
    <tbody>
<?php       
    foreach ($result as $a) {
	$name1=$a['name'];
	$name = str_replace("_", " ", $name1);
 	
	if($a['type'] == 'temp'){ 
		
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></td>
		    <td><img src="media/ico/temp_high.png" /></td>
		    <td><font color="#FF0000"> <?php echo $name ?></font></td>
		    <td><font color="#FF0000"><?php echo $a['tmp']; echo " C "; echo "max:"; echo $a['tmp_max'];?> &#176;C</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></td>
		    <td><img src="media/ico/temp_low.png" /></td>
		    <td><font color="#0095FF"> <?php echo $name ?></td>
		    <td><font color="#0095FF"><?php echo $a['tmp']; echo " C "; echo "min:"; echo $a['tmp_min'];?> &#176;C</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		else { ?> 
		<tr>
		    <td><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></td>
		    <td><img src="media/ico/temp2-icon.png" /></td>
		    <td><?php echo $name ?> </td>
		    <td><?php echo $a['tmp'];?> &#176;C</td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr></font> 
		<?php }
	}
	if($a['type'] == 'snmp'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td></td>
		    <td><img src="media/ico/temp_high.png" /></td>
		    <td><font color="#FF0000"> <?php echo $name ?></td>
		    <td><font color="#FF0000"><?php echo $a['tmp'];echo " C "; echo "max:"; $a['tmp_max'];?> &#176;C</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td></td>
		    <td><img src="media/ico/temp_low.png" /></td>
		    <td><font color="#0095FF"> <?php echo $name ?></td>
		    <td><font color="#0095FF"><?php echo $a['tmp']; echo " C "; echo "min:"; $a['tmp_min'];?> &#176;C</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		else { ?> 
		<tr>
		    <td></td>
		    <td><img src="media/ico/temp2-icon.png" /></td>
		    <td><?php echo $name ?> </td>
		    <td><?php echo $a['tmp'];?> &#176;C</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr> 
		<?php }
	}
	if($a['type'] == 'humid'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?>
		<tr class="danger">
		    <td><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></td>
		    <td><img src="media/ico/rain-icon.png" /></td>
		    <td><font color="#FF0000"> <?php echo $name ?></td>
		    <td><font color="#FF0000"><?php echo $a['tmp']; echo " % "; echo "max:"; echo $a['tmp_max'];?>&nbsp%</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?>
		<tr class="danger">
		    <td><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></td>
		    <td><img src="media/ico/rain-icon.png" /></td>
		    <td><font color="#0095FF"> <?php echo $name ?></td>
		    <td><font color="#0095FF"><?php echo $a['tmp']; echo " % "; echo "min:"; echo $a['tmp_min'];?>&nbsp%</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>  
		<?php	}
		else { ?> <tr>
		    <td><?php if($a['device'] == 'wireless'){ ?><img src="media/ico/wifi-circle-icon.png" /><?php } ?></td>
		    <td><img src="media/ico/rain-icon.png" />		    </td>
		    <td><?php echo $name ?> </td>
		    <td><?php echo $a['tmp'];?>&nbsp %</td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr></font> 
		<?php }
	}
	if($a['type'] == 'press'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td></td>
		    <td><img src="media/ico/Science-Pressure-icon.png" /></td>
		    <td><font color="#FF0000"> <?php echo $name ?></font></td>
		    <td><font color="#FF0000"><?php echo $a['tmp']; echo " Pa "; echo "max:"; echo $a['tmp_max'];?>&nbspPa</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td></td>
		    <td><img src="media/ico/Science-Pressure-icon.png" /></td>
		    <td><font color="#0095FF"> <?php echo $name ?></font></td>
		    <td><font color="#0095FF"><?php echo $a['tmp']; echo " Pa "; echo "min:"; echo $a['tmp_min'];?>&nbspPa</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>  <?php	}
		else { ?> 
		<tr>
		    <td></td>
		    <td><img src="media/ico/Science-Pressure-icon.png" /></td>
		    <td><?php echo $name?></font> </td>
		    <td><?php echo $a['tmp'];?>&nbspPa</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr> 
		<?php }
	}
	if($a['type'] == 'altitude'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> <tr><td></td><td><img src="media/ico/paper-plane-icon.png" /></td><td><font color="#FF0000"> <?php echo $name ?></td><td><font color="#FF0000"><?php echo $a['tmp']; echo " m "; "max:"; echo $a['tmp_max'];?>&nbspm</font></td></tr><?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> <tr><td></td><td><img src="media/ico/paper-plane-icon.png" /></td><td><font color="#0095FF"> <?php echo $name ?></td><td><font color="#0095FF"><?php echo $a['tmp']; echo " m "; echo "min:"; echo $a['tmp_min'];?>&nbspm</font></td></tr>  <?php	}
		else { ?> <tr><td><img src="media/ico/paper-plane-icon.png" /></td><td><font  color="#108218"> <?php echo $name ?> </td><td><font  color="#108218"> <?php echo $a['tmp'];?>&nbspm</td></tr></font> <?php }
	}
	if($a['type'] == 'lux'){
		if($a['tmp'] >= $a['tmp_max'] && !empty($a['tmp']) && !empty($a['tmp_max']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td></td>
		    <td><img src="media/ico/sun-icon.png" /></td>
		    <td><font color="#FF0000"> <?php echo $name ?></td>
		    <td><font color="#FF0000"><?php echo $a['tmp']; echo " lux "; echo "max:"; echo $a['tmp_max'];?>&nbsplux</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>
		<?php	}
		elseif($a['tmp'] <= $a['tmp_min'] && !empty($a['tmp']) && !empty($a['tmp_min']) && $a['alarm'] == on ) { ?> 
		<tr class="danger">
		    <td></td>
		    <td><img src="media/ico/sun-icon.png" /></td>
		    <td><font color="#0095FF"> <?php echo $name ?></td>
		    <td><font color="#0095FF"><?php echo $a['tmp']; echo " lux "; echo "min:"; echo $a['tmp_min'];?>&nbsplux</font></td>
		    <td><?php if($a['tmp'] > $a['tmp_5ago']) { ?><img src="media/ico/Up-3-icon.png" /><?php } elseif($a['tmp'] < $a['tmp_5ago']){?><img src="media/ico/Down-3-icon.png" /><?php } ?></td>
		</tr>  <?php	}
		else { ?>  
		    <tr>
			<td></td>
			<td><img src="media/ico/sun-icon.png" /></td>
			<td><font  color="#108218"> <?php echo $name ?> </td>
			<td><font  color="#108218"> <?php echo $a['tmp'];?>&nbsplux</td>
			<td></td
		    </tr>
	    </font> <?php }
	}
	

    } ?>
    </tbody>
    </table> <?php
?>
          </div>
