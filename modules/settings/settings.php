<?php include('modules/login/login_check.php'); if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { ?>
<?php
    $rrd_onoff = isset($_POST['rrd_onoff']) ? $_POST['rrd_onoff'] : '';
    $rrd_onoff1 = isset($_POST['rrd_onoff1']) ? $_POST['rrd_onoff1'] : '';
    if (($rrd_onoff1 == "rrd_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET rrd='$rrd_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    $gpio_onoff = isset($_POST['gpio_onoff']) ? $_POST['gpio_onoff'] : '';
    $gpio_onoff1 = isset($_POST['gpio_onoff1']) ? $_POST['gpio_onoff1'] : '';
    if (($gpio_onoff1 == "gpio_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET gpio='$gpio_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    $hc_onoff = isset($_POST['hc_onoff']) ? $_POST['hc_onoff'] : '';
    $hc_onoff1 = isset($_POST['hc_onoff1']) ? $_POST['hc_onoff1'] : '';
    if (($hc_onoff1 == "hc_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET highcharts='$hc_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $ss_onoff = isset($_POST['ss_onoff']) ? $_POST['ss_onoff'] : '';
    $ss_onoff1 = isset($_POST['ss_onoff1']) ? $_POST['ss_onoff1'] : '';
    if (($ss_onoff1 == "ss_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET sms='$ss_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

    $ms_onoff = isset($_POST['ms_onoff']) ? $_POST['ms_onoff'] : '';
    $ms_onoff1 = isset($_POST['ms_onoff1']) ? $_POST['ms_onoff1'] : '';
    if (($ms_onoff1 == "ms_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET mail='$ms_onoff' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$rrd=$a["rrd"];
$hc=$a["highcharts"];
$ss=$a["sms"];
$ms=$a["mail"];
$gpio=$a["gpio"];
}
?>

<span class="belka">&nbsp View settings<span class="okno">
    <table>
    <tr>	
    <form action="settings" method="post">
    <td>RRD</td>
    <td><input type="checkbox" name="rrd_onoff" value="on" <?php echo $rrd == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="rrd_onoff1" value="rrd_onoff2" />
    </form>
    </tr> 
    <tr>	
    <form action="settings" method="post">
    <td>Highcharts</td>
    <td><input type="checkbox" name="hc_onoff" value="on" <?php echo $hc == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="hc_onoff1" value="hc_onoff2" />
    </form>
    </tr> 
    </table>
</span></span>

<span class="belka">&nbsp SMS settings<span class="okno">
    <table>
    <tr>
    <form action="settings" method="post">
    <td>SMS</td>
    <td><input type="checkbox" name="ss_onoff" value="on" <?php echo $ss == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="ss_onoff1" value="ss_onoff2" />
    </form>
    </tr>
    </table>
<?php include('modules/sms/html/sms.php'); ?>
</span></span>

<span class="belka">&nbsp Mail settings<span class="okno">
    <table>
    <form action="settings" method="post">
    <td>Mail</td>
    <td><input type="checkbox" name="ms_onoff" value="on" <?php echo $ms == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="ms_onoff1" value="ms_onoff2" />
    </form>
    </table>
<?php include('modules/mail/html/mail.php'); ?>
</span></span>

<span class="belka">&nbsp Other settings<span class="okno">
    <table>
    <form action="settings" method="post">
    <td>Gpio</td>
    <td><input type="checkbox" name="gpio_onoff" value="on" <?php echo $gpio == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio_onoff1" value="gpio_onoff2" />
    </form>
    </table>
</span></span>

<?php } 
else { header("Location: denied"); }; ?>
