<div class="panel panel-info">
<div class="panel-heading">Change password</div>
<div class="panel-body">

<form class="form-horizontal" action="" method="post">
<fieldset>


<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">Password</label>
  <div class="col-md-4">
    <input id="passwordinput" name="pas1" placeholder="" class="form-control input-sm" required="" type="password">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">Repeat</label>
  <div class="col-md-4">
    <input id="passwordinput" name="pas2" placeholder="" class="form-control input-sm" required="" type="password">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="save"></label>
  <div class="col-md-4">
    <button type="submit" id="save" name="save" class="btn btn-xs btn-info">Save</button>
    	  <input type="hidden" name="login_change" value="login_change1">
  </div>
</div>

</fieldset>
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




