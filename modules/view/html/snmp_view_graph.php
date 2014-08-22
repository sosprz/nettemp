<span class="belka">&nbsp RRD<span class="okno">

<?php
include("modules/login/login_check.php");

$arrayFiles=glob('tmp/snmp_view/*');
if($arrayFiles){
//sort($arrayFiles);
//  foreach ($arrayFiles as $filename) { ?>
<table> 
<tr><td><img src="tmp/snmp_view/hour.png" /></td></tr>
<tr><td><img src="tmp/snmp_view/day.png" /></td></tr>
<tr><td><img src="tmp/snmp_view/week.png" /></td></tr>
<tr><td><img src="tmp/snmp_view/month.png" /></td></tr>
<tr><td><img src="tmp/snmp_view/year.png" /></td></tr>
</table>

<?php
// }
} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>

</span></span>	
