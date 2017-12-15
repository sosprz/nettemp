<?php
    $fw_onoff = isset($_POST['fw_onoff']) ? $_POST['fw_onoff'] : '';
    $onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
    if ($onoff == 'onoff') {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$fw_onoff' WHERE option='fw'") or die ($db->lastErrorMsg());
    if ($fw_onoff != "on") {
    	shell_exec("/bin/bash modules/security/fw/fw off");
    } else {
    	shell_exec("/bin/bash modules/security/fw/fw on");
    	shell_exec("/bin/bash modules/security/fw/fw add 0.0.0.0/0 vpn");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>

<div class="panel panel-default">
<div class="panel-heading">Firewall</div>
<div class="panel-body">

<form action="" method="post">
<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="fw_onoff" value="on" <?php echo $nts_fw == 'on' ? 'checked="checked"' : ''; ?> />
<input type="hidden" name="onoff" value="onoff" />
</form>
</div>
</div>


<?php
    if ($nts_fw == "on" ) { ?>
    <?php include('fw_settings.php'); ?>
   
<?php	 } ?>
 <?php include('fw_status.php'); ?>


