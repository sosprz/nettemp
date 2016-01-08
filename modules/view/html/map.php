<?php
$label='';
$need_id = isset($_POST['need_id']) ? $_POST['need_id'] : '';
$x = isset($_POST['x']) ? $_POST['x'] : '';
$y = isset($_POST['y']) ? $_POST['y'] : '';
if (!empty($need_id)){
$pos="{left:".$x.", top:".$y."}";
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("UPDATE sensors SET map_pos='$pos' WHERE id='$need_id'");
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<style type="text/css">
  .draggable {
      width: auto;
      height: auto;
      //padding: 0.5em;
      float: left;
      margin: 0px;
      cursor:move;
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
      width: 800px;
      height:800px;
      border:2px solid #ccc;
      padding: 10px;
  }
  h3 {
      clear: left;
  }
  .draggable.ui-draggable-dragging { background: green; }



  //#set div { width: 90px; height: 90px; padding: 0.5em; float: left; margin: 0 10px 10px 0; background: black;}
  //#set { clear:both; float:left; width: 368px;}
  //p { clear:both; margin:0; padding:1em 0; }
</style>


<script>
<?php
$array = array();
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select id,map_pos FROM sensors";
$dbh->query($query);
foreach ($dbh->query($query) as $row) {
    //$pos = explode("|", $row[1]);
    //$array[$row[0]]='{left: '.$pos[0].', top: '.$pos[1].'}';
	$array[$row[0]]=$row[1];
    }
$js_array = json_encode($array);
$js_array = str_replace('"','', $js_array);
echo "var positions = ".$js_array.";\n";
?>

var positions = JSON.stringify(positions);
var positions = JSON.parse(positions);
var id = 0
//alert(JSON.stringify(positions, null, 4));
$(function() {


$.each(positions, function (id, pos) {
        $("#data-need" + id).css(pos)
	//alert(JSON.stringify(id, null, 4));
	//alert(JSON.stringify(pos, null, 4));
    })


$( "#content div" ).draggable({
    containment: '#content',
    stack: "#content div",
    scroll: false,

      stop: function(event, ui) {

        //var pos_x = ui.offset.left;
         //var pos_y = ui.offset.top;  
	var pos_x = ui.position.left;
        var pos_y = ui.position.top;
          var need = ui.helper.data("need");
          $.ajax({
              type: "POST",
              url: "",
              data: { x: pos_x, y: pos_y, need_id: need}
            });

        }
    });
});





</script>
<div id="content">
<?php
$rows = $db->query("SELECT * FROM sensors");
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
<div data-need="<?php echo $a['id']?>" id="<?php echo "data-need".$a['id']?>" class="ui-widget-content draggable">
    <?php if(($a['tmp'] == 'error') || ($label=='danger')) {
		    echo '<span class="label label-danger">';
		    } 
		    else {
		    echo '<span class="label label-success">';
		    }
	        ?>

    <?php echo $type." ".$a['id']." ".$a['tmp']." ".$unit ?>
    </span>
</div>
<?php 
    }
?>
</div>
