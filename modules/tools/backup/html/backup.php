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
    unlink("modules/tools/backup/files/$backup_file");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    } 
?> 
<?php
$restore_file = isset($_POST['restore_file']) ? $_POST['restore_file'] : '';
$re = isset($_POST['re']) ? $_POST['re'] : '';
if ($re == "re") {   
    passthru("modules/tools/backup/backup r modules/tools/backup/files/$restore_file");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    } 
?> 

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Backup/restore</h3>
</div>
<div class="panel-body">
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="backup" value="backup">
<input  type="submit" value="Make backup" class="btn btn-primary" />
</form>


<?php
$dir = 'modules/tools/backup/files/';
$fileExtensions = array('gz');
$files = scandir($dir);
foreach($files AS $file) {
 $fileinfo = pathinfo($file);
 if(is_file($dir.'/'.$file) AND in_array($fileinfo['extension'], $fileExtensions)) { 
?>
<table class="table table-striped">
<thead><tr><th>file</th><th>Size</th><th>Restore</th><th>Remove</th></tr></thead>
<tr>
<td><a href="<?php echo "$dir$file";?>"><?php echo $file; ?></a></td>
<td><?php $filesize = (filesize("$dir$file") * .0009765625) * .0009765625; echo round($filesize, 2) ?>MB</td>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="restore_file" value="<?php echo $file; ?>" />
<input type="hidden" name="re" value="re" />
<td><button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-play"></span> </button></td>
</form>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="backup_file" value="<?php echo $file; ?>" />
<input type="hidden" name="rm" value="rm" />
<td><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> </button></td>
</form>
</tr>
</table>
<?php
 }}
?>
<p>
  <form enctype="multipart/form-data" action="upload" method="post" >
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
    <input name="uploaded_file" type="file" />
    <input type="submit" value="Upload" class="btn btn-danger" />
  </form> 
</p>
    <br />

    <font color="grey">Note: If You want upload image, You must change upload_max_filezise in php.ini<br />
        Now Your value is:
        <?php passthru('grep upload_max_filesize /etc/php5/cgi/php.ini');  ?></font>

</div>
</div>