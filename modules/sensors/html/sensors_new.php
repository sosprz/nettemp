<div class="panel panel-default">
<div class="panel-heading">New devices</div>
<div class="table-responsive">
<table class="table table-striped"><tr>	
<thead><tr><th></th><th>id</th><th>Add</th></tr></thead>
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
	
	foreach ($digitemprc as $rom_new) { ?>
	<?php 
	$trim_rom_new=trim($rom_new);
	if (!in_array($trim_rom_new, $file_expl_array2)) { ?>
   <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
   <?php $new_empty_array[]=$trim_rom_new; ?>
   <td><img src="media/ico/TO-220-icon.png" />&nbsp </td>
	<td><?php echo $trim_rom_new; ?></td>
	<input type="hidden" name="id_rom_new" value="<?php echo "$trim_rom_new"; ?>" > 
	<input type="hidden" name="name_new" value="nowy_czujnik" />
	<input type="hidden" name="button" value="Add to base" />
       <td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	</tr>    
    </form>
   <?php } 					
     	}
     	?>
     	</table>
</div>
</div>
<div class="panel panel-default">
            <div class="panel-heading">Not detected</div>

<table class="table table-striped">
<thead><tr><th></th><th>id</th><th>Rem</th></tr></thead>

     <?php 
    $sth = $db->prepare("SELECT rom FROM sensors");
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
	   if (!in_array($rom_no, $digitemprc)){ ?>


       
       <tr>
       <?php $del_empty_array[]=$rom_no; ?>
       <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
       <td><img src="media/ico/TO-220-icon.png" />&nbsp</td>
        <td><?php echo $rom_no;?></td>
	<input type="hidden" name="usun_nw" value="<?php echo "$rom_no"; ?>" />
	<input type="hidden" name="usun_nw2" value="usun_nw3" />
       <td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>

      </form>
    </tr>
      
	<?php	
	}
	    }	//if (empty($del_empty_array)) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }  
	    
	    ?>
</table>
</div>
</div>