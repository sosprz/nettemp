<?php
include('conf.php');

        if ($_POST['scan'] == "Scan"){
         exec("sh $global_dir/modules/sms/sms_scan");   
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>
<span class="belka">&nbsp Search modem<span class="okno"> 
<form action="sms" method="post">
<input type="submit" name="scan" value="Scan" />
</form>
</span></span>
