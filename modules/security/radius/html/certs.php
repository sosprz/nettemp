<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">Certifications</h3></div>

<?php
$rmu = isset($_POST['rmu']) ? $_POST['rmu'] : '';
$rmuser = isset($_POST['rmuser']) ? $_POST['rmuser'] : '';
    
if ($rmu == "rmu"){ 
    shell_exec("modules/security/radius/EAP_TLS_revoke $rmuser"); 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$days = isset($_POST['days']) ? $_POST['days'] : '';
$add = isset($_POST['add']) ? $_POST['add'] : '';
$method = isset($_POST['method']) ? $_POST['method'] : '';

if ($add == "add"){ 
    shell_exec("modules/security/radius/EAP_TLS_client $username $mail $method $days"); 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


?>

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Name</th><th>Mail</th><th>Valid days</th><th>Type</th><th></thead>
<tr>	
    <form action="" method="post" class="form-horizontal">
    <div class="form-group">
    <td ><input type="text" name="username" value="" class="form-control" required=""/></td>
    <td ><input type="text" name="mail" value="" class="form-control" required=""/></td>
    
    <td ><input type="text" name="days" value="" class="form-control" placeholder="ex. 15, default 365 "/></td>
    <input type="hidden" name="add" value="add" class="form-control"/>
    <td><select name="method" class="form-control">
	<option value="p12">p12</option>
	<option value="pem">pem</option>
    </select> 
    </td>
    <td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
    </div>
    </form>

</tr>



<?php
$Mydir = '/usr/local/etc/raddb/certs/users/';
foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $dir) {
    $dir = str_replace($Mydir, '', $dir);
    
    $cmd="sudo openssl x509 -in /usr/local/etc/raddb/certs/users/$dir/export.pem -text -noout |grep After| awk '{ print $4\" \"$5\" \"$6\" \"$7}'";
    $out=shell_exec($cmd);
    $cmd2="sudo openssl x509 -in /usr/local/etc/raddb/certs/users/$dir/export.pem  -text -noout |grep  'Subject.*CN'| awk -F\"=\" '{print $6}'";
    $out2=shell_exec($cmd2);
    ?>
<tr>
    <td>
	<?php echo $dir; ?>
    </td>
    <td>
	<?php echo $out2; ?>
    </td>
    <td>
	<?php echo "expire: " . $out; ?>
    </td>
    <td></td>
    <td>
	<form action="" method="post" style=" display:inline!important;">
    	    <input type="hidden" name="rmuser" value="<?php echo "$dir"; ?>" />
    	    <input type="hidden" name="rmu" value="rmu" />
	    <button class="btn btn-xs btn-danger">Revoke</button>
	</form>
    </td>

</tr>
<?php
}
?>
</table>
</div>
</div>