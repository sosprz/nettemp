<?php
    $am_onoff = isset($_POST['am_onoff']) ? $_POST['am_onoff'] : '';
    $onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
    if (($onoff == "onoff") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE nt_settings SET value='$am_onoff' WHERE option='authmod'") or die ($db->lastErrorMsg());
	if ($am_onoff == "on") {
	    shell_exec ("sudo lighttpd-enable-mod auth");
	    shell_exec ("sudo service lighttpd restart");
	}
	if ($am_onoff != "on") {
	    shell_exec ("sudo lighttpd-disable-mod auth");
	    shell_exec ("sudo service lighttpd restart");
	}
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>
<div class="panel panel-default">
<div class="panel-heading">WWW Authmod</div>
<div class="panel-body">
    <form action="" method="post">
    <td><input type="checkbox" name="am_onoff" value="on" <?php echo $nts_authmod == 'on' ? 'checked="checked"' : ''; ?> data-toggle="toggle" data-size="mini" onchange="this.form.submit()" /></td>
    <input type="hidden" name="onoff" value="onoff" />
    </form>
<hr>
<?php
    if ($nts_authmod == "on" ) { 
		include('authmod_pass.php'); 
	} 
?>

</div>
</div>




