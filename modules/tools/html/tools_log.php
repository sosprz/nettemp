<?php 
if(!isset($_SESSION['user'])){ header("Location: denied"); } 
$log=isset($_GET['log']) ? $_GET['log'] : '';
?>

<p>
<a href="index.php?id=tools&type=log&log=nettemp" ><button class="btn btn-xs btn-info <?php echo $log == 'nettemp' ? 'active' : ''; ?>">Nettemp</button></a>
<a href="index.php?id=tools&type=log&log=call" ><button class="btn btn-xs btn-info <?php echo $log == 'call' ? 'active' : ''; ?>">Call</button></a>
<a href="index.php?id=tools&type=log&log=sms" ><button class="btn btn-xs btn-info <?php echo $log == 'sms' ? 'active' : ''; ?>">SMS</button></a>
<a href="index.php?id=tools&type=log&log=gpio" ><button class="btn btn-xs btn-info <?php echo $log == 'gpio' ? 'active' : ''; ?>">GPIO</button></a>
</p>
<?php  
switch ($log)
{ 
default: case '$log': include('modules/tools/html/log/log_nettemp.php'); break;
case 'call': include('modules/tools/html/log/log_call.php'); break;
case 'sms': include('modules/tools/html/log/log_sms.php'); break;
case 'nettemp': include('modules/tools/html/log/log_nettemp.php'); break;
case 'gpio': include('modules/tools/html/log/log_gpio.php'); break;
}
?>




