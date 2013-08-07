<span class="belka">&nbsp RRD<span class="okno">
<table> 
<?php
include("modules/login/login_check.php");

$arrayFiles=glob('img/view1/*');
if($arrayFiles){
  foreach ($arrayFiles as $filename) { ?>
<table> <tr><td>
<img src="<?php echo $filename; ?>" />
</td></tr>
<?php
 }} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>
</table>
</span></span>	
