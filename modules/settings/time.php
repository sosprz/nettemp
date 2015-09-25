<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">NTP service sync</h3>
</div>
<div class="panel-body">
<?php
    $ntp_onoff = isset($_POST['ntp_onoff']) ? $_POST['ntp_onoff'] : '';
    $rtc_onoff = isset($_POST['rtc_onoff']) ? $_POST['rtc_onoff'] : '';
    $rtc = isset($_POST['rtc']) ? $_POST['rtc'] : '';
    $ntp = isset($_POST['ntp']) ? $_POST['ntp'] : '';

    if (($ntp_onoff == "ntp_onoff") ){
    if (!empty($ntp)) {
	shell_exec("sudo service ntp start");
        shell_exec("sudo update-rc.d ntp enable ");
    }
    else {	
	shell_exec("sudo service ntp stop");
        shell_exec("sudo update-rc.d ntp disable ");
    } 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
                
    if (($rtc_onoff == "rtc_onoff") ){
    if (!empty($rtc)) {
	    shell_exec("sudo touch tmp/cronr");
	    shell_exec("sudo sed -i '\$artc-ds1307' /etc/modules");
	    shell_exec("sudo sed -i '\$aecho ds1307 0x68 > \/sys\/class\/i2c-adapter\/'$(ls /dev/i2c-* |awk -F/ '{print $3}')'\/new_device && hwclock -s' tmp/cronr");
	    shell_exec("sudo touch tmp/reboot");
    }
    else {
	shell_exec("sudo sed -i '/ds1307/d' tmp/cronr");
        shell_exec("sudo sed -i '/rtc-ds1307/d' /etc/modules");
	} 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>

<?php
if (exec("cat /etc/modules | grep 'ds1307'") &&  exec("cat tmp/cronr | grep 'ds1307'")) {
	$rtc='on';
} else {
    $rtc='';
    //echo "module not added or autostart";
}


if (exec("sudo service ntp status |grep 'is running'")) {
$ntp='on';
}
else {
$ntp='';
}

?>
<form action="" method="post">
    <input onchange="this.form.submit()"  type="checkbox"  data-toggle="toggle" data-size="mini"  name="ntp" value="on" <?php echo $ntp == 'on' ? 'checked="checked"' : ''; ?> />
    <input type="hidden" name="ntp_onoff" value="ntp_onoff" />
</form>
<?php
exec("pgrep ntpd", $pids);
if(empty($pids)) { ?>
<span class="label label-danger">NTPd not work</span>
<?php
}
?>

</div></div>



<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">RTC i2c</h3>
</div>
<div class="panel-body">
<form action="" method="post">
<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="rtc" value="on" <?php echo $rtc == 'on' ? 'checked="checked"' : ''; ?>  />
<input type="hidden" name="rtc_onoff" value="rtc_onoff" />
</form>
<?php 
    if ( $rtc == "on") { 
?>

<?php
if ((file_exists("/dev/i2c-0")) || (file_exists("/dev/i2c-1"))) {
?>


<hr>
    <?php echo "System date: "; passthru("date");?>
<?php
$ntsync = isset($_POST['ntsync']) ? $_POST['ntsync'] : '';
if ($ntsync == "ntsync") { 
shell_exec("sudo service ntp restart; sleep 5; sudo /usr/sbin/ntpd -qg");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="" method="post">
    <input type="hidden" name="ntsync" value="ntsync">
    <input  type="submit" value="Time sync"  class="btn btn-primary"/>
</form>
<?php echo "Hwclock date: "; passthru("sudo /sbin/hwclock --show");?>
<?php
$hwsync = isset($_POST['hwsync']) ? $_POST['hwsync'] : '';
if ($hwsync == "hwsync") { 
shell_exec("sudo /sbin/hwclock -w");
header("location: " . $_SERVER['REQUEST_URI']);
exit();	
}
?>
<form action="" method="post">
<input type="hidden" name="hwsync" value="hwsync">
<input  type="submit" value="RTC sync" class="btn btn-primary" />
</form>
<?php 
}
else { ?>
RTC - No i2c modules loaded

<?php 
    }
?>


<?php 
    }
?>
</div>
</div>
