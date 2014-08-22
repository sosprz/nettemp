<span class="belka">&nbsp System stats<span class="okno">

<?php
$arrayFiles=glob('tmp/system_stats/*');
if($arrayFiles){ ?>
<table> 
<tr><td><img src="tmp/system_stats/hour.png" /></td><td><img src="tmp/system_stats/day.png" /></td></tr>
<tr><td><img src="tmp/system_stats/week.png" /></td><td><img src="tmp/system_stats/month.png" /></td></tr>
</table>
<?php
} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>

</span></span>	
