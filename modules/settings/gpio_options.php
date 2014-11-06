<?php
    
    $gsp_onoff = isset($_POST['gsp_onoff']) ? $_POST['gsp_onoff'] : '';
    $gspon = isset($_POST['gspon']) ? $_POST['gspon'] : '';
    if (($gsp_onoff == "gsp_onoff") ){
    if (!empty($gspon)) {
	shell_exec("sudo sed -i 's/w1_therm.*/w1_therm strong_pullup=0/g' /etc/modules");
    }
    else {	
	shell_exec("sudo sed -i 's/w1_therm strong_pullup=0.*/w1_therm/g' /etc/modules");
    } 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


if (exec("cat /etc/modules | grep 'strong_pullup'")) {
$gpio_sp='on';
}
else {
$gpio_sp='';
}

?>


<form action="settings" method="post">
    <td>Nettemp module (DS2482) - Reboot required</td>
    <td><input type="checkbox" name="gspon" value="on" <?php echo $gpio_sp == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="gsp_onoff" value="gsp_onoff" />
</form>
