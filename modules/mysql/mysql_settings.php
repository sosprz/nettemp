<?php
$cfile = 'modules/mysql/mysql_conf.php';

$fh = fopen($cfile, 'r');
$theData = fread($fh, filesize($cfile));
$cread = array();
$my_array = explode(PHP_EOL, $theData);
foreach($my_array as $line)
{
    $tmp = explode("=", $line);
    $cread[$tmp[0]] = $tmp[1];
}
fclose($fh);
$a=$cread;
$a=str_replace("'", "",$a);
$a=str_replace(";", "",$a);

print_r($a);




$db = isset($_POST['db']) ? $_POST['db'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$host = isset($_POST['host']) ? $_POST['host'] : '';



$change_password1 = isset($_POST['change_password1']) ? $_POST['change_password1'] : '';
if  ($change_password1 == "change_password2") {
	if (!file_exists($cfile)) {
		$cmd = "sudo touch $cfile && sudo chown www-data $cfile && sudo chmod 600 $cfile";
		shell_exec($cmd);
	
	}
		$fh = fopen($cfile, 'w');


$conf = array (
	 '$IP' => "$ip",
	 '$USER' => "$user",
	 '$PASS' => "$pass",
	 '$DB' => "$db"
    );
  

		foreach ($conf as $index => $string) {
    		fwrite($fh, $index."='".$string."';\n");
		}
		header("location: " . $_SERVER['REQUEST_URI']);
    	exit();
}

?>




<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Form Name -->

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">IP</label>  
  <div class="col-md-4">
  <input id="user" name="ip" placeholder="192.168.10.1:3306" class="form-control input-md" type="text" value="<?php echo $a['$IP']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">Username</label>  
  <div class="col-md-4">
  <input id="user" name="user" placeholder="ex. nettemp@nettemp.pl" class="form-control input-md" required="" type="text" value="<?php echo $a['$USER']; ?>">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password</label>
  <div class="col-md-4">
    <input id="password" name="password" placeholder="" class="form-control input-md" required="" type="password" value="<?php echo $a['$PASS']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">DB</label>  
  <div class="col-md-4">
  <input id="host" name="host" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a['$DB']; ?>">
    
  </div>
</div>



<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="mailsave"></label>
  <div class="col-md-4">
    <input type="hidden" name="change_password1" value="change_password2" />
    <button id="mailsave" name="mailsave" class="btn btn-xs btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>

</div>


    








