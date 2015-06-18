<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Change password</h3>
</div>
<div class="panel-body">

<?php

$pass=sha1(isset($_POST['pas1']) ? $_POST['pas1'] : '');
$pass2=sha1(isset($_POST['pas2']) ? $_POST['pas2'] : '');
$user=$_SESSION["user"];
   
$login_change = isset($_POST['login_change']) ? $_POST['login_change'] : '';

if ($login_change == "login_change1") { 
	if ($pass == $pass2) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET password='$pass' WHERE login='$user' ");
	?>
	<span class="label label-success">Password changed</span>
	<?php
	}	
	    else { ?>
		<span class="label label-warning">Password not match</span>
<?php
	} 
}
?>
	<form action="" method="post" role="form">
	  <input type="hidden" name="login_change" value="login_change1">
	    <div class="form-group">
		<label for="pwd">Password:</label>
		<input type="password" class="form-control" id="pwd" name="pas1" >
	    </div>
	    <div class="form-group">
		<label for="pwd2">Repeat:</label>
		<input type="password" class="form-control" id="pwd2" name="pas2" >
	    </div>
	  <input  type="submit" value="Change" class="btn btn-primary" />
        </form>   
 
</div></div>




