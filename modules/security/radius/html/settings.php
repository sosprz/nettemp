<?php
    $rad_onoff = isset($_POST['rad_onoff']) ? $_POST['rad_onoff'] : '';
    $onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
    if (($onoff == "onoff") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE nt_settings SET value='$rad_onoff' WHERE option='radius'") or die ($db->lastErrorMsg());
	shell_exec("sudo sed -i '/exit 0/i radiusd' /etc/rc.local");
	shell_exec("sudo radiusd");
    if ($rad_onoff != "on") {
	shell_exec("sudo pkill -f radiusd");
	shell_exec("sudo sed -i '/radiusd/d' /etc/rc.local");
	}
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading">Radius</div>
<div class="panel-body">
<form action="" method="post">
<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="rad_onoff" value="on" <?php echo $nts_radius == 'on' ? 'checked="checked"' : ''; ?> />
<input type="hidden" name="onoff" value="onoff" />
</form>
</div>
</div>

<?php
    if ($nts_radius == "on" ) {
    exec("pgrep radiusd", $pids);
    if(empty($pids)) { ?>
	<span class="label label-danger">Radius not work</span>
    <?php
	}
    include('clients.php');
    include('certs.php');
     } 
?>


