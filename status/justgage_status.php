<?php 
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from sensors where jg='on' ORDER BY position ASC");
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
$KtoryWidget = 0;
foreach ($result as $a) { 	
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
