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
include('read.php');
?>
</div>




