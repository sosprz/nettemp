<?php
if ($_POST['backup'] == "backup") { 
system ("modules/backup/backup b");
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
  echo '<a href="'.$dir.'/'.$file.'">Pobierz '.$file.'</a><br />';
 }}
?>
