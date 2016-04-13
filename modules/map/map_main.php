<p>
<a href="index.php?id=map&type=map" ><button class="btn btn-xs btn-default <?php echo $art == 'map' ? 'active' : ''; ?>">Map</button></a>
<a href="index.php?id=map&type=settings" ><button class="btn btn-xs btn-default <?php echo $art == 'settings' ? 'active' : ''; ?>">Settings</button></a>
<a href="index.php?id=map&type=upload" ><button class="btn btn-xs btn-default <?php echo $art == 'upload' ? 'active' : ''; ?>">Upload</button></a>
</p>


<?php  
switch ($art)
{ 
default: case '$art': include('modules/map/map.php'); break;
case 'settings': include('modules/map//map_settings.php'); break;
case 'map': include('modules/map/map.php'); break;
case 'upload': include('modules/map/map_upload.php'); break;

}


?>

