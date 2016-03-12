

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">@</label>  
  <div class="col-md-4">
  <input id="mail_test" name="test_mail" placeholder="" class="form-control input-md" required="" type="text" value="" placeholder="test@nettemp.pl">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="mail_test"></label>
  <div class="col-md-4">
    <button id="send" name="send" value="send" class="btn btn-xs btn-success">Send test</button>
  </div>
</div>

</fieldset>
</form>

<?php
$test_mail = isset($_POST['test_mail']) ? $_POST['test_mail'] : '';
$send = isset($_POST['send']) ? $_POST['send'] : '';
if  ($send == "send") {
	 $test_mail1=escapeshellarg($test_mail);
	 if ( mail ($test_mail, 'Test mail from nettemp device', 'Working Fine.' ) ) {
?>

    		<center><span class="label label-success">Mail send ok</span></center>
    		<br>
<?php
	 } else { 
?>

			<center><span class="label label-alert">Cannot send mail</span></center>
			<br>

<?php
	 }

}

?>

