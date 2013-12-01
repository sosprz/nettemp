<span class="belka">&nbsp Reboot<span class="okno">
<?php
if ($_POST['reboot'] == "reboot1") { 
system ("reboot");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="tools" method="post">
<input type="hidden" name="reboot" value="reboot1">
<input  type="submit" value="Reboot"  />
</form>
</span></span>