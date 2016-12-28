<div class="panel panel-default">
<div class="panel-heading">Update nettemp</div>
<div class="panel-body">

<?php
$ROOT=$_SERVER['DOCUMENT_ROOT'];
$update=isset($_POST['update']) ? $_POST['update'] : '';

if ($update == "Update") { 
       
?>
<pre>
<?php
	$file = "$ROOT/dbf/nettemp.db";
	$newfile = $ROOT."/dbf/nettemp.db".substr(rand(), 0, 4);

	if (!copy($file, $newfile)) {
		echo "failed to copy $file...\n";
	} else {
		echo "New backup $newfile...\n";
	}
	
	
    passthru("cd /var/www/nettemp && git reset --hard");
    passthru("/usr/bin/git pull 2>&1");
    shell_exec("$ROOT/modules/tools/update_su");
    shell_exec("$ROOT/modules/tools/update_fi");
    include("$ROOT/modules/tools/update_perms.php");
    include("$ROOT/modules/tools/update_db.php");
    include("$ROOT/modules/tools/check_packages.php");
    unlink("$ROOT/tmp/update");
    }
?>
</pre>
    <form action="" method="post">
    <button type="submit" name="update" value="Update" class="btn btn-xs btn-success"  />Update</button>
    </form>

</div></div>
<script type="text/javascript">
$("button").click(function() {
    var $btn = $(this);
    $btn.button('loading');
function submitform()
{
    $btn.button('reset');
}
});
</script>
