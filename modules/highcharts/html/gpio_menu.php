<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<?php
foreach(glob("db/gpio/*") as $files){
$v = preg_replace("/[^0-9,]/", "", basename($files));
?>
<td><a href="index.php?id=view&type=gpio&gpio=<?php echo $v ?>" ><button>GPIO <?php echo $v ?></button></a></td>
<?php
}
?>


</tr>
</table>



<?php 
$art = isset($_GET['gpio']) ? $_GET['gpio'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/gpio.php'); break;
}
?>




</span>
</span>
