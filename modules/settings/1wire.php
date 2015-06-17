<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">1wire</h3>
</div>
<div class="panel-body">
<?php
    $therm_onoff = isset($_POST['therm_onoff']) ? $_POST['therm_onoff'] : '';
    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';
    $therm = isset($_POST['therm']) ? $_POST['therm'] : '';

    if (($therm_onoff == "therm_onoff") ){
    if (!empty($therm)) {
	shell_exec("sudo sed -i 's/w1_therm.*/w1_therm strong_pullup=0/g' /etc/modules");
        shell_exec("sudo sed -i 's/w1_gpio.*/w1_gpio/g' /etc/modules");
    }
    else {	
	shell_exec("sudo sed -i 's/w1_therm strong_pullup=0.*/w1_therm/g' /etc/modules");
    } 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
                
    if (($gpio_onoff == "gpio_onoff") ){
    if (!empty($gpio)) {
	        shell_exec("sudo sed -i 's/w1_gpio.*/w1_gpio pullup=1/g' /etc/modules");
            shell_exec("sudo sed -i 's/w1_therm strong_pullup=0.*/w1_therm/g' /etc/modules");
    }
    else {	
        shell_exec("sudo sed -i 's/w1_gpio.*/w1_gpio/g' /etc/modules");
	} 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


if (exec("cat /etc/modules | grep 'strong_pullup=0'")) {
$therm='on';
}
else {
$therm='';
}

if (exec("cat /etc/modules | grep 'pullup=1'")) {
$gpio='on';
}
else {
$gpio='';
}

?>


   
Pullup - this settings must be set when uses only DATA,GND in 1-wire
<table class="table">
    <tr>
        <form action="" method="post">
            <td>1-wire Nettemp module (DS2482)</td>
            <td><input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="therm" value="on" <?php echo $therm == 'on' ? 'checked="checked"' : ''; ?>  />
            <input type="hidden" name="therm_onoff" value="therm_onoff" />
        </form>
    </tr>
    <tr>
        <form action="" method="post">
            <td>1-wire Raspberry Pi (GPIO4)</td>
            <td><input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="gpio" value="on" <?php echo $gpio == 'on' ? 'checked="checked"' : ''; ?>  />  
            <input type="hidden" name="gpio_onoff" value="gpio_onoff" />
        </form>
    </tr>
    </table>
<font color="grey">Note: Changes in this section required reboot</font>
</div>
</div>
