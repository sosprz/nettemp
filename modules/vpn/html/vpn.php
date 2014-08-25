<?php include('conf.php'); session_start(); include('modules/login/login_check.php'); if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { ?>
<span class="belka">&nbsp OpenVPN status<span class="okno">
<?php passthru('/etc/init.d/openvpn status'); ?>
<br />
<?php passthru('cat /etc/openvpn/openvpn.conf |grep port');

if ($_POST['disable'] == "disable") { 
shell_exec ("/bin/bash modules/vpn/install disable");
header("location: " . $_SERVER['REQUEST_URI']);
  exit();
}

if ($_POST['enable'] == "enable") { 
shell_exec ("/bin/bash modules/vpn/install enable");
header("location: " . $_SERVER['REQUEST_URI']);
  exit();

}

?>
<table><tr>
<form action="index.php?id=vpn" method="post">
<input type="hidden" name="enable" value="enable">
<td><input  type="submit" value="Enable"  /></td>
</form>
<form action="index.php?id=vpn" method="post">
<input type="hidden" name="disable" value="disable">
<td><input  type="submit" value="Disable"  /></td>
</form>
</tr></table>
</span></span>

<?php include("vpn_add.php"); ?>
<?php include("vpn_ca.php"); ?>

<?php } else { header("Location: diened"); }; 
