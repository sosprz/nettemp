<?php
    $radius = isset($_POST['radius']) ? $_POST['radius'] : '';
    $ssh = isset($_POST['ssh']) ? $_POST['ssh'] : '';
    $icmp = isset($_POST['icmp']) ? $_POST['icmp'] : '';
    $openvpn = isset($_POST['openvpn']) ? $_POST['openvpn'] : '';
    $ext = isset($_POST['ext']) ? $_POST['ext'] : '';
    $fw_apply = isset($_POST['fw_apply']) ? $_POST['fw_apply'] : '';
    if (($fw_apply == "fw_apply") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE fw SET ssh='$ssh'") or die ("exec error");
	$db->exec("UPDATE fw SET icmp='$icmp'") or die ("exec error");
	$db->exec("UPDATE fw SET openvpn='$openvpn'") or die ("exec error");
	$db->exec("UPDATE fw SET ext='$ext'") or die ("exec error");
	$db->exec("UPDATE fw SET radius='$radius'") or die ("exec error");
	if (empty($ssh)) { $ssh="off"; }
	if (empty($icmp)) { $icmp="off"; }
	if (empty($openvpn)) { $openvpn="off"; }
	if (empty($ext)) { $ext="off"; }
	if (empty($radius)) { $radius="off"; }
	shell_exec("/bin/bash modules/security/fw/fw on $icmp $ssh $ext $openvpn $radius");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
?>


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
$radius=$a["radius"];

}
?>
<div class="panel panel-default">
<div class="panel-heading">Settings</div>
<div class="panel-body">
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal">
		<div class="col-md-4">
    		<label>Management IP</label>
		<input name="ext" type="text" maxlength="50" value="<?php echo $ext;?>" class="form-control input-sm" required=""/> 
		<span id="helpBlock" class="help-block">Example: Single IP 84.84.84.84/32, All ip 0.0.0.0/0</span>
		</div>
		 <span class="label label-primary">Allow services for all IP:</span><br>
		<span class="label label-info">SSH</span>
		<input name="ssh" type="checkbox" value="on" <?php echo $ssh == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
		<span class="label label-info">ICMP</span>
		<input name="icmp" type="checkbox" value="on" <?php echo $icmp == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
		<span class="label label-info">OpenVPN</span>
		<input name="openvpn" type="checkbox" value="on" <?php echo $openvpn == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
		<span class="label label-info">RADIUS</span>
		<input name="radius" type="checkbox" value="on" <?php echo $radius == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" />
		</p>
		<input type="hidden" name="fw_apply" value="fw_apply" />
		<br>
	        <input type="submit" name="submit" value="Save" class="btn btn-default" />
		</form>
</div>
</div>

