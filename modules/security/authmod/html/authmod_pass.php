<?php
    if (!file_exists("/etc/lighttpd/conf-enabled/05-auth.conf")) {
	echo "Status: disabled"; 
	}
	else {
	    echo "Status: enabled"; 
	}
?>
<hr>


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
      <input  type="submit" value="Save" class="btn btn-primary" />
	<input type="hidden"  name="chg" value="chg2"/>
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





