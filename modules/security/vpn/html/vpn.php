<?php
    
    $vpn_onoff = isset($_POST['vpn_onoff']) ? $_POST['vpn_onoff'] : '';
    $onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
    if (($onoff == "onoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET vpn='$vpn_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    if (!empty($vpn_onoff)) {
    shell_exec("sudo sed -i '/iface eth0/a openvpn openvpn' /etc/network/interfaces");
    shell_exec("sudo service openvpn start");
    }
    else {	
    shell_exec("sudo sed -i '/openvpn openvpn/d' /etc/network/interfaces");
    shell_exec("sudo service openvpn stop");
    } 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$vpn=$a["vpn"];

}
?>

<div class="panel panel-default">
<div class="panel-heading">VPN</div>
<div class="panel-body">
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input type="checkbox" name="vpn_onoff" value="on" <?php echo $vpn == 'on' ? 'checked="checked"' : ''; ?> data-toggle="toggle" data-size="mini" onchange="this.form.submit()" />
    <input type="hidden" name="onoff" value="onoff" />
    </form>

</div>
</div>

<?php
if ($vpn == "on" ) { 

exec("pgrep openvpn", $pids);
if(empty($pids)) { ?>
<span class="label label-danger">OpenVpn not work</span>
<?php
}



    include('vpn_add.php');
    include('ovpn_status.php');
    
	 } 
?>



