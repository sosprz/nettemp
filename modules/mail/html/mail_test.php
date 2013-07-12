<?php
$mail_test=$_POST['mail_test'];
if  ($_POST['mail_test1'] == "mail_test2") {
    $cmd="modules/mail/mail_test $mail_test";
    shell_exec($cmd); 
    }
?>
<table>
<tr>	
    <form action="mail" method="post">
    <td>Send test mail to:</td>
    <td><input type="text" name="mail_test" size="25" value="xxx_test@mail" /></td>
    <input type="hidden" name="mail_test1" value="mail_test2" />
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
    </form>
</tr>		
</table>
