<?php
include('conf.php');

         if ($_POST['scan'] == "Scan"){
         exec("sh $global_dir/modules/sensors/temp_dev_scan");   
         system("chmod 777 $global_dir/scripts/tmp/.digitemprc");
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>


<span class="belka">&nbsp Scan for new sensors<span class="okno"> 
<form action="sensors" method="post"><input type="submit" name="scan" value="Scan" />

</span></span>
