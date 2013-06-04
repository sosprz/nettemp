<span class="belka">&nbsp Graphing<span class="okno">
<table> 
<?php
session_start();
$arrayFiles=glob('img/view1/*');
if($arrayFiles){
  foreach ($arrayFiles as $filename) { ?>
<table> <tr><td>
<?php	 
include("include/login_check.php");
?>
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