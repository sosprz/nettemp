<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<?php
foreach(glob("db/host_*.sql") as $files){
$name=basename($files);
$vv = explode("_", $name);
$exp = $vv[1];
$exp2 = explode(".", $exp);
$v = $exp2[0];
?>
<td><a href="index.php?id=view&type=hosts&host=<?php echo $v ?>" ><button><?php echo $v ?></button></a></td>
<?php
}
?>


</tr>
</table>



<?php 
$art = isset($_GET['host']) ? $_GET['host'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/hosts.php'); break;
}
?>




</span>
</span>
