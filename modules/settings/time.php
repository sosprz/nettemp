<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">time</h3>
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
	    shell_exec("sudo sed -i '\$artc-ds1307' /etc/modules");
	    shell_exec("sudo sed -i '/exit 0/i echo ds1307 0x68 > \/sys\/class\/i2c-adapter\/'$(ls /dev/i2c-* |awk -F/ '{print $3}')'\/new_device && hwclock -s' /etc/rc.local");

    }
    else {
	shell_exec("sudo sed -i '/rtc-ds1307/d' /etc/rc.local");
        shell_exec("sudo sed -i '/rtc-ds1307/d' /etc/modules");
	} 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


if (exec("cat /etc/modules | grep 'ds1307'") &&  exec("cat /etc/rc.local | grep 'ds1307'")) {
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

<table>
    <tr>
        <form action="" method="post">
            <td>NTP</td>
            <td><input type="checkbox" name="ntp" value="on" <?php echo $ntp == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
            <input type="hidden" name="ntp_onoff" value="ntp_onoff" />
        </form>
    </tr>
<?php
if ((file_exists("/dev/i2c-0")) || (file_exists("/dev/i2c-1"))) {
?>
    <tr>
        <td>RTC (Raspberry PI)</td>

	<form action="" method="post">
            <td><input type="checkbox" name="rtc" value="on" <?php echo $rtc == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />  
            <input type="hidden" name="rtc_onoff" value="rtc_onoff" />
        </form>
    </tr>
    <tr><td><?php echo "System date: "; passthru("date");?></td></tr>
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
<tr><td><input  type="submit" value="Time sync"  /></td></tr>
</form>


    <tr><td><?php echo "Hwclock date: "; passthru("sudo /sbin/hwclock --show");?></td></tr>
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
<tr><td><input  type="submit" value="RTC sync"  /></td></tr>
</form>
<?php 
}
else { ?>
    <tr>
        <td>RTC - No i2c modules loaded</td>
    </tr>

<?php }
?>
    </table>

<font color="grey">Note: After RTC on, reboot is required</font>
</div>
</div>
