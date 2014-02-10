<?php
$test_mail=$_POST['test_mail'];
if  ($_POST['mail_test1'] == "mail_test2") {
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

<table>
<tr>	
    <form action="mail" method="post">
    <td>Send test mail to:</td>
    <td><input type="text" name="test_mail" size="25" value="<?php echo $a["test_mail"]; ?>" /></td>
    <input type="hidden" name="mail_test1" value="mail_test2" />
    <td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
    </form>
</tr>		
</table>

<?php  }	?>
