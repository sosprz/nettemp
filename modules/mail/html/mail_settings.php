<?php
$cfile = '/etc/msmtprc';

$fh = fopen($cfile, 'r');
$theData = fread($fh, filesize($cfile));
$cread = array();
$my_array = explode(PHP_EOL, $theData);
foreach($my_array as $line)
{
    $tmp = explode(" ", $line);
    $cread[$tmp[0]] = $tmp[1];
}
fclose($fh);
$a=$cread;




$address = isset($_POST['address']) ? $_POST['address'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$host = isset($_POST['host']) ? $_POST['host'] : '';
$port = isset($_POST['port']) ? $_POST['port'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$auth = isset($_POST['auth']) ? $_POST['auth'] : '';
$tls = isset($_POST['tls']) ? $_POST['tls'] : '';
$tlscheck = isset($_POST['tlscheck']) ? $_POST['tlscheck'] : '';


$change_password1 = isset($_POST['change_password1']) ? $_POST['change_password1'] : '';
if  ($change_password1 == "change_password2") {
	if (!file_exists($cfile)) {
		$cmd = "sudo touch $cfile && sudo chown www-data $cfile && sudo chmod 600 $cfile";
		shell_exec($cmd);
	
	}
		$fh = fopen($cfile, 'w');

		if(empty($address)||$address=='default'){
			$address=$user;
		}

$conf = array (
    'defaults' => '', 
    'tls' => "$tls",
    'tls_starttls' => "$tls",
 // 'tls_trust_file' => '/etc/ssl/certs/ca-certificates.crt',
    'tls_certcheck' => "$tlscheck",
    'account' => 'default',
	 'host' => "$host",
	 'port' => "$port",
	 'auth' => "$auth",
	 'user' => "$user",
	 'password' => "$password",
	 'from' => "$address",
	 'logfile' => '/var/log/msmtp.log'
    );
  

		foreach ($conf as $index => $string) {
    		fwrite($fh, $index." ".$string."\n");
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
  <label class="col-md-4 control-label" for="user">From</label>  
  <div class="col-md-2">
  <input id="user" name="address" placeholder="not required" class="form-control input-md" type="text" value="<?php echo $a['from']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">Username</label>  
  <div class="col-md-2">
  <input id="user" name="user" placeholder="ex. nettemp@nettemp.pl" class="form-control input-md" required="" type="text" value="<?php echo $a['user']; ?>">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password</label>
  <div class="col-md-2">
    <input id="password" name="password" placeholder="" class="form-control input-md" required="" type="password" value="<?php echo $a['password']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">Server SMTP</label>  
  <div class="col-md-2">
  <input id="host" name="host" placeholder="smtp.gmail.com" class="form-control input-md" required="" type="text" value="<?php echo $a['host']; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="port">Port</label>  
  <div class="col-md-1">
  <input id="port" name="port" placeholder="587" class="form-control input-md" required="" type="text" value="<?php echo $a['port']; ?>">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="auth">Auth</label>
  <div class="col-md-1">
    <select id="auth" name="auth" class="form-control">
      <option value="on" <?php echo $a['auth'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
      <option value="off" <?php echo $a['auth'] == 'off' ? 'selected="selected"' : ''; ?>>off</option>
      <option value="login" <?php echo $a['auth'] == 'login' ? 'selected="selected"' : ''; ?>>login</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="tls">TLS</label>
  <div class="col-md-1">
    <select id="tls" name="tls" class="form-control">
    <option value="on" <?php echo $a['tls'] == 'on' ? 'selected="selected"' : 'selected="selected"'; ?>>on</option>
    <option value="off" <?php echo $a['tls'] == 'off' ? 'selected="selected"' : ''; ?>>off</option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="tlscheck">TLS Check</label>
  <div class="col-md-1">
    <select id="tlscheck" name="tlscheck" class="form-control">
      <option value="on" <?php echo $a['tlscheck'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
      <option value="off" <?php echo $a['tlscheck'] == 'off' ? 'selected="selected"' : 'selected="selected"'; ?> >off</option>
    </select>
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


    








