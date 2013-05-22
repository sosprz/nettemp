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






<span class="belka">&nbsp SMS settings<span class="okno">

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from sms_settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
?>

<table>
<tr>	
    <form action="sms" method="post">
    <td>Name:</td>
    <td><?php echo $a["name"]; ?></td>
    
</tr>
<tr>	
    <td>Device:</td><td><?php echo $a["dev"]; ?></td>
    <form action="sms" method="post"> 	
    <input type="hidden" name="dd" value="<?php echo $a["id"]; ?>" />
    <input type="hidden" type="submit" name="dd1" value="dd2" />
   <td><input type="image" src="media/ico/Close-2-icon.png"  /></td></tr>
    </form>

</tr>

<tr>	
    <form action="sms" method="post"> 	
    <td>SMS Center number:</td>
    <td><input type="text" name="smsc" size="25" value="<?php echo $a["smsc"]; ?>" /></td>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td></tr>
<input type="hidden" name="smsc_id" value="<?php echo $a["id"]; ?>" />
<input type="hidden" name="smsc1" value="smsc2" />
</form>

<form action="sms" method="post"> 	
<tr><td>Set default device:</td>
<td><input type="checkbox" name="name" value="on" <?php echo $a["default_dev"] == 'on' ? 'checked="checked"' : ''; ?>  /></td>
<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td></tr>
<input type="hidden" name="sd" value="<?php echo $a["id"]; ?>" />
<input type="hidden" name="sd1" value="sd2" />

    
    </form>
</tr>
</table>
<?php }
	
	?>





</span></span>

