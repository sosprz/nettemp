<?php
    $tempnum = isset($_POST['tempnum']) ? $_POST['tempnum'] : '';
    $set_tempnum = isset($_POST['set_tempnum']) ? $_POST['set_tempnum'] : '';
    if  ($set_tempnum == "set_tempnum") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET tempnum='$tempnum' WHERE id='1'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>
<form action="" method="post">
   <tr><td>GPIO temperature sensor number</td><td>
    <select name="tempnum" onchange="this.form.submit()">
    <?php foreach (range(1, 10) as $num) { ?>
        <option <?php echo $a['tempnum'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num; ?></option>   
    <?php } ?>
    </select>    
    </td>
    </tr>
    <input type="hidden" name="set_tempnum" value="set_tempnum" />
</form>

<?php
}
?>
