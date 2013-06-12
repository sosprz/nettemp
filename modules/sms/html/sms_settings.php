<?php
    $sd = $_POST["sd"];
    if (!empty($sd) && ($_POST['sd1'] == "sd2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sms_settings SET default_dev='off'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE sms_settings SET default_dev='on' WHERE id='$sd'") or die ($db->lastErrorMsg());
  	 header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
?> 

<?php
    $smsc = $_POST["smsc"];
    $smsc_id = $_POST["smsc_id"];
    if (!empty($smsc) && ($_POST['smsc1'] == "smsc2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sms_settings SET smsc='$smsc' WHERE id='$smsc_id'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
     } 
?> 

<?php 
    $dd = $_POST["dd"];
    if (!empty($dd) && ($_POST['dd1'] == "dd2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("DELETE FROM sms_settings WHERE id='$dd'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>


<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from sms_settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
?>







<table>

<tr><td>
<select>
   <option>Device <?php echo $a["name"]; ?> <?php echo $a["dev"]; ?></option>
</select>
</td>
<!--<tr>	
    <form action="sms" method="post"> 	
    <td>SMS Center number</td>
    <td><input type="text" name="smsc" size="25" value="<?php echo $a["smsc"]; ?>" /></td>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td></tr>
<input type="hidden" name="smsc_id" value="<?php echo $a["id"]; ?>" />
<input type="hidden" name="smsc1" value="smsc2" />
</form>-->

<form action="sms" method="post"> 	
<td><input type="submit" name="name" value="Set default device" /> </td>
<input type="hidden" name="sd" value="<?php echo $a["id"]; ?>" />
<input type="hidden" name="sd1" value="sd2" />
</form>
</tr>
</table>
<?php } 
?>
