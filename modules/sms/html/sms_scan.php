<?php
include('conf.php');

        if ($_POST['scan'] == "Scan"){
         exec("sh $global_dir/modules/sms/sms_scan");   
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>
<table><tr>
<td>Search modem</td>
<form action="sms" method="post">
<td><input type="submit" name="scan" value="Scan" /></td>
</form>
</tr></table>

