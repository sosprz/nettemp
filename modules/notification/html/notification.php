<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<p>
<!-- <a href="index.php?id=notification&type=users" ><button class="btn <?php echo $art == 'users' ? 'btn-default' : 'btn-default'; ?>">Users</button></a> -->
<a href="index.php?id=notification&type=sensors" ><button class="btn <?php echo $art == 'sensors' ? 'btn-default' : 'btn-default'; ?>">Alarms</button></a>
<a href="index.php?id=notification&type=triggers" ><button class="btn <?php echo $art == 'triggers' ? 'btn-default' : 'btn-default'; ?>">Triggers</button></a>
<a href="index.php?id=notification&type=other" ><button class="btn <?php echo $art == 'other' ? 'btn-default' : 'btn-default'; ?>">Other</button></a>

</p>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/notification/html/alarms.php'); break;
case 'sensors': include('modules/notification/html/alarms.php'); break;
case 'triggers': include('modules/notification/html/triggers.php'); break;
case 'other': include('modules/notification/html/other.php'); break;
}
?>



