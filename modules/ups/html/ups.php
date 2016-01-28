<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$status = isset($_POST['status']) ? $_POST['status'] : '';
$onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';

if ($onoff == "onoff") {
    $db->exec("UPDATE settings SET ups_status='$status' WHERE id='1'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	

}
?>



<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">UPS</h3></div>
<div class="panel-body">
    <pre><?php passthru("/sbin/apcaccess");?></pre>

<?php
$met = $db->prepare("SELECT ups_status FROM settings WHERE id='1'");
$met->execute();
$resultmet = $met->fetchAll();
foreach ($resultmet as $m) { 
?>

<form action="" method="post">
    <label>UPS status</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="status" value="on" <?php echo $m['ups_status'] == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="onoff" value="onoff" />
</form>
</div>
</div>

<?php
    }
?>



