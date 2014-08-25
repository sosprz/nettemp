<span class="belka">&nbsp Reboot<span class="okno">
<?php
if ($_POST['reboot'] == "reboot1") { 
system ("reboot");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="index.php?id=tools&type=reboot" method="post">
<input type="hidden" name="reboot" value="reboot1">
<input  type="submit" value="Reboot"  />
</form>
</span></span>