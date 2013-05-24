<?php
session_start();
	   include('modules/login/login_check.php');
		if ($numRows1 == 1 && ($perms == "ops" || $perms == "adm" )) { 
		
		?>
<div id="left">

<?php
    $ss = $_POST["ss"];
    if (($_POST['ss1'] == "ss2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE settings SET sms='$ss'") or die ($db->lastErrorMsg());
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
$sms=$a["sms"];
}
?>
<table>
<tr>	
    <form action="sms" method="post">
    <td>SMS module on/off:</td>
    <td><input type="checkbox" name="ss" value="on" <?php echo $sms == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="ss1" value="ss2" />
    </form>
</tr> 
</table>


<?php
if ($sms == "on" ) {
?>
	<?php include("sms_settings.php"); ?>
	<?php include("sms_scan.php"); ?>
<?php } ?>
</div>	 

<?php }
else { 
  	  header("Location: diened");
    }; 
	 ?>
