<span class="belka">&nbsp Reset to default<span class="okno">
<?php
$admin_db_reset = isset($_POST['admin_db_reset']) ? $_POST['admin_db_reset'] : '';
if ($admin_db_reset == "admin_db_reset1") { 
system ("cd modules/tools && sh db_reset");

header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="index.php?id=tools&type=reset" method="post">
<input type="hidden" name="admin_db_reset" value="admin_db_reset1">
<input  type="submit" value="Reset"  />
</form>
</span></span>
