<span class="belka">&nbsp RRD<span class="okno">

<?php
include("modules/login/login_check.php");

$arrayFiles=glob('img/view1/*');
if($arrayFiles){
//sort($arrayFiles);
//  foreach ($arrayFiles as $filename) { ?>
<table> 
<tr><td><img src="img/view1/hour.png" /></td></tr>
<tr><td><img src="img/view1/day.png" /></td></tr>
<tr><td><img src="img/view1/week.png" /></td></tr>
<tr><td><img src="img/view1/month.png" /></td></tr>
<tr><td><img src="img/view1/year.png" /></td></tr>
</table>

<?php
// }
} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>

</span></span>	
