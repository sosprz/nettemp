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

<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Function number</label>
  <div class="col-md-1">
    <select id="selectbasic" name="tempnum" onchange="this.form.submit()" class="form-control input-sm">
	<?php foreach (range(1, 10) as $num) { ?>
        <option <?php echo $a['tempnum'] == "$num" ? 'selected="selected"' : ''; ?> value="<?php echo $num; ?>"><?php echo $num; ?></option>   
	<?php } ?>
    </select>
  </div>
</div>
</fieldset>
<input type="hidden" name="set_tempnum" value="set_tempnum" />
</form>





<?php
}
?>
