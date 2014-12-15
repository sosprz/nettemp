<?php
    $snmpd_onoff = isset($_POST['snmpd_onoff']) ? $_POST['snmpd_onoff'] : '';
    $snmpd = isset($_POST['snmpd']) ? $_POST['snmpd'] : '';

    if (($snmpd_onoff == "snmpd_onoff") ){
    if (!empty($snmpd)) {
	shell_exec("sudo cp /etc/snmp/snmpd.conf /etc/snmp/snmpd.bkp && sudo echo > /etc/snmp/snmpd.conf \
		    && sudo sed -i '$aview nettemp included .1.3.6.1.3' /etc/snmp/snmpd.conf \
		    && sudo sed -i '$arocommunity public default -V nettemp' /etc/snmp/snmpd.conf");
	
	shell_exec("sudo service snmpd start");
        shell_exec("sudo update-rc.d snmpd enable ");
    }
    else {	
	shell_exec("sudo service snmpd stop");
        shell_exec("sudo update-rc.d snmpd disable ");
    } 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
                


if (exec("sudo service snmpd status |grep 'is running'")) {
$snmpd='on';
}
else {
$snmpd='';
}

?>

<table>
    <tr>
        <form action="" method="post">
            <td>SNMP Server</td>
            <td><input type="checkbox" name="snmpd" value="on" <?php echo $snmpd == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
            <input type="hidden" name="snmpd_onoff" value="snmpd_onoff" />
        </form>
    </tr>
    </table>


