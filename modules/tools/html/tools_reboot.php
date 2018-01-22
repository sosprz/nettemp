<div class="panel panel-default">
<div class="panel-heading">Reboot or shutdown system</div>
<div class="panel-body">
<?php
$reboot = isset($_POST['reboot']) ? $_POST['reboot'] : '';
if ($reboot == "reboot1") { 
system ("sudo /sbin/reboot");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
$shutdown = isset($_POST['shutdown']) ? $_POST['shutdown'] : '';
if ($shutdown == "shutdown1") { 
system ("sudo /sbin/shutdown now");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form class="form-inline" action="index.php?id=tools&type=reboot" method="post">
<input type="hidden" name="reboot" value="reboot1">
<input  type="submit" value="Reboot" class="btn btn-xs btn-warning" />
<input type="hidden" name="shutdown" value="shutdown1">
<input  type="submit" value="Shutdown" class="btn btn-xs btn-danger" />
</form>

</div>
</div>