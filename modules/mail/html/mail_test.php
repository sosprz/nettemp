<?php
$test_mail = isset($_POST['test_mail']) ? $_POST['test_mail'] : '';
$send = isset($_POST['send']) ? $_POST['send'] : '';
if  ($send == "send") {
	 $test_mail1=escapeshellarg($test_mail);
    $cmd="modules/mail/mail_test $test_mail1 'Test from your nettemp device' 'Test mail from Your nettemp device.'";
    shell_exec($cmd); 
    
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("UPDATE mail_settings SET test_mail='$test_mail'") or die ($db->lastErrorMsg());
}

?>

<?php
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from mail_settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Form Name -->
<legend>Send test mail</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">@</label>  
  <div class="col-md-4">
  <input id="mail_test" name="test_mail" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a['test_mail'];?>">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="mail_test"></label>
  <div class="col-md-4">
    <button id="send" name="send" value="send" class="btn btn-primary">Send test</button>
  </div>
</div>

</fieldset>
</form>

<?php  }	?>
