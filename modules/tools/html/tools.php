<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

<?php $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from settings where id='1'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
    $gpio=$a["gpio"];
    }
?>
<p>
<a href="index.php?id=tools&type=file_check" ><button class="btn <?php echo $art == 'file_check' ? 'btn-info' : 'btn-default'; ?>">File check</button></a>
<a href="index.php?id=tools&type=password" ><button class="btn <?php echo $art == 'password' ? 'btn-info' : 'btn-default'; ?>">Password</button></a>
<a href="index.php?id=tools&type=update" ><button class="btn <?php echo $art == 'update' ? 'btn-info' : 'btn-default'; ?>">Update</button></a>
<a href="index.php?id=tools&type=reset" ><button class="btn <?php echo $art == 'reset' ? 'btn-info' : 'btn-default'; ?>">Reset to default</button></a>
<a href="index.php?id=tools&type=reboot" ><button class="btn <?php echo $art == 'reboot' ? 'btn-info' : 'btn-default'; ?>">Reboot</button></a>
<a href="index.php?id=tools&type=log" ><button class="btn <?php echo $art == 'log' ? 'btn-info' : 'btn-default'; ?>">Logging</button></a>
<?php if ( $gpio == 'on' ) { ?>
<a href="index.php?id=tools&type=gpio" ><button class="btn <?php echo $art == 'gpio' ? 'btn-info' : 'btn-default'; ?>">GPIO</button></a>
<?php } ?>
<a href="index.php?id=tools&type=backup" ><button class="btn <?php echo $art == 'backup' ? 'btn-info' : 'btn-default'; ?>">Backup/Restore</button></a>
<a href="index.php?id=tools&type=espupload" ><button class="btn <?php echo $art == 'espupload' ? 'btn-info' : 'btn-default'; ?>">ESPupload</button></a>
</p>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/tools/html/tools_update.php'); break;
case 'file_check': include('modules/tools/html/tools_perms.php'); break;
case 'password': include('modules/tools/html/tools_change_pass.php'); break;
case 'update': include('modules/tools/html/tools_update.php'); break;
case 'reset': include('modules/tools/html/tools_reset.php'); break;
case 'reboot': include('modules/tools/html/tools_reboot.php'); break;
case 'log': include('modules/tools/html/tools_log.php'); break;
case 'gpio': include('modules/tools/html/tools_gpio_readall.php'); break;
case 'backup': include('modules/tools/backup/html/backup.php'); break;
case 'espupload': include('modules/sensors/wireless/espupload/espupload.php'); break;
}
?>




