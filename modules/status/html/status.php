<div id="left">
<?php
include('conf.php');

if ($_POST['read'] == "Read"){
     exec("sh $global_dir/modules/sensors/read");	
     header("location: " . $_SERVER['REQUEST_URI']);
     exit();
     } 
?>




<?php 
include('status_show.php');
include('modules/sensors/html/sensors_read.php');
include('modules/sensors/html/sensors_device.php');
include('modules/sensors/html/sensors_scan.php'); 

?>
</div>




