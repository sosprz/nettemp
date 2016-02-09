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
<div class="panel panel-primary">
<div class="panel-heading">Other</div>
<div class="panel-body">

<?php
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from mail_settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>
<div class="row">
<form action="" method="post">
    <div class="col-sm-2">Send readings errors</div>
    <div class="col-sm-1"><input data-toggle="toggle" data-size="mini" onchange="this.form.submit()"  type="checkbox" name="senderrors" value="on" <?php echo $a['error'] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></div>
    <input type="hidden" name="sende" value="sende" />
</form>
</div>
<?php
    }
?>
</div>
</div>