<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<?php $art = (!isset($art) || $art == '') ? 'update' : $art; ?>
<p>
<a href="index.php?id=tools&type=file_check" ><button class="btn btn-xs btn-default <?php echo $art == 'file_check' ? 'active' : ''; ?>">File check</button></a>
<!-- <a href="index.php?id=tools&type=password" ><button class="btn btn-xs btn-default <?php echo $art == 'password' ? 'active' : ''; ?>">Password</button></a>  -->
<a href="index.php?id=tools&type=update" ><button class="btn btn-xs btn-default <?php echo $art == 'update' ? 'active' : ''; ?>">Update</button></a>
<a href="index.php?id=tools&type=reset" ><button class="btn btn-xs btn-default <?php echo $art == 'reset' ? 'active' : ''; ?>">Reset to default</button></a>
<a href="index.php?id=tools&type=reboot" ><button class="btn btn-xs btn-default <?php echo $art == 'reboot' ? 'active' : ''; ?>">Reboot/Shutdown</button></a>
<a href="index.php?id=tools&type=log" ><button class="btn btn-xs btn-default <?php echo $art == 'log' ? 'active' : ''; ?>">Logging</button></a>
<?php if ( $nts_gpio == 'on' ) { ?>
<a href="index.php?id=tools&type=gpio" ><button class="btn btn-xs btn-default <?php echo $art == 'gpio' ? 'active' : ''; ?>">GPIO</button></a>
<?php } ?>
<a href="index.php?id=tools&type=backup" ><button class="btn btn-xs btn-default <?php echo $art == 'backup' ? 'active' : ''; ?>">Backup/Restore</button></a>
<a href="index.php?id=tools&type=export" ><button class="btn btn-xs btn-default <?php echo $art == 'export' ? 'active' : ''; ?>">DB export</button></a>
<a href="index.php?id=tools&type=dbedit" ><button class="btn btn-xs btn-default <?php echo $art == 'dbedit' ? 'active' : ''; ?>">DB edit</button></a>
<a href="index.php?id=tools&type=dbcheck" ><button class="btn btn-xs btn-default <?php echo $art == 'dbcheck' ? 'active' : ''; ?>">DB check</button></a>
<?php if ( isset($NT_SETTINGS['dbUpdateEditPreparePage']) ){ ?>
<a href="index.php?id=tools&type=dbupdateedit" ><button class="btn btn-xs btn-default <?php echo $art == 'dbupdateedit' ? 'active' : ''; ?>">DB Update Edit</button></a>
<?php } ?>

</p>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/tools/html/tools_update.php'); break;
case 'file_check': include('modules/tools/html/tools_perms.php'); break;
case 'update': include('modules/tools/html/tools_update.php'); break;
case 'reset': include('modules/tools/html/tools_reset.php'); break;
case 'reboot': include('modules/tools/html/tools_reboot.php'); break;
case 'log': include('modules/tools/html/tools_log.php'); break;
case 'gpio': include('modules/tools/html/tools_gpio_readall.php'); break;
case 'backup': include('modules/tools/backup/html/backup.php'); break;
case 'export': include('modules/tools/html/tools_export_to_file.php'); break;
case 'dbedit': include('modules/tools/html/tools_db_edit.php'); break;
case 'dbedit2': include('modules/tools/html/tools_db_edit_select.php'); break;
case 'dbcheck': include('modules/tools/html/tools_db_check.php'); break;
case 'dbupdateedit': include('modules/tools/html/tools_db_update_edit.php'); break;


}
?>




