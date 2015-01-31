<?php
$i2c11_onoff = isset($_POST['i2c11_onoff']) ? $_POST['i2c11_onoff'] : '';
$i2c11_onoff1 = isset($_POST['i2c11_onoff1']) ? $_POST['i2c11_onoff1'] : '';

if (($i2c11_onoff1 == "i2c11_onoff2") ){
    $db->exec("UPDATE device SET i2c='$i2c11_onoff' where id='1' ") or die("exec error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$i2c22_onoff = isset($_POST['i2c22_onoff']) ? $_POST['i2c22_onoff'] : '';
$i2c22_onoff1 = isset($_POST['i2c22_onoff1']) ? $_POST['i2c22_onoff1'] : '';

if (($i2c22_onoff1 == "i2c22_onoff2") ){
    $db->exec("UPDATE device SET i2c='$i2c22_onoff' where id='1' ") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from device WHERE id='1'");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {

?>
   <form action="" method="post">
	<td>i2c-0 </td>
	<td><input type="checkbox" name="i2c11_onoff" value="i2c-0" <?php echo $a["i2c"] == 'i2c-0' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['i2c']; ?>"/>
	<input type="hidden" name="i2c11_onoff1" value="i2c11_onoff2" />
    </form>
    <form action="" method="post">
	<td>i2c-1</td>
	<td><input type="checkbox" name="i2c22_onoff" value="i2c-1" <?php echo $a["i2c"] == 'i2c-1' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['i2c']; ?>"/>
	<input type="hidden" name="i2c22_onoff1" value="i2c22_onoff2" />
    </form>
<font color="grey">Note: After "Scan for new sensors" this set can be overwritten</font>
<?php 
}
?>