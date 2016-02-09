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
	<button type="button" class="btn btn-primary" onclick="goBack()">Back</button>
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
	 ?>
	

<?php // SQLite - usuwanie notification
	if (!empty($del) && ($_POST['del1'] == "del2") ){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM users WHERE id='$del'") or die ($db->lastErrorMsg());
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	}
	?>


<div class="panel panel-primary">
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
	<td><input type="text" name="login" value="" class="form-control" required=""/></td>
	<td><input type="password" name="pass" value="" class="form-control" required=""/></td>
	<td><input type="email" name="mail" value="" class="form-control" required=""/></td>
	<td><input type="text" name="tel" value="" class="form-control" required=""/></td>
	<td><input type="text" name="smspin" value="" class="form-control" required=""/></td>
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
	<td><?php echo $a["login"];?></td>
	<td></td>
	<td><?php echo $a["mail"];?></td>
	<td><?php echo $a["tel"]; ?></td>
	<td><?php echo $a["smspin"]; ?></td>
	<?php if ($a['login'] != 'admin') { ?>
	<td>
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