<span class="belka">&nbsp Add Notification:<span class="okno">
<table>
<tr><td></td><td><img src="media/ico/User-Preppy-Blue-icon.png" ></td><td><img src="media/ico/message-icon.png" ></td><td><img src="media/ico/phone-blue-glow-icon.png" ></td><td><img src="media/ico/message-icon.png" ></td><td><img src="media/ico/phone-blue-glow-icon.png" ></td></tr>
<tr>	
	<form action="notification" method="post">
	<td></td>
	<td><input type="text" name="name" size="20" value="" /></td>
	<td><input type="text" name="mail" size="20" value="" /></td>
	<td><input type="text" name="tel" size="20" value="" /></td>
	<td><input type="checkbox" name="mail_alarm" size="2" value="yes" /></td>
	<td><input type="checkbox" name="sms_alarm" size="2" value="yes" /></td>
	<input type="hidden" name="add_recipient" value="add_recipient1" />
	<td><input type="image" src="media/ico/Add-icon.png" /></td>
	</tr>
	</form>

<?php

//$db = new SQLite3('dbf/nettemp.db');
//$rows = $db->query("SELECT COUNT(*) as count FROM recipient");
//$row = $rows->fetchArray();
//$numRows = $row['count'];
////if ($numRows == 0 ) { echo "<span class=\"brak\"><img src=\"media/ico/Sign-Stop-icon.png\" /></span>"; }
//$r = $db->query("select * from recipient ");
//while ($a = $r->fetchArray()) { 
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from recipient ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
	<tr>
	<td><img src="media/ico/User-Preppy-Blue-icon.png" ></td>
	<td><?php echo $a["name"];?></td>
	<td><?php echo $a["mail"];?></td>
	<td><?php echo $a["tel"]; ?></td>
	
	<form action="notification" method="post"> 	
	<input type="hidden" name="upd_notifi_id" value="<?php echo $a["id"]; ?>" />
	<td><input type="checkbox" name="mail" value="yes" <?php echo $a["mail_alarm"] == 'yes' ? 'checked="checked"' : ''; ?> /></td>
	<td><input type="checkbox" name="sms" value="yes" <?php echo $a["sms_alarm"] == 'yes' ? 'checked="checked"' : ''; ?> /></td>
	<input type="hidden" name="upd_notifi_sms1" value="upd_notifi_sms2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" /></td>
	</form>
	
	<form action="notification" method="post"> 	
	<input type="hidden" name="del_notifi" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" type="submit" name="del_notifi1" value="del_notifi2" />
   <td><input type="image" src="media/ico/Close-2-icon.png"  /></td></tr>
	</form>
<?php }


		
	
		?>
	
</tr></table>
</span></span>