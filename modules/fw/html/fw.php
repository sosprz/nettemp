<?php
    $fw_onoff = $_POST["fw_onoff"];
    if (($_POST['onoff'] == "onoff") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET fw='$fw_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    if ($fw_onoff != "on") {
    shell_exec("/bin/bash modules/fw/fw off");
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
$fw=$a["fw"];

}
?>
<span class="belka">&nbsp Firewall settings<span class="okno">



<table>

<tr> <td><h2>Firewall</h2></td>
    <form action="fw" method="post">
    <td><input type="checkbox" name="fw_onoff" value="on" <?php echo $fw == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="onoff" value="onoff" />
    </form>
</tr> 
</table>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$fw=$a["fw"];
}
?>
<?php
    if ($fw == "on" ) { ?>
    <?php include('fw_settings.php'); ?>
<?php	 } ?>




</span></span>


