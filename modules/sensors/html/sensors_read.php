<?php
include('conf.php');

if ($_POST['read'] == "Read"){
     exec("sh $global_dir/modules/sensors/read");       
     header("location: " . $_SERVER['REQUEST_URI']);
     exit();
     } 
?>




<span class="belka">&nbsp Read temp from sensors<span class="okno"> 
<form action="status" method="post"><input type="submit" name="read" value="Read" /></form>
</span></span>
