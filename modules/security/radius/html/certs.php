<?php
$urm = isset($_POST['urm']) ? $_POST['urm'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
    
if ($urm == "urm"){ 
    shell_exec("modules/security/radius/EAP_TLS_revoke $user"); 
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
    <td class="col-md-2"><input type="text" name="host_name" value="" class="form-control" required=""/></td>
    <td class="col-md-2"><input type="text" name="host_ip" value="" class="form-control" required=""/></td>
    <td class="col-md-1"><input type="text" name="host_ip" value="" class="form-control" /></td>
    <input type="hidden" name="host_add1" value="host_add2" class="form-control"/>
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
        <input type="hidden" name="user" value="<?php echo "$dir"; ?>" />
        <input type="hidden" name="urm" value="urm" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
    </form>
<?php
}
?>


