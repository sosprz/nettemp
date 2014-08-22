<span class="belka">&nbsp RRD<span class="okno">

<?php
include("modules/login/login_check.php");

$arrayFiles=glob('tmp/humi_view/*');
if($arrayFiles){
//sort($arrayFiles);
//  foreach ($arrayFiles as $filename) { ?>
<table> 
<tr><td><img src="tmp/humi_view/hour.png" /></td></tr>
<tr><td><img src="tmp/humi_view/day.png" /></td></tr>
<tr><td><img src="tmp/humi_view/week.png" /></td></tr>
<tr><td><img src="tmp/humi_view/month.png" /></td></tr>
<tr><td><img src="tmp/humi_view/year.png" /></td></tr>
</table>

<?php
// }
} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>

</span></span>	
