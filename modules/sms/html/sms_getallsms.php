<?php
        if ($_POST['getallsms'] == "Get all sms"){
         exec("gammu -c tmp/gammurc getallsms > tmp/gammu_getallsms");  
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
        if ($_POST['delallsms'] == "Del all sms"){
         exec("gammu -c tmp/gammurc deleteallsms 1"); 
         exec("gammu -c tmp/gammurc getallsms > tmp/gammu_getallsms");
         header("location: " . $_SERVER['REQUEST_URI']);
         exit();
         } 
         

?>
<table><tr>
<form action="sms" method="post">
<td><input type="submit" name="getallsms" value="Get all sms" /></td>
</form>
<form action="sms" method="post">
<td><input type="submit" name="delallsms" value="Del all sms" /></td>
</form>
</tr></table>

<div style="width:990px;height:auto;overflow:auto;padding:5px;">
<pre><?php include('tmp/gammu_getallsms'); ?></pre>
</div>



