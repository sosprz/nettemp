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
<table>
    <tr>
        <form action="" method="post">
            <td>1-wire Nettemp module (DS2482)</td>
            <td><input type="checkbox" name="therm" value="on" <?php echo $therm == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
            <input type="hidden" name="therm_onoff" value="therm_onoff" />
        </form>
    </tr>
    <tr>
        <form action="settings" method="post">
            <td>1-wire Raspberry Pi (GPIO4)</td>
            <td><input type="checkbox" name="gpio" value="on" <?php echo $gpio == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />  
            <input type="hidden" name="gpio_onoff" value="gpio_onoff" />
        </form>
    </tr>
    </table>
<font color="grey">Note: Changes in this section required reboot</font>
<br />
<br />
<?php
    $tempnum = isset($_POST['tempnum']) ? $_POST['tempnum'] : '';
    $set_tempnum = isset($_POST['set_tempnum']) ? $_POST['set_tempnum'] : '';
    if  ($set_tempnum == "set_tempnum") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET tempnum='$tempnum' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>
<form action="" method="post">
   <tr><td>GPIO temperature sensor number</td><td>
    <select name="tempnum" onchange="this.form.submit()">
	<?php foreach (range(1, 10) as $num) { ?>
        <option <?php echo $a['tempnum'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num; ?></option>   
	<?php } ?>
    </select>    
    </td>
    </tr>
    <input type="hidden" name="set_tempnum" value="set_tempnum" />
</form>

<?php
}
?>

