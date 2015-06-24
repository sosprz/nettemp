<?php
    $smsc = $_POST["smsc"];
    if (!empty($smsc) && ($_POST['smsc1'] == "smsc1") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sms_settings SET smsc='$smsc' WHERE default_dev='on'") or die ($db->lastErrorMsg());
    $set_smsc="gammu -c tmp/gammurc setsmsc 1 $smsc";
	 shell_exec($set_smsc);
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
?> 

<?php
$sms_test = $_POST["sms_test"];
if  ($_POST['sms_test1'] == "sms_test1") {
	$db = new PDO('sqlite:dbf/nettemp.db');
   $db->exec("UPDATE sms_settings SET sms_test='$sms_test' WHERE default_dev='on'") or die ($db->lastErrorMsg());
	$cmd="modules/sms/sms_test";
	shell_exec($cmd); 
    }
?>


<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from sms_settings WHERE default_dev='on' ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { ?>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="smsc">SMS center number</label>  
  <div class="col-md-4">
  <input id="smsc" name="smsc" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a["smsc"]; ?>">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="smsc1"></label>
  <div class="col-md-4">
    <button id="smsc1" name="smsc1"  value="smsc1" class="btn btn-primary">Save </button>
  </div>
</div>

</fieldset>
</form>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="sms_test">Number</label>  
  <div class="col-md-4">
  <input id="sms_test" name="sms_test" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a["sms_test"]; ?>">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="sms_test1"></label>
  <div class="col-md-4">
    <button id="sms_test1" name="sms_test1" value="sms_test1" class="btn btn-primary">Send test </button>
  </div>
</div>

</fieldset>
</form>



<?php }?>



