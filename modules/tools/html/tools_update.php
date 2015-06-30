<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Update nettemp</h3>
</div>
<div class="panel-body">

<?php
$dir=$_SERVER['DOCUMENT_ROOT'];
$update=isset($_POST['update']) ? $_POST['update'] : '';

if ($update == "Update") { 
    putenv('PATH='. getenv('PATH') .':var/www/nettemp');
    exec("/usr/bin/git reset --hard");
?>
<pre>
<?php
    passthru("/usr/bin/git pull 2>&1");
?>
</pre>
<?php
    shell_exec("$dir/modules/tools/update_su");
    shell_exec("$dir/modules/tools/update_db");
    shell_exec("$dir/modules/tools/update_fi");
    }
?>
    <form action="" method="post">
    <input type="hidden" name="update" value="Update">
    <input  type="submit" value="Update" class="btn btn-primary"  />
    </form>

</div></div>
