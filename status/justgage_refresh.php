<?php
header("Pragma: no-cache");
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$normalized=-1;
$sth_norma = $db->prepare("select * from meteo");
$sth_norma->execute();
$result_norma = $sth_norma->fetchAll();	
if ($result_norma[0]['jg']=='on')
{
	$normalized=$result_norma[0]['pressure'];
}
$sth = $db->prepare("select *,'off' as 'normalized' from sensors where jg='on' UNION ALL select *,'on' as 'normalized' from sensors WHERE id=$normalized ORDER BY position ASC,id");//$db->prepare("select * from sensors where jg='on' ORDER BY position ASC");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<script>
<?php
$kw = 1;
foreach ($result as $a) {
	if ($a['normalized']=='on')
	{
		$a['name']=$a['name'].' npm';
		$a['type']='normalized';
		require_once('Meteo.class.php');
		$meteo=new Meteo();
		$a['tmp']=number_format($meteo->getCisnienieZnormalizowane(),2,'.','');
	}
?>
g<?=$kw++?>.refresh('<?php
if($a['type']=='elec') { echo $a['current']; } else if($a['tmp']=='error') { echo '0'; } else { echo $a['tmp']; }
?>');
<?php
}
?>
</script>
<?php }  ?>