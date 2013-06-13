<?php
    $smsc = $_POST["smsc"];
    $smsc_id = $_POST["smsc_id"];
    if (!empty($smsc) && ($_POST['smsc1'] == "smsc2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sms_settings SET smsc='$smsc' WHERE default_dev='on'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
?> 

<?php
$sms_test = $_POST["sms_test"];  //sql
if  ($_POST['sms_test1'] == "sms_test2") {
	$cmd="modules/sms/sms_test $sms_test";
	shell_exec($cmd); 
    }
?>

<table><tr>
<form action="sms" method="post"> 	
<td>SMS Center number</td>
<td><input type="text" name="smsc" size="25" value="<?php echo $a["smsc"]; ?>" /></td>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td></tr>
<input type="hidden" name="smsc_id" value="<?php echo $a["id"]; ?>" />
<input type="hidden" name="smsc1" value="smsc2" />
</form>




<tr>	
    <form action="sms" method="post">
    <td>Send test sms to</td>
    <td><input type="text" name="sms_test" size="25" value="ex. 111222333" /></td>
    <input type="hidden" name="sms_test1" value="sms_test2" />
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
    </form>
</tr>		
</table>




