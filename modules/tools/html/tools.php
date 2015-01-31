<?php $db = new PDO('sqlite:dbf/nettemp.db');
    $sth = $db->prepare("select * from settings where id='1'");
    $sth->execute();
    $result = $sth->fetchAll();
    foreach ($result as $a) {
    $gpio=$a["gpio"];
    }
?>



<span class="belka">&nbsp Tools<span class="okno">

<table><tr>
<td><a href="index.php?id=tools&type=file_check" ><button>File check</button></a></td>
<td><a href="index.php?id=tools&type=system_stat" ><button>System stat</button></a></td>
<td><a href="index.php?id=tools&type=password" ><button>Password</button></a></td>
<td><a href="index.php?id=tools&type=update" ><button>Update</button></a></td>
<td><a href="index.php?id=tools&type=reset" ><button>Reset to default</button></a></td>
<td><a href="index.php?id=tools&type=reboot" ><button>Reboot</button></a></td>
<td><a href="index.php?id=tools&type=log" ><button>Logging</button></a></td>
<?php if ( $gpio == 'on' ) { ?>
<td><a href="index.php?id=tools&type=gpio" ><button>Gpio</button></a></td>
<?php } ?>
<td><a href="index.php?id=tools&type=backup" ><button>Backup/Restore</button></a></td>
</tr>
</table>
</span>
</span>



<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/tools/html/tools_system_stats.php'); break;
case 'file_check': include('modules/tools/html/tools_file_check.php'); break;
case 'system_stat': include('modules/tools/html/tools_system_stats.php'); break;
case 'password': include('modules/tools/html/tools_change_pass.php'); break;
case 'update': include('modules/tools/html/tools_update.php'); break;
case 'reset': include('modules/tools/html/tools_reset.php'); break;
case 'reboot': include('modules/tools/html/tools_reboot.php'); break;
case 'log': include('modules/tools/html/tools_log.php'); break;
case 'gpio': include('modules/tools/html/tools_gpio_readall.php'); break;
case 'backup': include('modules/tools/backup/html/backup.php'); break;
}
?>




