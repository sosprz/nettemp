<span class="belka">&nbsp Status:<span class="okno"> 
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
    if($a[tmp] >= $a[tmp_max] && !empty($a[tmp]) && !empty($a[tmp_max]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/temp2-icon.png" /></td><td><font color="#FF0000"> <?php echo $a[name]; ?></td><td><font color="#FF0000"><?php echo "$a[tmp]C"; echo " max: $a[tmp_max]C"  ?> <img src="media/ico/temp_high.png" ></font></td></tr><?php	}
    elseif($a[tmp] <= $a[tmp_min] && !empty($a[tmp]) && !empty($a[tmp_min]) && $a[alarm] == on ) { ?> <tr><td><img src="media/ico/temp2-icon.png" /></td><td><font color="#0095FF"> <?php echo $a[name]; ?></td><td><font color="#0095FF"><?php echo "$a[tmp]C"; echo " min: $a[tmp_min]C" ?> <img src="media/ico/temp_low.png" ></font></td></tr>  <?php	}
    else { ?> <tr><td><img src="media/ico/temp2-icon.png" /></td><td><font  color="#108218"> <?php echo "$a[name]"; ?> </td><td><font  color="#108218"> <?php echo "$a[tmp]C ";?></td></tr></font> <?php }
    } ?>
    </table> <?php

?>
</span></span>
