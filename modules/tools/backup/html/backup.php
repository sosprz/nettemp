<?php
$backup = isset($_POST['backup']) ? $_POST['backup'] : '';
if ($backup == "backup") { 
    passthru("modules/tools/backup/backup b");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
}
?>
<?php
$backup_file = isset($_POST['backup_file']) ? $_POST['backup_file'] : '';
$rm = isset($_POST['rm']) ? $_POST['rm'] : '';
if ($rm == "rm") {
    unlink("tmp/backup/$backup_file");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    } 
?> 
<?php
$restore_file = isset($_POST['restore_file']) ? $_POST['restore_file'] : '';
$re = isset($_POST['re']) ? $_POST['re'] : '';
if ($re == "re") {   
    passthru("modules/tools/backup/backup r tmp/backup/$restore_file");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    } 
?> 

<div class="panel panel-default">
<div class="panel-heading">Backup/restore</div>
<div class="panel-body">
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="backup" value="backup">
<input  type="submit" value="Make backup" class="btn btn-xs btn-default" />
</form>

<table class="table table-striped">
<thead><tr><th>file</th><th>Size</th><th>Restore</th><th></th></tr></thead>

<?php
$dir = 'tmp/backup/';
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
<td><button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-play"></span> </button></td>
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
        <?php passthru('grep upload_max_filesize /etc/php5/fpm/php.ini');  ?></font>

</div>
</div>