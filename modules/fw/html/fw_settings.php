<?php
    $ssh = $_POST["ssh"];
    $icmp = $_POST["icmp"];
    $openvpn = $_POST["openvpn"];
    $ext = $_POST["ext"];
    if (($_POST['fw_apply'] == "fw_apply") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE fw SET ssh='$ssh'") or die ("exec error");
	$db->exec("UPDATE fw SET icmp='$icmp'") or die ("exec error");
	$db->exec("UPDATE fw SET openvpn='$openvpn'") or die ("exec error");
	$db->exec("UPDATE fw SET ext='$ext'") or die ("exec error");
	if (empty($ssh)) { $ssh="off"; }
	if (empty($icmp)) { $icmp="off"; }
	if (empty($openvpn)) { $openvpn="off"; }
	if (empty($ext)) { $ext="off"; }
	shell_exec("/bin/bash modules/fw/fw on $icmp $ssh $ext $openvpn");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
?>



<table>
	
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from fw ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$ext=$a["ext"];
$icmp=$a["icmp"];
$ssh=$a["ssh"];
$openvpn=$a["openvpn"];

}
?>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method"post">
		<ul>
		<li><p>Web mgmt IP</p></li>
		<li><input name="ext" type="text" maxlength="50" value="<?php echo $ext;?>"/>0.0.0.0/0 for all</li>
		<li><p>Access for all</p></li>
		<li><input name="ssh" type="checkbox" value="on" <?php echo $ssh == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />SSH</li>
		<li><input name="icmp" type="checkbox" value="on" <?php echo $icmp == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />ICMP</li>
		<li><input name="openvpn" type="checkbox" value="on" <?php echo $openvpn == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />OpenVPN</li>
		    <input type="hidden" name="fw_apply" value="fw_apply" />
	        <li><input type="submit" name="submit" value="Apply" /></li>
		</ul>
		</form>
	
</table>