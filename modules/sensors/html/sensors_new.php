<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">New sensors</h3>
            </div>
            <div class="panel-body">

<table class="table table-striped"><tr>	
<thead><tr><th>#</th><th>id</th><th>Add</th></tr></thead>
	<?php	
	$db = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db->prepare("SELECT rom FROM sensors");
	$sth->execute();
	$result = $sth->fetchAll();
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
    <td><input type="image" src="media/ico/Add-icon.png"  /></td>
	</tr>    
    </form>
   <?php } 					
     	}
     	if (empty($new_empty_array)) { 
     	echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>";
     	}
    
     	?>
     	</table>
</div></div>
<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Not detected</h3>
            </div>
            <div class="panel-body">

<table class="table table-striped">
<thead><tr><th>#</th><th>id</th><th>Rem</th></tr></thead>
     <?php 
    $sth = $db->prepare("SELECT rom FROM sensors");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) { 		
	
	
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
      <td><input type="image" src="media/ico/Close-2-icon.png" />
      </form></td></tr>
      
	<?php	
	}
	    }	//if (empty($del_empty_array)) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }  
	    
	    ?>
	    </table>
            </div>
          </div>
