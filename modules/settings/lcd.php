<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">LCD </h3>
</div>
<div class="panel-body">
<?php
    $lcd = isset($_POST['lcd']) ? $_POST['lcd'] : '';
    $lcdon = isset($_POST['lcdon']) ? $_POST['lcdon'] : '';
    
    if (($lcd == "lcd") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET lcd='$lcdon' WHERE id='1'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>



    <table>
    <tr>	
    <form action="settings" method="post">
    <td>LCD 1602 HD44780 PCF8574 I2C</td>
    <td><input type="checkbox" name="lcdon" value="on" <?php echo $lcd == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="lcd" value="lcd" />
    </form>
    </tr> 
    </table>
</div>
</div>
