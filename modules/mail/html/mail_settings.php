<?php
//$address = $_POST["address"];  //sql
$user = isset($_POST['user']) ? $_POST['user'] : '';
$host = isset($_POST['host']) ? $_POST['host'] : '';
$port = isset($_POST['port']) ? $_POST['port'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$auth = isset($_POST['auth']) ? $_POST['auth'] : '';
$tls = isset($_POST['tls']) ? $_POST['tls'] : '';
$tlscheck = isset($_POST['tlscheck']) ? $_POST['tlscheck'] : '';


    $change_password1 = isset($_POST['change_password1']) ? $_POST['change_password1'] : '';
    if  ($change_password1 == "change_password2") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE mail_settings SET port='$port'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET host='$host'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET user='$user'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET password='$password'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET auth='$auth'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET tls='$tls'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE mail_settings SET tlscheck='$tlscheck'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>



<?php
    $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from mail_settings ");
    $sth->execute();
    $result = $sth->fetchAll();
	foreach ($result as $a) {
?>

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Form Name -->

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">Username</label>  
  <div class="col-md-4">
  <input id="user" name="user" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a["user"]; ?>">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password</label>
  <div class="col-md-4">
    <input id="password" name="password" placeholder="" class="form-control input-md" required="" type="password" value="<?php echo $a["password"]; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">Server SMTP</label>  
  <div class="col-md-4">
  <input id="host" name="host" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a["host"]; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="port">Port</label>  
  <div class="col-md-2">
  <input id="port" name="port" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $a["port"]; ?>">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="auth">Auth</label>
  <div class="col-md-2">
    <select id="auth" name="auth" class="form-control">
      <option value="on" <?php echo $a['auth'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
      <option value="off" <?php echo $a['auth'] == 'off' ? 'selected="selected"' : ''; ?>>off</option>
      <option value="login" <?php echo $a['login'] == 'login' ? 'selected="selected"' : ''; ?>>login</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tls">TLS</label>
  <div class="col-md-4">
    <select id="tls" name="tls" class="form-control">
      <option value="on">TLS</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tlscheck">TLS Ceck</label>
  <div class="col-md-4">
    <select id="tlscheck" name="tlscheck" class="form-control">
      <option value="on" <?php echo $a['tlscheck'] == 'on' ? 'selected="selected"' : ''; ?>>on</option>
      <option value="off" <?php echo $a['tlscheck'] == 'off' ? 'selected="selected"' : ''; ?> >off</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="mailsave"></label>
  <div class="col-md-4">
    <input type="hidden" name="change_password1" value="change_password2" />
    <button id="mailsave" name="mailsave" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>

</div>

<?php }	?>

    








