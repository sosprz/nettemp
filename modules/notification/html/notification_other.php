<?php
    $senderrors = isset($_POST['senderrors']) ? $_POST['senderrors'] : '';
    $sende = isset($_POST['sende']) ? $_POST['sende'] : '';
    if (($sende == "sende") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE mail_settings SET error='$senderrors' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
<span class="belka">&nbsp Other <span class="okno">
<?php
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from mail_settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>

<form action="" method="post">
    <td>Send readings errors</td>
    <td><input type="checkbox" name="senderrors" value="on" <?php echo $a['error'] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="sende" value="sende" />
</form>
<?php
    }
?>
</span></span>