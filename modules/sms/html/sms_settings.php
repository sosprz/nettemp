<?php
    $smsc = $_POST["smsc"];
    if (!empty($smsc) && ($_POST['smsc1'] == "smsc2") ){
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
if  ($_POST['sms_test1'] == "sms_test2") {
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
<table <table class="table table-striped">>
<tr>
<form action="" method="post"> 	
<td>SMS Center number</td>
<td><input type="text" name="smsc" size="25" value="<?php echo $a["smsc"]; ?>" /></td>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td></tr>
<input type="hidden" name="smsc1" value="smsc2" />
</form>

<tr>	
    <form action="" method="post">
    <td>Send test sms to</td>
    <td><input type="text" name="sms_test" size="25" value="<?php echo $a["sms_test"]; ?>" /></td>
    <input type="hidden" name="sms_test1" value="sms_test2" />
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
    </form>
</tr>		
</table>
<?php }?>



