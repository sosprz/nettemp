<span class="belka">&nbsp Graph:<span class="okno">
<table> 
<?php
session_start();
$arrayFiles=glob('img/view1/*');
if($arrayFiles){
  foreach ($arrayFiles as $filename) { ?>
<tr><td>
<span class="pasek_wykres"><table> <tr><td align="left">&nbsp</td>
<td align="right" width="980">
<?php	 
include("include/login_check.php");
if ($numRows1 == 1) { ?><form action="view" method="post">
<?php $zm2=substr($filename ,10,-4); ?>
<input type="hidden" name="del_rrd" value="<?php echo "$zm2"; ?>" />
<input type="hidden" name="del_graf" value="<?php echo "$filename"; ?>" />
<input type="hidden" name="del_graf1" value="del_graf2" />
<input type="image" src="media/ico/Close-icon.png" class="del_graf"  /></td></tr>
</form> 
<?php }; ?>
</table>
<img src="<?php echo $filename; ?>" />
</span>
</td></tr>
<?php
 }} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>
</table>
</span></span>	