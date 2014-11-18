<span class="belka">&nbsp Update<span class="okno">
<?php
    $update=isset($_POST['update']) ? $_POST['update'] : '';
    if ($update == "Update") { 
	//putenv('PATH='. getenv('PATH') .':var/www/nettemp');
	exec("/usr/bin/git reset --hard");
?>
<pre>
<?php
    passthru("/usr/bin/git pull 2>&1");
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
    <input  type="submit" value="Update"  />
    </form>
    </span></span>