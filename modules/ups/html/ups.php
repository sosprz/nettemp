<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$status = isset($_POST['status']) ? $_POST['status'] : '';
$onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';

if ($onoff == "onoff") {
    $db->exec("UPDATE nt_settings SET value='$status' WHERE option='ups_status'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	

}
?>



<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">UPS</h3></div>
<div class="panel-body">
    <pre><?php passthru("/sbin/apcaccess");?></pre>


<form action="" method="post">
    <label>UPS status</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="status" value="on" <?php echo $nts_ups_status == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="onoff" value="onoff" />
</form>
</div>
</div>




