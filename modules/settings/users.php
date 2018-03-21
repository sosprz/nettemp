<?php
$login = isset($_POST['login']) ? $_POST['login'] : '';
$pass=sha1(isset($_POST['pass']) ? $_POST['pass'] : '');
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$smspin = isset($_POST['smspin']) ? $_POST['smspin'] : '';
$smsts = isset($_POST['smsts']) ? $_POST['smsts'] : '';
$maila = isset($_POST['maila']) ? $_POST['maila'] : '';
$smsa = isset($_POST['smsa']) ? $_POST['smsa'] : '';
$perms = isset($_POST['perms']) ? $_POST['perms'] : '';
$ctr = isset($_POST['ctr']) ? $_POST['ctr'] : '';
$moment = isset($_POST['moment']) ? $_POST['moment'] : '';
$simple = isset($_POST['simple']) ? $_POST['simple'] : '';
$trigger = isset($_POST['trigger']) ? $_POST['trigger'] : '';

$id = isset($_POST['id']) ? $_POST['id'] : '';
$del = isset($_POST['del']) ? $_POST['del'] : '';
?>

<?php // SQLite - ADD RECIPIENT
	$add1 = isset($_POST['add1']) ? $_POST['add1'] : '';
	if ( $perms != 'adm' ) { $perms = 'usr'; }
	if (!empty($login)  && !empty($pass) && !empty($mail) && !empty($tel) && ($_POST['add1'] == "add2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	    $rows = $db->query("SELECT * FROM users WHERE login='$login' OR mail='$mail' OR tel='$tel'") or header("Location: html/errors/db_error.php");
	    $row = $rows->fetchAll();
	    $c = count($row);
	    if ( $c >= "1") { ?>
        <div class="panel panel-warning">
        <div class="panel-heading">Name <?php echo $login." or address ".$mail." or tel ".$tel ?> already exist in database.</div>
        <div class="panel-body">
	<button type="button" class="btn btn-success" onclick="goBack()">Back</button>
        </div>
        </div>
	<script>
	    function goBack() {
    	    window.history.back();
	    }
	    </script>
        <?php 
	    exit();
	    } 
	    else {
		$db->exec("INSERT OR IGNORE INTO users (login, password, mail, tel, smsa, maila, perms, ctr, simple, moment, trigger, at, smspin, smsts ) VALUES ('$login', '$pass', '$mail', '$tel', '$maila', '$smsa', '$perms', 'OFF', 'OFF', 'OFF', 'OFF', 'any', '$smspin', '$smsts')") or header("Location: html/errors/db_error.php");
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	    }
	}
	?>
	
	<?php 
	
	// SQLite - update 
	$update_maila = isset($_POST['update_maila']) ? $_POST['update_maila'] : '';
	$up_mail = isset($_POST['up_mail']) ? $_POST['up_mail'] : '';
	if ($up_mail == 'up_mail'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET maila='$update_maila' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

	$update_perms = isset($_POST['update_perms']) ? $_POST['update_perms'] : '';
	$up_perms = isset($_POST['up_perms']) ? $_POST['up_perms'] : '';
	if ($up_perms == 'up_perms'){
	if ( $update_perms != 'adm') { $update_perms = 'usr'; }
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET perms='$update_perms' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 

	$update_smsa = isset($_POST['update_smsa']) ? $_POST['update_smsa'] : '';
	$up_sms = isset($_POST['up_sms']) ? $_POST['up_sms'] : '';
	if ($up_sms == 'up_sms'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET smsa='$update_smsa' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

	$update_cam = isset($_POST['update_cam']) ? $_POST['update_cam'] : '';
	$up_cam = isset($_POST['up_cam']) ? $_POST['up_cam'] : '';
	if ($up_cam == 'up_cam'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET cam='$update_cam' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

    
	$update_smsts = isset($_POST['update_smsts']) ? $_POST['update_smsts'] : '';
	$up_smsts = isset($_POST['up_smsts']) ? $_POST['up_smsts'] : '';
	if ($up_smsts == 'up_smsts'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET smsts='$update_smsts' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

	$update_ctr = isset($_POST['update_ctr']) ? $_POST['update_ctr'] : '';
	$up_ctr = isset($_POST['up_ctr']) ? $_POST['up_ctr'] : '';
	if ($up_ctr == 'up_ctr'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET ctr='$update_ctr' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }
	
	$update_simple = isset($_POST['update_simple']) ? $_POST['update_simple'] : '';
	$up_simple = isset($_POST['up_simple']) ? $_POST['up_simple'] : '';
	if ($up_simple == 'up_simple'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET simple='$update_simple' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

	$update_trigger = isset($_POST['update_trigger']) ? $_POST['update_trigger'] : '';
	$up_trigger = isset($_POST['up_trigger']) ? $_POST['up_trigger'] : '';
	if ($up_trigger == 'up_trigger'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET trigger='$update_trigger' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
	
	$update_moment = isset($_POST['update_moment']) ? $_POST['update_moment'] : '';
	$up_moment = isset($_POST['up_moment']) ? $_POST['up_moment'] : '';
	if ($up_moment == 'up_moment'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET moment='$update_moment' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }

	$update_at = isset($_POST['update_at']) ? $_POST['update_at'] : '';
	$up_at = isset($_POST['up_at']) ? $_POST['up_at'] : '';
	if ($up_at == 'up_at'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET at='$update_at' WHERE id='$id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }
	 
	//change login
	$login_id = isset($_POST['login_id']) ? $_POST['login_id'] : '';
	$login_new = isset($_POST['login_new']) ? $_POST['login_new'] : '';
	$new_login = isset($_POST['new_login']) ? $_POST['new_login'] : '';
	if (!empty($login_id) && $new_login == 'new_login'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET login='$login_new' WHERE id='$login_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }
	//change mail
	$mail_id = isset($_POST['mail_id']) ? $_POST['mail_id'] : '';
	$mail_new = isset($_POST['mail_new']) ? $_POST['mail_new'] : '';
	$new_mail = isset($_POST['new_mail']) ? $_POST['new_mail'] : '';
	if (!empty($mail_id) && $new_mail == 'new_mail'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET mail='$mail_new' WHERE id='$mail_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }
	 
	 //change tel
	$tel_id = isset($_POST['tel_id']) ? $_POST['tel_id'] : '';
	$tel_new = isset($_POST['tel_new']) ? $_POST['tel_new'] : '';
	$new_tel = isset($_POST['new_tel']) ? $_POST['new_tel'] : '';
	if (!empty($tel_id) && $new_tel == 'new_tel'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET tel='$tel_new' WHERE id='$tel_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }
	 
	  //change smspin
	$pin_id = isset($_POST['pin_id']) ? $_POST['pin_id'] : '';
	$pin_new = isset($_POST['pin_new']) ? $_POST['pin_new'] : '';
	$new_pin = isset($_POST['new_pin']) ? $_POST['new_pin'] : '';
	if (!empty($pin_id) && $new_pin == 'new_pin'){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET smspin='$pin_new' WHERE id='$pin_id'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 }
	 
	 //change password
	$pass1=sha1(isset($_POST['pass1']) ? $_POST['pass1'] : '');
	$pass2=sha1(isset($_POST['pass2']) ? $_POST['pass2'] : '');
	$pass_change = isset($_POST['pass_change']) ? $_POST['pass_change'] : '';
	$pass_id = isset($_POST['pass_id']) ? $_POST['pass_id'] : '';
	
	if (!empty($pass_id) && $pass_change == "pass_change") { 
		if ((!empty($pass1)) && (!empty($pass2)) && ($pass1 == $pass2)) {
		$db = new PDO('sqlite:dbf/nettemp.db');
		$db->exec("UPDATE users SET password='$pass1' WHERE id='$pass_id' ") or die ($db->lastErrorMsg());
		$flag = "OK";
		}	else {$flag = "ERR";
			}
	}
	
	  // SQLite - usuwanie notification
	if (!empty($del) && ($_POST['del1'] == "del2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM users WHERE id='$del'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>


<div class="panel panel-default">
<div class="panel-heading">Users</div>

<div class="table-responsive">
<table class="table table-striped table-condensed small">
<thead><tr>
<th>Name</th>
<th>Password</th>
<th>Mail</th>
<th>Telephone</th>
<th>SMS pin</th>
<th></th>
</tr></thead>

    <tr>	
	<form action="" method="post">
	<td><input type="text" name="login" size="10" maxlength="30" value="" class="form-control" required=""/></td>
	<td><input type="password" name="pass" value="" class="form-control" required=""/></td>
	<td><input type="email" name="mail" size="25" maxlength="50" value="" class="form-control" /></td>
	<td><input type="text" name="tel" value="" class="form-control" /></td>
	<td><input type="text" name="smspin" value="" class="form-control" /></td>
	<input type="hidden" name="add1" value="add2" />
	<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span> </button></td>
	</form>
    </tr> 
<?php

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from users ");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) { 
?>
	<tr>
	<td>
	
	<?php if ($a["login"] != 'admin') { ?>
	 <form action="" method="post" style="display:inline!important;">
		<input type="text" name="login_new" size="10" maxlength="30" value="<?php echo $a["login"]; ?>" />
		<input type="hidden" name="login_id" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="new_login" value="new_login"/>
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
	<?php } else { echo $a["login"];}?>
	</td>
	
	<td>
	<form action="" method="post" style="display:inline!important;">
	<label>New :&nbsp</label><input type="password" name="pass1" size="15" maxlength="30" value=""  required=""/>
	<label>Repeat :&nbsp</label><input type="password" name="pass2" size="15" maxlength="30" value="" required=""/>
	<input type="hidden" name="pass_id" value="<?php echo $a["id"]; ?>" />
	<input type="hidden" name="pass_change" value="pass_change"/>
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
	</form>
	<?php if ($a["id"] == $pass_id && $flag == 'OK') { ?>
		
		<span class="label label-success">Chenged</span>
		
		<?php } elseif ($a["id"] == $pass_id && $flag == 'ERR') { ?>
		
			<span class="label label-danger">Error</span>
		<?php } ?>
		
	</td>
	
	<td>
	<form action="" method="post" style="display:inline!important;">
		<input type="text" name="mail_new" size="25" maxlength="50" value="<?php echo $a["mail"]; ?>" />
		<input type="hidden" name="mail_id" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="new_mail" value="new_mail"/>
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
	</td>
	
	<td>
	<form action="" method="post" style="display:inline!important;">
		<input type="text" name="tel_new" size="15" maxlength="50" value="<?php echo $a["tel"]; ?>" />
		<input type="hidden" name="tel_id" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="new_tel" value="new_tel"/>
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>
	</td>
	
	<td>
	<form action="" method="post" style="display:inline!important;">
		<input type="text" name="pin_new" size="10" maxlength="50" value="<?php echo $a["smspin"]; ?>" />
		<input type="hidden" name="pin_id" value="<?php echo $a["id"]; ?>" />
		<input type="hidden" name="new_pin" value="new_pin"/>
		<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
    </form>

	</td>
	
	<td>
	<?php if ($a['login'] != 'admin') { ?>
    <form action="" method="post"> 	
	    <input type="hidden" name="del" value="<?php echo $a["id"]; ?>" />
	    <input type="hidden" type="submit" name="del1" value="del2" />
	    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
	</form>
	<?php } ?>
	</td>
	</tr>
<?php }
?>
</table>
</div>
</div>



<?php include('perms.php');?>