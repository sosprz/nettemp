<?php 
if(!isset($_SESSION['user'])){ header("Location: denied"); } 
$mysql=isset($_GET['mysql']) ? $_GET['mysql'] : '';
?>

<p>
<a href="index.php?id=settings&type=mysql&log=settings" ><button class="btn btn-xs btn-default <?php echo $mysql == 'settings' ? 'active' : ''; ?>">Settings</button></a>
<a href="index.php?id=settings&type=mysql&mysql=add" ><button class="btn btn-xs btn-default <?php echo $mysql == 'add' ? 'active' : ''; ?>">Add tables</button></a>
<a href="index.php?id=settings&type=mysql&mysql=test" ><button class="btn btn-xs btn-default <?php echo $mysql == 'test' ? 'active' : ''; ?>">Test</button></a>
</p>

<?php  
switch ($mysql)
{ 
default: case '$log': include('modules/mysql/mysql_settings.php'); break;
case 'test': include('modules/mysql/mysql_test.php'); break;
case 'settings': include('modules/mysql/mysql_settings.php'); break;
case 'add': include('modules/mysql/mysql_add.php'); break;

}
?>
