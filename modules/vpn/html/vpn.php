<?php
    $vpn_onoff = $_POST["vpn_onoff"];
    if (($_POST['onoff'] == "onoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET vpn='$vpn_onoff'") or die ($db->lastErrorMsg());
    if (!empty($vpn_onoff)) {
    shell_exec("sudo update-rc.d openvpn enable");
    shell_exec("sudo service openvpn start");
    }
    else {	
    shell_exec("sudo update-rc.d openvpn disable");
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
<span class="belka">&nbsp OpenVPN settings<span class="okno">



<table>

<tr> <td><h2>OpenVPN on/off</h2></td>
    <form action="vpn" method="post">
    <td><input type="checkbox" name="vpn_onoff" value="on" <?php echo $vpn == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="onoff" value="onoff" />
    </form>
</tr> 
</table>
<?php
if ($vpn == "on" ) { 
    include('vpn_add.php');
    include('vpn_ca.php');
	 } 
?>




</span></span>


