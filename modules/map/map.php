<?php 
if(!isset($_SESSION['user'])){ header("Location: denied"); } 

$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");


$label='';
$need_id = isset($_POST['need_id']) ? $_POST['need_id'] : '';
$need_dst = isset($_POST['need_dst']) ? $_POST['need_dst'] : '';
$x = isset($_POST['x']) ? $_POST['x'] : '';
$y = isset($_POST['y']) ? $_POST['y'] : '';
if (!empty($need_id)){
$pos="{left:".$x.", top:".$y."}";

$db = new PDO('sqlite:dbf/nettemp.db');

$db->exec("UPDATE maps SET map_pos='$pos' WHERE map_num='$need_id'");
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
      width: <?php echo $nts_map_width ?>px;
      height: <?php echo $nts_map_height ?>px;
      border:2px solid #ccc;
      padding: 2px;
<?php 
    if (file_exists("map.jpg")) { ?>
      background: url("map.jpg?nocache=<?php echo time(); ?>") left top;
<?php 
    } else { ?>
    background: url("media/jpg/map_example.jpg?nocache=<?php echo time(); ?>") left top;
<?php
    }
?>
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

$query = "select map_num,map_pos FROM maps";//sensors";
$db->query($query);
foreach ($db->query($query) as $row) {
	$array[$row[0]]=$row[1];
    }
$js_array = json_encode($array);
$js_array = str_replace('"','', $js_array);
echo "var elements = ".$js_array.";\n";

unset($query);
unset($js_array);
unset($array);

?>

var sensors = JSON.stringify(elements);
var sensors = JSON.parse(sensors);


var id = 0
//alert(JSON.stringify(positions, null, 4));
$(function() {

if (elements != null) {
$.each(elements, function (id, pos) {
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
$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();

$rows = $db->query("SELECT * FROM maps WHERE map_on='on' AND type='sensors'");
$row = $rows->fetchAll();
foreach ($row as $b) {
	$rows=$db->query("SELECT * FROM sensors WHERE id='$b[element_id]' AND type!='gpio'");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array

	
	foreach($result_t as $ty){

       	if($ty['type']==$a['type']) {
       		if($nts_temp_scale == 'C'){
       			$unit=$ty['unit'];
       		} else {
       			$unit=$ty['unit2'];
       		}
       		$type="<img src=\"".$ty['ico']."\" alt=\"\" title=\"".$ty['title']."\"/>";
       	}   
		}	
		
	
	//Jesli w³¹czone to wyœwietlamy nazwê inaczej pusty ci¹g
	$sensor_name='';
	$transparent_bkg='';
	$background_color='';
	$background_low='';
	$background_high='';
	$font_color='';
	$font_size='';
	$label_class='';
	if($b['display_name'] == 'on')	$sensor_name=$a['name'];
	if($b['transparent_bkg'] == 'on') $transparent_bkg='transparent-background';
	if($b['background_color'] != '') $background_color="background:".$b['background_color'];
	if($b['background_low'] != '') $background_low="background:".$b['background_low'];
	if($b['background_high'] != '') $background_high="background:".$b['background_high'];
	if($b['font_color'] != '') $font_color="color:".$b['font_color'];
	if($b['font_size'] != '') $font_size="font-size:".$b['font_size']."%";
?>
<div data-need="<?php echo $b['map_num']?>" id="<?php echo "data-need".$b['map_num']?>" data-dst="sensors" 
											class="ui-widget-content draggable" 
											title="<?php echo $a['name'].' - Last update: '.$a['time']; ?>" 
											ondblclick="location.href='index.php?id=view&type=temp&max=day&single=<?php echo $a['name']; ?>'">
    <?php 
			$display_style='style=""';
			if(($a['tmp'] == 'error') || ($label=='danger') || ($a['status'] =='error') || ($a['tmp'] == 'wait')) {
				//echo '<span class="label label-danger label-sensors">';
				$label_class="label-danger";
		    } 
			elseif (($a['type'] == 'temp') && ($a['alarm'] == 'on') && ($a['tmp']  < $a['tmp_min']))
			{
				$type='<img src="media/ico/temp_low.png"/>';
				$label_class="label-to-low";
				$background_color=$background_low;
				//echo '<span class="label label-to-low label-sensors">';
			}
			elseif (($a['type'] == 'temp') && ($a['alarm'] == 'on') && ($a['tmp']  > $a['tmp_max']))
			{
				$type='<img src="media/ico/temp_high.png"/>';
				$label_class="label-to-high";
				$background_color=$background_high;
				//echo '<span class="label label-to-high label-sensors">';
			}
		    else 
			{
				$label_class=$transparent_bkg.' label-sensors';
				//$background_color='';
				//echo '<span class="'.$transparent_bkg.' label label-success">';
		    } 
			echo '<span class="label '.$label_class.'" style="'.$background_color.';'.$font_size.';'.$font_color.'">';
			if ((is_numeric($a['tmp']) && (($a['type'])=='elec')))  {
				echo 	$type." ".$sensor_name." ".number_format($a['tmp'], 3, '.', ',')." ".$unit;
		    }
		    elseif (is_numeric($a['tmp'])&&$a['status']!='error') {  
				echo 	$type." ".$sensor_name." ".number_format($a['tmp'], 1, '.', ',')." ".$unit;
			}
			elseif ($a['status']=='error') { 
				echo $type." ".$sensor_name." offline";
			}
		    else {
				echo $type." ".$sensor_name." ".$a['tmp']." ".$unit;
		    }

	?>
    </span>
</div>
<?php 
    }
unset($a);
unset($row);
unset($rows);
?>

<?php
$rows = $db->query("SELECT * FROM maps WHERE type='gpio' AND map_on='on'");
$row = $rows->fetchAll();
foreach ($row as $b) {
	
	
	$rows=$db->query("SELECT * FROM gpio WHERE rom = (SELECT rom FROM sensors WHERE id='$b[element_id]')");//always one record
	$a=$rows->fetchAll();
	$a=$a[0];//extracting from array
	var_dump($a);
	$icon='';
	if($b['icon'] != '')
	{
		$icon=$b['icon'];
	}
	switch ($icon){
		case 'Light':
			$device='<img src="media/ico/Lamp-icon.png" />';
			break;
		case 'Socket':
			$device='<img src="media/ico/Socket-icon.png" />';
			break;
		case 'Switch':
			$device='<img src="media/ico/Switch-icon.png" />';
			break;
		default:
			$device='<img src="media/ico/SMD-64-pin-icon_24.png" />';
	}
	if (($a['mode'] != 'dist') && ($a['mode'] != 'humid')) {
?>
<div data-need="<?php echo $b['map_num']?>" id="<?php echo "data-need".$b['map_num']?>" data-dst="gpio" class="ui-widget-content draggable"title="<?php echo $a['name']; ?>">
    <?php if(($a['status'] == 'error') || ($a['status'] == 'OFF') || ($a['status'] == 'off') || ($label=='danger')) {
		    echo '<span class="label label-danger">';
		    } 
		    else {
		    echo '<span class="label label-success">';
		    }
	        ?>

    <?php 
		//Jeœli w³¹czone to wyœwietlamy nazwê i status przeciwnie tylko status
		if ($b['display_name'] == 'on') {
		echo $device." ".$a['name']." ".$a['status'];
		}
		else
		{
			echo $device." ".$a['status'];
		}
		?>
	<?php
		if ($a['mode'] == 'simple' && $b['control_on_map'] == 'on'){
			 $gpio_post= $_POST['gpio'];
			 $rom = $a['rom'];
			 include('modules/gpio/html/gpio_simple.php');
		}
		elseif ($a['mode'] == 'time' && $b['control_on_map'] == 'on'){
			$gpio_post = $a['gpio'];
			$rom = $a['rom'];
			$time_offset = $a['time_offset'];
			include('modules/gpio/html/gpio_time.php');
		}
		elseif ($a['mode'] == 'moment' && $b['control_on_map'] == 'on'){
			$gpio_post= $a['gpio'];
			$rom = $a['rom'];
			$moment_time = $a['moment_time'];
			include('modules/gpio/html/gpio_moment.php');
		}
		elseif ($a['mode'] == 'control' && $b['control_on_map'] == 'on'){
			$gpio_post = $a['gpio'];
			$rom = $a['rom'];
			include('modules/gpio/html/gpio_control.php');
		}
	?>
    </span>
</div>
<?php 
	}//end if
    }
unset($a);
?>
</div>



