<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">LCD </h3>
</div>
<div class="panel-body">
<?php
    $lcd = isset($_POST['lcd']) ? $_POST['lcd'] : '';
    $lcdon = isset($_POST['lcdon']) ? $_POST['lcdon'] : '';
    $lcd4 = isset($_POST['lcd4']) ? $_POST['lcd4'] : '';
    $lcdon4 = isset($_POST['lcdon4']) ? $_POST['lcdon4'] : '';
    
    if (($lcd == "lcd") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$lcdon' WHERE option='lcd'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE nt_settings SET value='off' WHERE option='lcd4'") or die ($db->lastErrorMsg());
    shell_exec("sudo touch tmp/reboot");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
    if (($lcd4 == "lcd4") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE nt_settings SET value='$lcdon4' WHERE option='lcd4'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE nt_settings SET value='off' WHERE option='lcd'") or die ($db->lastErrorMsg());
    shell_exec("sudo touch tmp/reboot");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$lcd=$nts_lcd;
$lcd4=$nts_lcd4;


?>
    
    <form action="" method="post">
    <label>LCD 1602 HD44780 PCF8574 I2C 2x16</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="lcdon" value="on" <?php echo $lcd == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="lcd" value="lcd" />
    </form>
    <form action="" method="post">
    <label>LCD 1602 HD44780 PCF8574 I2C 4x20</label>
    <input data-toggle="toggle" data-size="mini" onchange="this.form.submit()" type="checkbox" name="lcdon4" value="on" <?php echo $lcd4 == 'on' ? 'checked="checked"' : ''; ?> /></td>
    <input type="hidden" name="lcd4" value="lcd4" />
    </form>

</div>
</div>
