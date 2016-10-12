<div class="panel panel-default">
<div class="panel-heading">New devices</div>
<div class="table-responsive">
<table class="table table-hover table-condensed small"><tr>	
<thead><tr><th>id</th><th></th></tr></thead>
	<?php	
	$db = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db->prepare("SELECT rom FROM sensors");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) { 
	$file_expl_array2[]=$a["rom"];	
	}
	$sth2 = $db->prepare("SELECT rom FROM relays");
	$sth2->execute();
	$result = $sth2->fetchAll();
	foreach ($result as $a) { 
	$file_expl_array2[]=$a["rom"];	
	}
	
	$sth3 = $db->prepare("SELECT rom FROM heaters");
	$sth3->execute();
	$result = $sth2->fetchAll();
	foreach ($result as $a) { 
	$file_expl_array2[]=$a["rom"];	
	}
	
	foreach ($digitemprc as $rom_new) { ?>
	<?php 
	$trim_rom_new=trim($rom_new);
	if (!in_array($trim_rom_new, $file_expl_array2)) { 
        $new_empty_array[]=$trim_rom_new;
	?>
    <td class="col-md-2"><img src="media/ico/TO-220-icon.png" /><?php echo $trim_rom_new; ?></td>
    <td class="col-md-2">
    <form action="" method="post" style="display:inline!important;">
	<input type="hidden" name="id_rom_new" value="<?php echo "$trim_rom_new"; ?>" > 
	<input type="hidden" name="name_new" value="nowy_czujnik" />
	<input type="hidden" name="button" value="Add to base" />
       <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button>
    </form>
    </td>
</tr>    
<?php 
} 					
}
?>
</table>
</div>
</div>




<div class="panel panel-default">
<div class="panel-heading">Not detected</div>

<table class="table table-striped table-condensed small">
<thead><tr><th>id</th><th></th></tr></thead>

     <?php 
    $sth = $db->prepare("SELECT rom FROM sensors WHERE rom NOT LIKE 'remote_%'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) { 		
    $array20[]=$a["rom"];
    }
    $sth = $db->prepare("SELECT rom FROM relays");
    $sth2->execute();
    $result2 = $sth->fetchAll();
    foreach ($result2 as $a) { 		
    $array20[]=$a["rom"];
    }	 
    
    foreach($array20 as $rom_no){
	   if (!in_array($rom_no, $digitemprc)){
	    $del_empty_array[]=$rom_no; 
    ?>
    <tr>
	<td class="col-md-2"><img src="media/ico/TO-220-icon.png" /><?php echo $rom_no;?></td>
	<td class="col-md-2">
	<form action="" method="post">
	    <input type="hidden" name="usun_nw" value="<?php echo "$rom_no"; ?>" />
	    <input type="hidden" name="usun_nw2" value="usun_nw3" />
    	    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
	</form>
	</td>
    </tr>
      
	<?php	
	}
	    }	//if (empty($del_empty_array)) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }  
	    
?>
</table>
</div>

