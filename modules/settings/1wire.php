<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">1wire</h3>
</div>
<div class="panel-body">
<?php
    $therm_onoff = isset($_POST['therm_onoff']) ? $_POST['therm_onoff'] : '';
    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $dtgpio_onoff = isset($_POST['dtgpio_onoff']) ? $_POST['dtgpio_onoff'] : '';
    $gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';
    $therm = isset($_POST['therm']) ? $_POST['therm'] : '';
    $dtgpio = isset($_POST['dtgpio']) ? $_POST['dtgpio'] : '';

    if (($therm_onoff == "therm_onoff") ){
    if (!empty($therm)) {
	shell_exec("install/1wire off on off");
    }
    else {	
	shell_exec("install/1wire off off off");
    } 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
                
    if (($gpio_onoff == "gpio_onoff") ){
    if (!empty($gpio)) {
	        shell_exec("install/1wire off off on");
    }
    else {	
        shell_exec("install/1wire off off off");
	} 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    if (($dtgpio_onoff == "dtgpio_onoff") ){
    if (!empty($dtgpio)) {
	        shell_exec("install/1wire on off off");
    }
    else {	
        shell_exec("install/1wire off off off");
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

if (exec("cat /boot/config.txt | grep 'pullup=on'")) {
$dtgpio='on';
}
else {
$dtgpio='';
}

?>


   
Pullup - this settings must be set when uses only DATA,GND in 1-wire
<table class="table">
    <!-- <tr>
	<td class="col-md-2">
	    1-wire Nettemp module (DS2482) and other USB modules
	</td>
	<td class="col-md-2">
    	    <form action="" method="post" style=" display:inline!important;">
        	<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="therm" value="on" <?php echo $therm == 'on' ? 'checked="checked"' : ''; ?>  />
        	<input type="hidden" name="therm_onoff" value="therm_onoff" />
    	    </form>
	</td>
    </tr>
    -->
    <tr>
	<td class="col-md-2">
	    1-wire Raspberry Pi (GPIO4)
	</td>
        <td class="col-md-2">
	    <form action="" method="post" style=" display:inline!important;">
            	<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="gpio" value="on" <?php echo $gpio == 'on' ? 'checked="checked"' : ''; ?>  />
        	<input type="hidden" name="gpio_onoff" value="gpio_onoff" />
    	    </form>
	</td>
    </tr>
    <tr>
	<td class="col-md-2">
	    1-wire Raspberry Pi Device Tree (GPIO4)
	</td>
        <td class="col-md-2">
	    <form action="" method="post" style=" display:inline!important;">
            	<input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="dtgpio" value="on" <?php echo $dtgpio == 'on' ? 'checked="checked"' : ''; ?>  />
        	<input type="hidden" name="dtgpio_onoff" value="dtgpio_onoff" />
    	    </form>
	</td>
    </tr>
    </table>
<span id="helpBlock" class="help-block">Changes in this section required reboot.</span>
</div>
</div>
