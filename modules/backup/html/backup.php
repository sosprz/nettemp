<?php
if ($_POST['backup'] == "backup") { 
    passthru("modules/backup/backup b");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
}
?>
<?php
$backup_file=$_POST['backup_file'];
if ($_POST['rm'] == "rm") {   
    unlink("modules/backup/files/$backup_file");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    } 
?> 
<?php
$restore_file=$_POST['restore_file'];
if ($_POST['re'] == "re") {   
    passthru("modules/backup/backup r modules/backup/files/$restore_file");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    } 
?> 


<span class="belka">&nbsp Backup/restore<span class="okno">

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="backup" value="backup">
<input  type="submit" value="Make backup"  />
</form>


<h3>Available images restore/delete</h3>
<?php
$dir = 'modules/backup/files/';
$fileExtensions = array('gz');
$files = scandir($dir);
foreach($files AS $file) {
 $fileinfo = pathinfo($file);
 if(is_file($dir.'/'.$file) AND in_array($fileinfo['extension'], $fileExtensions)) { 
?>
<table>
<tr>
<td><a href="<?php echo "$dir$file";?>"><?php echo $file; ?></a></td>
<td><?php $filesize = (filesize("$dir$file") * .0009765625) * .0009765625; echo round($filesize, 2) . MB ?></td>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="restore_file" value="<?php echo $file; ?>" />
<input type="hidden" name="re" value="re" />
<td><input type="image" src="media/ico/backup-restore-icon.png" title="Restore backup"/></td>
</form>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<input type="hidden" name="backup_file" value="<?php echo $file; ?>" />
<input type="hidden" name="rm" value="rm" />
<td><input type="image" src="media/ico/Close-2-icon.png" title="Delete backup" /></td>
</form>
</tr>
</table>
<?php
 }}
?>
<h3>Upload nettemp image</h3>

  <form enctype="multipart/form-data" action="upload" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
    Choose a file to upload: <input name="uploaded_file" type="file" />
    <input type="submit" value="Upload" />
  </form> 


</span></span>
