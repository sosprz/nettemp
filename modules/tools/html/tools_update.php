<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Update nettemp</h3>
</div>
<div class="panel-body">

<?php
    $update=isset($_POST['update']) ? $_POST['update'] : '';
    if ($update == "Update") { 
	//putenv('PATH='. getenv('PATH') .':var/www/nettemp');
	//exec("/usr/bin/git reset --hard");
?>
<pre>
<?php
    //passthru("/usr/bin/git pull 2>&1");
?>
</pre>
<?php
    exec('modules/tools/update_su');
    exec('modules/tools/update_db');
    exec('modules/tools/update_fi');
    } 
?>
    <form action="index.php?id=tools&type=update" method="post">
    <input type="hidden" name="update" value="Update">
    <input  type="submit" value="Check update" class="btn btn-default"  />
    </form>

</div></div>
