<?php
$mail_test=$_POST['mail_test'];
if  ($_POST['mail_test1'] == "mail_test2") {
    $cmd="modules/mail/mail_test $mail_test";
    shell_exec($cmd); 
    }
$db = new PDO('sqlite:dbf/nettemp.db');
$db->exec("UPDATE mail_settings SET test_mail='$mail_test'") or die ($db->lastErrorMsg());

?>

<?php
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from mail_settings ");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
?>

<table>
<tr>	
    <form action="mail" method="post">
    <td>Send test mail to:</td>
    <td><input type="text" name="mail_test" size="25" value="<?php echo $a["test_mail"]; ?>" /></td>
    <input type="hidden" name="mail_test1" value="mail_test2" />
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
    </form>
</tr>		
</table>

<?php  }	?>
