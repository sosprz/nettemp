<?php 
if (isset($_GET['ch_g'])) { 
    $ch_g = $_GET['ch_g'];
} 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
//check if display normalized in jg
$normalized=-1;
$sth_norma = $db->prepare("select * from meteo");
$sth_norma->execute();
$result_norma = $sth_norma->fetchAll();	
if ($result_norma[0]['jg']=='on')
{
	$normalized=$result_norma[0]['pressure'];
}
$sth = $db->prepare("select *,'off' as 'normalized' from sensors where jg='on' AND ch_group=='$ch_g' UNION ALL select *,'on' as 'normalized' from sensors WHERE id=$normalized AND ch_group=='$ch_g' ORDER BY position ASC,id");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>

<div class="grid-item sgjg<?php echo $ch_g ?>">
<div class="panel panel-default">
<div class="panel-heading"><?php echo $ch_g?></div>
<div class="panel-body">
	

<?php
$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();

$KtoryWidget = 1;
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
<div id="<?php echo $ch_g.$a['name']?>" style="width:100px; height:100px;display:inline-block;"></div>
   
<script>
<?php

foreach($result_t as $ty){
       	if($ty['type']==$a['type']) {
       		if(($nts_temp_scale != 'C')&&($a['type']=='temp')){
       			echo "var n_units = '". $ty['unit2'] ."';\n"; 
       		} 
       		else {
				echo "var n_units = '". $ty['unit'] ."';\n"; 
       		}
        	}   
		}

?>

var g<?php echo $ch_g?><?=$KtoryWidget++?> = new JustGage({
        id: "<?php echo $ch_g.$a['name']?>",
        value: <?php 
        				if($a['type']=='elec') {
							echo $a['current'];
        				}
        				else if($a['tmp']=='error') { 
        						echo '0'; 
        					} 
        						else {
        								echo $a['tmp'];
        								}
        			?>,
        <?php if(!empty($a['tmp_min']) && !empty($a['tmp_max'])) {
        	echo "min:".$a['tmp_min'].", max:".$a['tmp_max'].",";
        	} ?>
        title: "<?php echo $a['name']?>",
        label: n_units
      });
</script>
<?php
 }
?>
</div>
</div>
</div>
<?php }  ?>
