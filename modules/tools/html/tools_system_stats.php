<span class="belka">&nbsp System stats<span class="okno">

<?php
$arrayFiles=glob('img/system_stats/*');
if($arrayFiles){ ?>
<table> 
<tr><td><img src="img/system_stats/hour.png" /></td><td><img src="img/system_stats/day.png" /></td></tr>
<tr><td><img src="img/system_stats/week.png" /></td><td><img src="img/system_stats/month.png" /></td></tr>
</table>
<?php
} else { ?>
 <span class="brak">
<img src="media/ico/Sign-Stop-icon.png" />
</span>
<?php } ?>

</span></span>	
