<?php 
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
$sth = $db->prepare("select *,'off' as 'normalized' from sensors where jg='on' UNION ALL select *,'on' as 'normalized' from sensors WHERE id=$normalized ORDER BY position ASC,id");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>
<div class="grid-item justgage">
<div class="panel panel-default">
<div class="panel-heading">JustGage</div>
<div class="panel-body">
<script src="html/justgage/raphael-2.1.4.min.js"></script>
<script src="html/justgage/justgage.js"></script>

<?php
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
<div id="<?php echo $a['name']?>" style="width:100px; height:100px;display:inline-block;"></div>
   
<script>
<?php
$query = "SELECT temp_scale FROM settings WHERE id='1'";
foreach ($db->query($query) as $row) {
	$temp_scale=$row['temp_scale'];
}
echo "var types = '". $a['type'] ."';\n"; 
echo "var temp_scale = '". $temp_scale ."';\n";
?>
 
if (types=='temp' && temp_scale=='F') {n_units = " °F"}
else if (types=='temp' && temp_scale=='C') {n_units = " °C" }
if (types=='humid') {n_units = " %"};
if (types=='press') {n_units = " hPa"};
if (types=='gpio') {n_units = " H/L"};
if (types=='host') {n_units = " ms"};
if (types=='system') {n_units = " %"};
if (types=='lux') {n_units = " lux"};
if (types=='water') {n_units = " m3"};
if (types=='gas') {n_units = " m3"};
if (types=='elec') {n_units = " W"};
if (types=='hosts') {n_units = " ms"};
if (types=='volt') {n_units = " V"};
if (types=='amps') {n_units = " A"};
if (types=='watt') {n_units = " W"};
if (types=='dist') {n_units = " cm"};
if (types=='normalized') {n_units = " hPa\nnpm"};

var g<?=$KtoryWidget++?> = new JustGage({
        id: "<?php echo $a['name']?>",
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
