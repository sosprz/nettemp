<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">SNMPD</h3>
</div>
<div class="panel-body">
<?php
    $snmpd_onoff = isset($_POST['snmpd_onoff']) ? $_POST['snmpd_onoff'] : '';
    $snmpd = isset($_POST['snmpd']) ? $_POST['snmpd'] : '';

    if (($snmpd_onoff == "snmpd_onoff") ){
    if (!empty($snmpd)) {
	shell_exec("sudo cp /etc/snmp/snmpd.conf /etc/snmp/snmpd.bkp");
	shell_exec("sudo sed -i '/^/d' /etc/snmp/snmpd.conf");
	shell_exec("echo \"# nettemp.pl snmpd server\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"view nettemp included .1.3.6.1.3\" |sudo tee -a  /etc/snmp/snmpd.conf");
	shell_exec("echo \"rocommunity public default -V nettemp\" |sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.1 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''1}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.2 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''2}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.3 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''3}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.4 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''4}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.5 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''5}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.6 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''6}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.7 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''7}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");
	shell_exec("echo \"extend .1.3.6.1.3.8 /bin/bash \"/usr/bin/awk -F: ''\'''{print ''\$''8}''\''' /var/www/nettemp/tmp/results\"\" | sudo tee -a /etc/snmp/snmpd.conf");

	
	shell_exec("sudo service snmpd start");
        shell_exec("sudo update-rc.d snmpd enable ");
    }
    else {	
	shell_exec("sudo service snmpd stop");
        shell_exec("sudo update-rc.d snmpd disable ");
	shell_exec("sudo cp -f /etc/snmp/snmpd.conf.bkp /etc/snmp/snmpd.conf");
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
</div>
</div>

