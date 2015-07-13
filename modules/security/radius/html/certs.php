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

if ($add == "add"){ 
    shell_exec("modules/security/radius/EAP_TLS_client $username $mail $days"); 
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


?>

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Name</th><th>Mail</th><th>Valid days</th><th></th></tr></thead>
<tr>	
    <form action="" method="post" class="form-horizontal">
    <div class="form-group">
    <td class="col-md-2"><input type="text" name="username" value="" class="form-control" required=""/></td>
    <td class="col-md-2"><input type="text" name="mail" value="" class="form-control" required=""/></td>
    <td class="col-md-1"><input type="text" name="days" value="" class="form-control" /></td>
    <input type="hidden" name="add" value="add" class="form-control"/>
    <td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
    </div>
    </form>
</tr>



<?php
$Mydir = '/usr/local/etc/raddb/certs/users/';
foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $dir) {
    $dir = str_replace($Mydir, '', $dir);
    echo $dir;
    ?>
    <form action="" method="post" style=" display:inline!important;">
        <input type="hidden" name="rmuser" value="<?php echo "$dir"; ?>" />
        <input type="hidden" name="rmu" value="rmu" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
<?php
}
?>


