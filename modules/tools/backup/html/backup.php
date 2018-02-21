<?php
$backup = isset($_POST['backup']) ? $_POST['backup'] : '';
if ($backup == "backup") { 
    passthru("modules/tools/backup/backup b");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$backup_file = isset($_POST['backup_file']) ? $_POST['backup_file'] : '';
$rm = isset($_POST['rm']) ? $_POST['rm'] : '';
if ($rm == "rm") {
    if(preg_match('/^[a-z0-9_ \-\.]+$/i',$backup_file)){
        unlink("tmp/backup/$backup_file");
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"><button class="btn btn-lg btn-danger btn-block">IMPROPER FILE NAME. <br>Backup File: ('.$backup_file.')<br> RELOAD?</button></a>';
        exit();
    }
}
$db_file = isset($_POST['db_file']) ? $_POST['db_file'] : '';
$rmdb = isset($_POST['rmdb']) ? $_POST['rmdb'] : '';
if ($rmdb == "rm") {
    if(preg_match('/^[a-z0-9_ \-\.]+$/i',$db_file)){
        unlink("dbf/$db_file");
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"><button class="btn btn-lg btn-danger btn-block">IMPROPER FILE NAME. <br>DB File: ('.$db_file.')<br> RELOAD?</button></a>';
        exit();
    }
}

$dbres_file = isset($_POST['dbres_file']) ? $_POST['dbres_file'] : '';
$resdb = isset($_POST['resdb']) ? $_POST['resdb'] : '';
if ($resdb == "res") {
	$dbfile = "dbf/nettemp.db";
	$dbresto= "dbf/$dbres_file";
	if (!copy($dbresto, $dbfile)) {
		echo "Restore failed. $dbfile $dbres_file\n";
	} else {
		echo "Restore OK.\n";
	}
    
}

$mkdb = isset($_POST['mkdb']) ? $_POST['mkdb'] : '';
if ($mkdb == "mkdb") {
	$file = "dbf/nettemp.db";
	$newfile = "dbf/nettemp.db.".date('Y-m-d_His').'.'.substr(rand(), 0, 4);
	if (!copy($file, $newfile)) {
		echo "failed to copy $file\n";
	} else {
		echo "New backup $newfile\n";
	}
}

$restore_file = isset($_POST['restore_file']) ? $_POST['restore_file'] : '';
$re = isset($_POST['re']) ? $_POST['re'] : '';
if ($re == "re") {
    if(preg_match('/^[a-z0-9_ \-\.]+$/i',$restore_file)){
        passthru("modules/tools/backup/backup r tmp/backup/$restore_file");
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"><button class="btn btn-lg btn-danger btn-block">IMPROPER FILE NAME. <br>Restore File: ('.$restore_file.')<br> RELOAD?</button></a>';
        exit();
    }
}
?>

<div class="panel panel-default">
<div class="panel-heading">Backup/restore</div>
<div class="panel-body">
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="backup" value="backup">
<input  type="submit" value="Make backup" class="btn btn-xs btn-success" />
</form>

<table class="table table-striped">
<thead><tr><th>file</th><th>Size</th><th>Restore</th><th></th></tr></thead>

<?php
$dir = 'tmp/backup/';
if(!file_exists($dir)){
    mkdir($dir, octdec('0775'));
}
$fileExtensions = array('gz');
$files = scandir($dir);
foreach($files AS $file) {
 $fileinfo = pathinfo($file);
 if(is_file($dir.'/'.$file) AND in_array($fileinfo['extension'], $fileExtensions)) { 
?>
<tr>
<td><a href="<?php echo "$dir$file";?>"><?php echo $file; ?></a></td>
<td><?php $filesize = (filesize("$dir$file") * .0009765625) * .0009765625; echo round($filesize, 2) ?>MB</td>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="restore_file" value="<?php echo $file; ?>" />
<input type="hidden" name="re" value="re" />
<td><button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-play"></span> </button></td>
</form>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="backup_file" value="<?php echo $file; ?>" />
<input type="hidden" name="rm" value="rm" />
<td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
</form>
</tr>

<?php
 }}
?>
</table>
<p>
  <form enctype="multipart/form-data" action="upload" method="post" >
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
    <input name="uploaded_file" type="file" />
    <input type="submit" value="Upload" class="btn btn-xs btn-danger" />
  </form> 
</p>
    <br />

    <font color="grey">Note: If You want upload image, You must change upload_max_filezise in php.ini<br />
        Now Your value is:
        <?php passthru('grep upload_max_filesize /etc/php/7.0/fpm/php.ini');  ?></font>
		
		

</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">DB Backup files</div>
<div class="panel-body">
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="mkdb" value="mkdb">
<input  type="submit" value="Make DB backup" class="btn btn-xs btn-success" />
</form>
<table class="table table-striped condensed">
<thead>
	<tr>
		<th>file</th>
		<th>Size</th>
		<th>Restore</th>
		<th>Delete</th>
	</tr>
</thead>

<?php
$dir = 'dbf';
$files = scandir($dir);
$fileExtensions = array('.','..','.gitignore','nettemp.db','nettemp.db-wal','nettemp.db-shm');
foreach($files AS $file) {
 if(is_file($dir.'/'.$file) AND !in_array($file, $fileExtensions)) { 
?>
<tr>
<td>
	<a href="<?php echo "$dir/$file";?>"><?php echo $file; ?></a>
</td>

<td>
	<?php $filesize = (filesize("$dir/$file") * .0009765625) * .0009765625; echo round($filesize, 2) ?>MB
</td>

<td>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
	<input type="hidden" name="dbres_file" value="<?php echo $file; ?>" />
	<input type="hidden" name="resdb" value="res" />
	<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-play"></span> </button>
	</form>
</td>

<td>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
	<input type="hidden" name="db_file" value="<?php echo $file; ?>" />
	<input type="hidden" name="rmdb" value="rm" />
	<button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
	</form>
</td>

</tr>

<?php
 }}
?>
</table>
</div>
</div>
