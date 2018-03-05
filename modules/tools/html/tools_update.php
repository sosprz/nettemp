<div class="panel panel-default">
<div class="panel-heading">Update nettemp</div>
<div class="panel-body">

<?php
$ROOT=$_SERVER['DOCUMENT_ROOT'];
$dir=$ROOT.'/dbf';
$dbfile=$dir.'/nettemp.db';

$update=isset($_POST['update']) ? $_POST['update'] : '';

if ($update == "UPDATE") {
	
	$nts_server_key_upd = $nts_server_key."_update";
	$db = new PDO("sqlite:$root/dbf/nettemp.db");
	$db->exec("UPDATE nt_settings SET value='$nts_server_key_upd' WHERE option='server_key' ");
	
	system ("sudo service cron stop && sleep 5");
	
    echo '<pre>';
    $file = $ROOT."/dbf/nettemp.db";
    $newfile = $ROOT."/dbf/nettemp.db.".date('Y-m-d_His').'.'.substr(rand(), 0, 4);
    if (!copy($file, $newfile)) {
	echo "failed to copy $file\n";
    } else {
	echo "New backup $newfile\n";
    }

    passthru("cd /var/www/nettemp && git reset --hard");
    passthru("/usr/bin/git pull 2>&1");
    shell_exec("$ROOT/modules/tools/update_su");
    shell_exec("$ROOT/modules/tools/update_fi");
    include("$ROOT/modules/tools/update_perms.php");
    include("$ROOT/modules/tools/update_db.php");
    include("$ROOT/modules/tools/check_packages.php");
	//unlink("$ROOT/tmp/update");
	system ("sudo service cron start && sleep 2");
  echo '</pre>';

	$serverkey = substr($nts_server_key_upd, 0, -7);
	$db->exec("UPDATE nt_settings SET value='$serverkey' WHERE option='server_key' ");

}

if ($update == "INTEGRITY"){
//Integrity fix
    $date=date('Y-m-d_His');
    $badfile=$dir.'/BAD_nettemp.db.'.$date;
    $okfile =$dir.'/OK_nettemp.db.'.$date;
    echo '<pre>';
    if(rename($dbfile,$badfile)){
        unlink($dbfile.'-shm');
        unlink($dbfile.'-wal');
        passthru('/usr/bin/sqlite3 '.$badfile.' ".clone '.$okfile.'" 2>&1');
        if( file_exists($okfile) && filesize($okfile)>0 ){
            rename($okfile,$dbfile);
        }else{
            echo "Something is wrong. Please restore backup.\n";
        }
    }else{
	echo "Cannot move $dbfile to $badfile.\n";
    }
    echo '</pre>';
}

$dbintegrity='';
$db = new PDO("sqlite:$dbfile");
if ( $sth = $db->query("PRAGMA integrity_check") ){
    $row = $sth->fetchAll();
    foreach($row as $r) {
        if($r[0]!='ok') {
            $dbintegrity = "database problem: PRAGMA integrity_check";
        }
    }
} else {
    $dbintegrity = "database problem: PRAGMA query failed";
}

echo '<form action="" method="post">';
if(!empty($dbintegrity)){
    echo '<button type="submit" name="update" value="INTEGRITY" class="btn btn-lg btn-danger btn-block">We found problem: '.$dbintegrity.'<br><br>You may lost some, or all settings.<br>Press to continue?</button>';
}else{
    echo '<button type="submit" name="update" value="UPDATE" class="btn btn-xs btn-success"  />Update</button>';
}
    echo '</form>';

?>

</div>

<?php
//Show DB version if is set..
echo (isset($NT_SETTINGS['DB_VER']) && isset($NT_SETTINGS['DB_LAST_UPDATE'])) ? '<div class="panel-footer">Last successful DB update: '.$NT_SETTINGS['DB_LAST_UPDATE'].'<br><h4><span class="label label-info">DB Version: '.$NT_SETTINGS['DB_VER'].'</span></h4></div>' : '';
?>

</div>
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
