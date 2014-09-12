<span class="belka">&nbsp Sensors status<span class="okno"> 

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors");
$row = $rows->fetchAll();
$numRows = count($row);
if ($numRows == 0 ) { echo "<span class=\"empty\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db1->prepare("select * from sensors");
    $sth->execute();
    $result = $sth->fetchAll(); ?>
    <table> <?php       
    foreach ($result as $a) { 	
	if($a[type] == temp){
		if($a[tmp] >= $a[tmp_max] && !empty($a[tmp]) && !empty($a[tmp_max]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/temp_high.png" /></td><td><font color="#FF0000"> <?php echo $a[name]; ?></td><td><font color="#FF0000"><?php echo "$a[tmp]C"; echo " max: $a[tmp_max]"?>&#176;C</font></td></tr><?php	}
		elseif($a[tmp] <= $a[tmp_min] && !empty($a[tmp]) && !empty($a[tmp_min]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/temp_low.png" /></td><td><font color="#0095FF"> <?php echo $a[name]; ?></td><td><font color="#0095FF"><?php echo "$a[tmp]C"; echo " min: $a[tmp_min]"?>&#176;C</font></td></tr>  <?php	}
		else { ?> <tr><td><img src="media/ico/temp2-icon.png" /></td><td><font  color="#108218"> <?php echo "$a[name]"; ?> </td><td><font  color="#108218"> <?php echo "$a[tmp]";?>&#176;C</td></tr></font> <?php }
	}
	if($a[type] == snmp){
		if($a[tmp] >= $a[tmp_max] && !empty($a[tmp]) && !empty($a[tmp_max]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/temp_high.png" /></td><td><font color="#FF0000"> <?php echo $a[name]; ?></td><td><font color="#FF0000"><?php echo "$a[tmp]C"; echo " max: $a[tmp_max]"?>&#176;C</font></td></tr><?php	}
		elseif($a[tmp] <= $a[tmp_min] && !empty($a[tmp]) && !empty($a[tmp_min]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/temp_low.png" /></td><td><font color="#0095FF"> <?php echo $a[name]; ?></td><td><font color="#0095FF"><?php echo "$a[tmp]C"; echo " min: $a[tmp_min]"?>&#176;C</font></td></tr>  <?php	}
		else { ?> <tr><td><img src="media/ico/temp2-icon.png" /></td><td><font  color="#108218"> <?php echo "$a[name]"; ?> </td><td><font  color="#108218"> <?php echo "$a[tmp]";?>&#176;C</td></tr></font> <?php }
	}
	if($a[type] == humi){
		if($a[tmp] >= $a[tmp_max] && !empty($a[tmp]) && !empty($a[tmp_max]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/rain-icon.png" /></td><td><font color="#FF0000"> <?php echo $a[name]; ?></td><td><font color="#FF0000"><?php echo "$a[tmp]%"; echo " max: $a[tmp_max]%"  ?></font></td></tr><?php	}
		elseif($a[tmp] <= $a[tmp_min] && !empty($a[tmp]) && !empty($a[tmp_min]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/rain-icon.png" /></td><td><font color="#0095FF"> <?php echo $a[name]; ?></td><td><font color="#0095FF"><?php echo "$a[tmp]%"; echo " min: $a[tmp_min]%" ?></font></td></tr>  <?php	}
		else { ?> <tr><td><img src="media/ico/rain-icon.png" /></td><td><font  color="#108218"> <?php echo "$a[name]"; ?> </td><td><font  color="#108218"> <?php echo "$a[tmp]% ";?></td></tr></font> <?php }
	}
	if($a[type] == pressure){
		if($a[tmp] >= $a[tmp_max] && !empty($a[tmp]) && !empty($a[tmp_max]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/Science-Pressure-icon.png" /></td><td><font color="#FF0000"> <?php echo $a[name]; ?></td><td><font color="#FF0000"><?php echo "$a[tmp]Pa"; echo " max: $a[tmp_max]Pa"  ?></font></td></tr><?php	}
		elseif($a[tmp] <= $a[tmp_min] && !empty($a[tmp]) && !empty($a[tmp_min]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/Science-Pressure-icon.png" /></td><td><font color="#0095FF"> <?php echo $a[name]; ?></td><td><font color="#0095FF"><?php echo "$a[tmp]Pa"; echo " min: $a[tmp_min]Pa" ?></font></td></tr>  <?php	}
		else { ?> <tr><td><img src="media/ico/Science-Pressure-icon.png" /></td><td><font  color="#108218"> <?php echo "$a[name]"; ?> </td><td><font  color="#108218"> <?php echo "$a[tmp]Pa ";?></td></tr></font> <?php }
	}
	if($a[type] == altitude){
		if($a[tmp] >= $a[tmp_max] && !empty($a[tmp]) && !empty($a[tmp_max]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/paper-plane-icon.png" /></td><td><font color="#FF0000"> <?php echo $a[name]; ?></td><td><font color="#FF0000"><?php echo "$a[tmp]m"; echo " max: $a[tmp_max]m"  ?></font></td></tr><?php	}
		elseif($a[tmp] <= $a[tmp_min] && !empty($a[tmp]) && !empty($a[tmp_min]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/paper-plane-icon.png" /></td><td><font color="#0095FF"> <?php echo $a[name]; ?></td><td><font color="#0095FF"><?php echo "$a[tmp]m"; echo " min: $a[tmp_min]m" ?></font></td></tr>  <?php	}
		else { ?> <tr><td><img src="media/ico/paper-plane-icon.png" /></td><td><font  color="#108218"> <?php echo "$a[name]"; ?> </td><td><font  color="#108218"> <?php echo "$a[tmp]m ";?></td></tr></font> <?php }
	}
	


    } ?>
    </table> <?php
?>
</span></span>
