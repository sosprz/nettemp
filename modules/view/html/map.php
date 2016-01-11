<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<body onload="JavaScript:timedRefresh(60000);">

<?php
$label='';
$need_id = isset($_POST['need_id']) ? $_POST['need_id'] : '';
$need_dst = isset($_POST['need_dst']) ? $_POST['need_dst'] : '';
$x = isset($_POST['x']) ? $_POST['x'] : '';
$y = isset($_POST['y']) ? $_POST['y'] : '';
if (!empty($need_id)){
$pos="{left:".$x.", top:".$y."}";
if ($need_dst=='hosts') {
    $dbs = new PDO('sqlite:dbf/hosts.db');
}
else {
    $dbs = new PDO('sqlite:dbf/nettemp.db');
}
$dbs->exec("UPDATE $need_dst SET map_pos='$pos' WHERE map_num='$need_id'");
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}
?>

  <link rel="stylesheet" href="html/jquery/jquery-ui.css">
  <script src="html/jquery/jquery-ui.js"></script>


<style type="text/css">
  .draggable {
      width: 1px;
      height: 1px;
      //padding: 0.5em;
      float: left;
      margin: 0px;
      cursor: move;
      border: 0px;
  }
  .draggable, a {
      cursor:move;
  }
  #draggable, .draggable2 {
      margin-bottom:20px;
      cursor:move;
  }
  #draggable {
      cursor: move;
  }
  #draggable {
      cursor: e-resize;
  }
  #content {
      width: 1140px;
      height: 600px;
      border:2px solid #ccc;
      padding: 2px;
      background: url("map.jpg") left top;
      //background-size: cover;
      background-repeat: no-repeat;
  }
  h3 {
      clear: left;
  }
  .draggable.ui-draggable-dragging { 
	//padding: 2px;
	
    }
</style>


<script>
<?php
$array = array();
$dirn = "sqlite:dbf/nettemp.db";
$dbn = new PDO($dirn) or die("cannot open database");
$dirh = "sqlite:dbf/hosts.db";
$dbh = new PDO($dirh) or die("cannot open database");

$query = "select map_num,map_pos FROM sensors";
$dbn->query($query);
foreach ($dbn->query($query) as $row) {
	$array[$row[0]]=$row[1];
    }
$js_array = json_encode($array);
$js_array = str_replace('"','', $js_array);
echo "var sensors = ".$js_array.";\n";

unset($query);
unset($js_array);
unset($array);

$query = "select map_num,map_pos FROM gpio";
$dbn->query($query);
foreach ($dbn->query($query) as $row) {
	$array[$row[0]]=$row[1];
    }
$js_array = json_encode($array);
$js_array = str_replace('"','', $js_array);
echo "var gpio = ".$js_array.";\n";

unset($query);
unset($js_array);
unset($array);

$query = "select map_num,map_pos FROM hosts";
$dbh->query($query);
foreach ($dbh->query($query) as $row) {
	$array[$row[0]]=$row[1];
    }
$js_array = json_encode($array);
$js_array = str_replace('"','', $js_array);
echo "var hosts = ".$js_array.";\n";


?>

var sensors = JSON.stringify(sensors);
var sensors = JSON.parse(sensors);

var gpio = JSON.stringify(gpio);
var gpio = JSON.parse(gpio);

var hosts = JSON.stringify(hosts);
var hosts = JSON.parse(hosts);

var id = 0
//alert(JSON.stringify(positions, null, 4));
$(function() {

if (sensors != null) {
$.each(sensors, function (id, pos) {
        $("#data-need" + id).css(pos)
    })
}

if (gpio != null) {
$.each(gpio, function (id, pos) {
        $("#data-need" + id).css(pos)
    })
}

if (hosts != null) {
$.each(hosts, function (id, pos) {
        $("#data-need" + id).css(pos)
    })
}

$( "#content div" ).draggable({
    containment: '#content',
    stack: "#content div",
    scroll: false,

      stop: function(event, ui) {

	var pos_x = ui.position.left;
        var pos_y = ui.position.top;
          var need = ui.helper.data("need");
	  var dst = ui.helper.data("dst");
          $.ajax({
              type: "POST",
              url: "",
              data: { x: pos_x, y: pos_y, need_id: need, need_dst: dst }
            });

        }
    });
});





</script>
<div id="content">
<?php
$rows = $dbn->query("SELECT * FROM sensors WHERE map='on'");
$row = $rows->fetchAll();
foreach ($row as $a) {
	if($a['type'] == 'lux'){ $unit='lux'; $type='<img src="media/ico/sun-icon.png"/>';} 
	if($a['type'] == 'temp'){ $unit='&#8451'; $type='<img src="media/ico/temp2-icon.png"/>';}
	if($a['type'] == 'humid'){ $unit='%'; $type='<img src="media/ico/rain-icon.png"/>';}
	if($a['type'] == 'press'){ $unit='Pa'; $type='<img src="media/ico/Science-Pressure-icon.png"/>';}
	if($a['type'] == 'water'){ $unit='m3'; $type='<img src="media/ico/water-icon.png"/>';}
	if($a['type'] == 'gas'){ $unit='m3'; $type='<img src="media/ico/gas-icon.png"/>';}
	if($a['type'] == 'elec'){ $unit='kWh'; $type='<img src="media/ico/Lamp-icon.png"/>';}
	if($a['type'] == 'watt'){ $unit='W'; $type='<img src="media/ico/database-lightning-icon.png" alt="Watt"/>';}
	if($a['type'] == 'volt'){ $unit='V'; $type='<img src="media/ico/volt.png" alt="Volt" /> ';}
	if($a['type'] == 'amps'){ $unit='A'; $type='<img src="media/ico/amper.png" alt="Amps"/> ';}
?>
<div data-need="<?php echo $a['map_num']?>" id="<?php echo "data-need".$a['map_num']?>" data-dst="sensors" class="ui-widget-content draggable">
    <?php if(($a['tmp'] == 'error') || ($label=='danger')) {
		    echo '<span class="label label-danger">';
		    } 
		    else {
		    echo '<span class="label label-success">';
		    }
	        ?>

    <?php echo $type." ".$a['name']." ".$a['tmp']." ".$unit ?>
    </span>
</div>
<?php 
    }
unset($a);
?>

<?php
$rows = $dbn->query("SELECT * FROM gpio WHERE mode NOT LIKE 'humid'");
$row = $rows->fetchAll();
foreach ($row as $a) {
    $device='<img src="media/ico/SMD-64-pin-icon_24.png" />';
?>
<div data-need="<?php echo $a['map_num']?>" id="<?php echo "data-need".$a['map_num']?>" data-dst="gpio" class="ui-widget-content draggable">
    <?php if(($a['status'] == 'error') || ($a['status'] == 'OFF') || ($label=='danger')) {
		    echo '<span class="label label-danger">';
		    } 
		    else {
		    echo '<span class="label label-success">';
		    }
	        ?>

    <?php echo $device." ".$a['name']." ".$a['status']?>
    </span>
</div>
<?php 
    }
unset($a);
?>

<?php
$dbh = new PDO("sqlite:dbf/hosts.db");
$rows = $dbh->query("SELECT * FROM hosts");
$row = $rows->fetchAll();
foreach ($row as $h) {
    $device='<img src="media/ico/Computer-icon.png" />';
?>
<div data-need="<?php echo $h['map_num']?>" id="<?php echo "data-need".$h['map_num']?>" data-dst="hosts" class="ui-widget-content draggable">
    <?php 
	if(($h['status'] == 'error') || ($h['status'] == 'OFF') || ($label=='danger')) {
		    echo '<span class="label label-danger">';
		    } 
		    else {
		    echo '<span class="label label-success">';
		    }
	        ?>

    <?php echo $device." ".$h['name']." ".$h['status']?>
     </span>
</div>
<?php 
    }
unset($h);
?>
</div>

<?php
    include('map_upload.php');
?>
