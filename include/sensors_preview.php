<span class="belka">&nbsp Preview:<span class="okno">

<?php
$arrayFiles=glob('img/instant/*');
if($arrayFiles){
  foreach ($arrayFiles as $filename) { ?>

<span class="belka">
<table> <tr>
<td align="right" width="1000"><form action="sensors" method="post"></td>
<input type="hidden" name="del_graf" value="<?php echo "$filename"; ?>" />
<input type="hidden" name="del_graf1" value="del_graf2" />
<td><input type="image" src="media/ico/Close-icon.png" class="del_graf"  /></td>
</form></tr></table> 
		
				<img src="<?php echo $filename; ?>" />
	
</span>



<?php  }} else { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; } ?>
</span></span>	