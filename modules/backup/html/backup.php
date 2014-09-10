<?php
if ($_POST['backup'] == "backup") { 
    system ("modules/backup/backup b");
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


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="backup" value="backup">
<input  type="submit" value="Make backup"  />
</form>



<?php
$dir = 'modules/backup/files/';
$fileExtensions = array('gz');
$files = scandir($dir);
foreach($files AS $file) {
 $fileinfo = pathinfo($file);
 if(is_file($dir.'/'.$file) AND in_array($fileinfo['extension'], $fileExtensions)) { 
?>


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"  >
<td><a href="<?php echo "$dir$file";?>"><?php echo $file; ?></a></td>
<input type="hidden" name="backup_file" value="<?php echo $file; ?>" />
<input type="hidden" name="rm" value="rm" />
<td><input type="image" src="media/ico/Close-2-icon.png" /></td>
</form>

<?php
 }}
?>
