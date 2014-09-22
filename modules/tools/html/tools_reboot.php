<span class="belka">&nbsp Reboot<span class="okno">
<?php
$reboot = isset($_POST['reboot']) ? $_POST['reboot'] : '';
if ($reboot == "reboot1") { 
system ("sudo /sbin/reboot");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="index.php?id=tools&type=reboot" method="post">
<input type="hidden" name="reboot" value="reboot1">
<input  type="submit" value="Reboot"  />
</form>
</span></span>