<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
?>


<?php
    $ms = $_POST["ms"];
    if ($_POST['ms1'] == "ms2" ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET mail='$ms'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
$mail=$a["mail"];
}
?>

<div id="left">
<table>
<tr>	
    <form action="mail" method="post">
    <td>Mail module on/off:</td>
    <td><input type="checkbox" name="ms" value="on" <?php echo $mail == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="ms1" value="ms2" />
    </form>
</tr> 
</table>


<?php
if ($mail == "on" ) {
     include("mail_settings.php"); 
	include("mail_test.php");
 } ?>
</div>

<?php }
else { 
     header("Location: diened");
    }; 
?>
