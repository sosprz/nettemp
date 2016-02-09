<?php
    if (!file_exists("/etc/lighttpd/conf-enabled/05-auth.conf")) {
	echo "Status: disabled"; 
	}
	else {
	    echo "Status: enabled"; 
	}
?>
<hr>
<form class="form-horizontal" method="post" role="form">
<fieldset>


<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">Password</label>
  <div class="col-md-4">
    <input id="passwordinput" name="pas1" placeholder="" class="form-control input-md" required="" type="password">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">Repeat</label>
  <div class="col-md-4">
    <input id="passwordinput" name="pas2" placeholder="" class="form-control input-md" required="" type="password">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="save"></label>
  <div class="col-md-4">
    <button id="save" name="save" class="btn btn-xs btn-info">Save</button>
    <input type="hidden"  name="chg" value="chg2"/>
    <input type="hidden" name="login_change" value="login_change1">
  </div>
</div>

</fieldset>
</form>




<?php
$pas1 = isset($_POST['pas1']) ? $_POST['pas1'] : '';
$pas2 = isset($_POST['pas2']) ? $_POST['pas2'] : '';
$chg = isset($_POST['chg']) ? $_POST['chg'] : '';
if ($chg == "chg2") { 
	if ((!empty($pas1)) && (!empty($pas2)) && ($pas1 == $pas2)) {
	    $filename = "/etc/lighttpd/.lighttpdpassword";
	    $output = "admin:$pas2\n";
	    $filehandle = fopen($filename, 'w');
	    fwrite($filehandle, $output);
	    fclose($filehandle);
	    //shell_exec("sudo service lighttpd reload");
	?>
	 <span class="label label-psuccess">Password changed</span>
	<?php

	}	
	else { ?>
	 <span class="label label-danger">Password do not match or empty</span>
	<?php
	} }
	?>





