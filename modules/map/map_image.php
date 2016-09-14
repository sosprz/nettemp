<?php
	//display name on map
	 $action = isset($_POST['action']) ? $_POST['action'] : '';
    $map_width = isset($_POST['map_width']) ? $_POST['map_width'] : '';
    $map_height = isset($_POST['map_height']) ? $_POST['map_height'] : '';
    if (($action == "save")){
	 $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE html SET value='$map_width' WHERE name='map_width'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE html SET value='$map_height' WHERE name='map_height'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
?> 


<div class="panel panel-default">
<div class="panel-heading">Image size</div>
<div class="panel-body">
<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-1 control-label" for="textinput">Height</label>  
  <div class="col-md-1">
  <input id="textinput" name="map_height" type="text" placeholder="800" class="form-control input-md" value="<?php echo $html_map_height ?>">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-1 control-label" for="textinput">Width</label>  
  <div class="col-md-1">
  <input id="textinput" name="map_width" type="text" placeholder="600" class="form-control input-md" value="<?php echo $html_map_width ?>">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-1 control-label" for="singlebutton"></label>
  <div class="col-md-1">
  	 <input type="hidden" name="action" value="save" />
    <button id="singlebutton" name="save" class="btn btn-xs btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>

</div>
</div>


    