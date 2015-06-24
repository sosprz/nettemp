<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Change password</h3>
</div>
<div class="panel-body">

	<form action="" method="post" role="form">
	  <input type="hidden" name="login_change" value="login_change1">
	    <div class="form-group">
		<label for="pwd">Password:</label>
		<input type="password" class="form-control" id="pwd" name="pas1" required="" >
	    </div>
	    <div class="form-group">
		<label for="pwd2">Repeat:</label>
		<input type="password" class="form-control" id="pwd2" name="pas2" required="" >
	    </div>
	  <input  type="submit" value="Save" class="btn btn-primary" />
        </form>   


<?php

$pas1=sha1(isset($_POST['pas1']) ? $_POST['pas1'] : '');
$pas2=sha1(isset($_POST['pas2']) ? $_POST['pas2'] : '');
$user=$_SESSION["user"];
   
$login_change = isset($_POST['login_change']) ? $_POST['login_change'] : '';

if ($login_change == "login_change1") { 
	if ((!empty($pas1)) && (!empty($pas2)) && ($pas1 == $pas2)) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE users SET password='$pas1' WHERE login='admin' ");
	?>
	<span class="label label-success">Password changed</span>
	<?php
	}	
	    else { ?>
		<span class="label label-danger">Password do not match or empty</span>
<?php
	} 
}
?>
 
</div></div>




