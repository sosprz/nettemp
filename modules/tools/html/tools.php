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
<a href="index.php?id=tools&type=file_check" ><button class="btn btn-xs btn-info <?php echo $art == 'file_check' ? 'active' : ''; ?>">File check</button></a>
<a href="index.php?id=tools&type=password" ><button class="btn btn-xs btn-info <?php echo $art == 'password' ? 'active' : ''; ?>">Password</button></a>
<a href="index.php?id=tools&type=update" ><button class="btn btn-xs btn-info <?php echo $art == 'update' ? 'active' : ''; ?>">Update</button></a>
<a href="index.php?id=tools&type=reset" ><button class="btn btn-xs btn-info <?php echo $art == 'reset' ? 'active' : ''; ?>">Reset to default</button></a>
<a href="index.php?id=tools&type=reboot" ><button class="btn btn-xs btn-info <?php echo $art == 'reboot' ? 'active' : ''; ?>">Reboot</button></a>
<a href="index.php?id=tools&type=log" ><button class="btn btn-xs btn-info <?php echo $art == 'log' ? 'active' : ''; ?>">Logging</button></a>
<?php if ( $gpio == 'on' ) { ?>
<a href="index.php?id=tools&type=gpio" ><button class="btn btn-xs btn-info <?php echo $art == 'gpio' ? 'active' : ''; ?>">GPIO</button></a>
<?php } ?>
<a href="index.php?id=tools&type=backup" ><button class="btn btn-xs btn-info <?php echo $art == 'backup' ? 'active' : ''; ?>">Backup/Restore</button></a>
<a href="index.php?id=tools&type=espupload" ><button class="btn btn-xs btn-info <?php echo $art == 'espupload' ? 'active' : ''; ?>">ESPupload</button></a>
<a href="index.php?id=tools&type=export" ><button class="btn btn-xs btn-info <?php echo $art == 'export' ? 'active' : ''; ?>">Export</button></a>
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
case 'export': include('modules/tools/html/tools_export_to_file.php'); break;
}
?>




