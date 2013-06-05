<?php
$sms_test = $_POST["sms_test"];  //sql
if  ($_POST['sms_test1'] == "sms_test2") {
	$cmd="modules/sms/sms_test $sms_test";
	shell_exec($cmd); 
    }
?>

<table>
<tr>	
    <form action="sms" method="post">
    <td>Send test sms to</td>
    <td><input type="text" name="sms_test" size="25" value="ex. 111222333" /></td>
    <input type="hidden" name="sms_test1" value="sms_test2" />
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
    </form>
</tr>		
</table>
