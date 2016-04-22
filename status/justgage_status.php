<?php 
$db = new PDO("sqlite:dbf/nettemp.db") or die ("cannot open database");
$sth = $db->prepare("select * from sensors where jg='on'");
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
$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE jg='on' ORDER BY position ASC");
$row = $rows->fetchAll();
foreach ($row as $a) { 	
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

      var g = new JustGage({
        id: "<?php echo $a['name']?>",
        value: <?php 
        				if($a['type']=='elec') {
        					$dbs = new PDO("sqlite:$root/db/".$a['rom'].".sql");
        					$rows = $dbs->query("SELECT current AS sums from def where time = (select max(time) from def)");
							$i = $rows->fetch(); 
							echo $i['sums'];
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
<?php }  ?>
