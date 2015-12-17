<?php 
if(!isset($_SESSION['user'])){ header("Location: denied"); } 
$log=isset($_GET['log']) ? $_GET['log'] : '';
?>

<p>
<a href="index.php?id=tools&type=log&log=nettemp" ><button class="btn <?php echo $log == 'nettemp' ? 'btn-info' : 'btn-default'; ?>">Nettemp</button></a>
<a href="index.php?id=tools&type=log&log=call" ><button class="btn <?php echo $log == 'call' ? 'btn-info' : 'btn-default'; ?>">Call</button></a>
<a href="index.php?id=tools&type=log&log=sms" ><button class="btn <?php echo $log == 'sms' ? 'btn-info' : 'btn-default'; ?>">SMS</button></a>
</p>
<?php  
switch ($log)
{ 
default: case '$log': include('modules/tools/html/log/log_nettemp.php'); break;
case 'call': include('modules/tools/html/log/log_call.php'); break;
case 'sms': include('modules/tools/html/log/log_sms.php'); break;
case 'nettemp': include('modules/tools/html/log/log_nettemp.php'); break;
}
?>




