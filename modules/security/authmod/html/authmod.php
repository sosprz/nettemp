<?php
    $am_onoff = isset($_POST['am_onoff']) ? $_POST['am_onoff'] : '';
    $onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
    if (($onoff == "onoff") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE settings SET authmod='$am_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
	if ($am_onoff == "on") {
	    shell_exec ("sudo lighttpd-enable-mod auth");
	    shell_exec ("sudo service lighttpd reload");
	}
	if ($am_onoff != "on") {
	    shell_exec ("sudo lighttpd-disable-mod auth");
	    shell_exec ("sudo service lighttpd reload");
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
$am=$a["authmod"];

}
?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">WWW Authmod</h3>
</div>
<div class="panel-body">
    <form action="" method="post">
    <td><input type="checkbox" name="am_onoff" value="on" <?php echo $am == 'on' ? 'checked="checked"' : ''; ?> data-toggle="toggle" data-size="mini" onchange="this.form.submit()" /></td>
    <input type="hidden" name="onoff" value="onoff" />
    </form>
<hr>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$am=$a["authmod"];
}
?>
<?php
    if ($am == "on" ) { ?>
    <?php 
	include('authmod_pass.php'); 
    ?>
<?php	 } ?>

</div>
</div>




