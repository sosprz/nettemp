<div class="panel panel-default">
<div class="panel-heading">Reboot system</div>
<div class="panel-body">
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
<input  type="submit" value="Reboot" class="btn btn-xs btn-warning" />
</form>

</div>
</div>