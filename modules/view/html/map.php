  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<style type="text/css">
  .draggable {
    width: auto;
    height: auto;
    //padding: 0.5em;
    float: left;
    margin: 0 -1px -1px 0;
    cursor: move;
    border: 0px;
  }
  
  .draggable,
  a {
    cursor: move;
  }
  
  #draggable,
  #draggable2 {
    margin-bottom: 20px;
    cursor: move;
  }
  
  #draggable {
    cursor: move;
  }
  
  #draggable2 {
    cursor: e-resize;
  }
  
  #containment-wrapper {
    width: 1200px;
    height: 600px;
    border: 2px solid #ccc;
    padding: 10px;
    background: url("tmp/map.jpg") left top;
    background-size: 1200px 600px;
    background-repeat: no-repeat;
  }
  
  h3 {
    clear: left;
  }
</style>


<script>
var positions = JSON.parse(localStorage.positions || "{}");
$(function() {
  var d = $("[id=draggable]").attr("id", function(i) {
    return "draggable_" + i
  })
  $.each(positions, function(id, pos) {
    $("#" + id).css(pos)
  })

  d.draggable({
    containment: "#containment-wrapper",
    scroll: false,
    stop: function(event, ui) {
      positions[this.id] = ui.position
      localStorage.positions = JSON.stringify(positions)
    }
  });
});
</script>

<div id="containment-wrapper">
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
<div id="draggable" class="ui-widget-content draggable">
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
?>
</div>
