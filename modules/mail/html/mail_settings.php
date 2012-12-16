
<span class="belka">&nbsp Mail settings:<span class="okno">


<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from mail_settings ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {
?>

<table>
<!--<tr>	
	<form action="mail" method="post">
	<td>Mail address:</td>
	<td><input type="text" name="address" size="25" value="<?php echo $a["address"]; ?>" /></td>
	<input type="hidden" name="change_address1" value="change_address2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr> -->
<tr>	
	<form action="mail" method="post">
	<td>Username:</td>
	<td><input type="text" name="user" size="25" value="<?php echo $a["user"]; ?>" /></td>
	<input type="hidden" name="change_user1" value="change_user2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr>
<tr>	
	<form action="mail" method="post">
	<td>Server smtp:</td>
	<td><input type="text" name="host" size="25" value="<?php echo $a["host"]; ?>" /></td>
	<input type="hidden" name="change_host1" value="change_host2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr>
<tr>	
	<form action="mail" method="post">
	<td>Port:</td>
	<td><input type="text" name="port" size="25" value="<?php echo $a["port"]; ?>" /></td>
	<input type="hidden" name="change_port1" value="change_port2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr>
<tr>	
	<form action="mail" method="post">
	<td>Password:</td>
	<td><input type="password" name="password" size="25" value="<?php echo $a["password"]; ?>" /></td>
	<input type="hidden" name="change_password1" value="change_password2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr>


</table>
<?php }
		
		?>
	
</span></span>
<span class="belka">&nbsp Send test mail:<span class="okno">
<table>
<tr>	
	<form action="mail" method="post">
	<td>Send test mail:</td>
	<td><input type="text" name="mail_test" size="25" value="" /></td>
	<input type="hidden" name="mail_test1" value="mail_test2" />
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png"  /></td>
	</form>
</tr>		
</table>
</span></span>

