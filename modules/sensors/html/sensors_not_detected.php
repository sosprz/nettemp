<span class="belka">&nbsp No sensors detected:<span class="okno"><table><tr>	
			
	 <?php 
	//$db = new SQLite3('dbf/nettemp.db');
	//$db->exec("SELECT rom FROM sensors");
	//while ($a = $r->fetchArray()) {
	$sth = $db1->prepare("SELECT rom FROM sensors");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) { 		
		
		
	$array20[]=$a["rom"];
	}	 
	
	//print_r($file_expl_array2);
	foreach($array20 as $rom_no){
	   if (!in_array($rom_no, $digitemprc)){ ?>
	   <table>	
	   <tr>
	   <?php $del_empty_array[]=$rom_no; ?>
	   <form action="sensors" method="post">
	   <td><img src="media/ico/TO-220-icon.png" />&nbsp</td>
	 	<td><?php echo $rom_no;?></td>
		<input type="hidden" name="usun_nw" value="<?php echo "$rom_no"; ?>" />
		<input type="hidden" name="usun_nw2" value="usun_nw3" />
      <td><input type="image" src="media/ico/Close-2-icon.png" />
      </form></td></tr>
      
  		<?php	
		}
			}	if (empty($del_empty_array)) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }  
			
			?>
			</table>
			</span></span>	