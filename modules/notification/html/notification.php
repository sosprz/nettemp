<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<p>
<!-- <a href="index.php?id=notification&type=users" ><button class="btn <?php echo $art == 'users' ? 'btn-info' : 'btn-info'; ?>">Users</button></a> -->
<a href="index.php?id=notification&type=sensors" ><button class="btn <?php echo $art == 'sensors' ? 'btn-info' : 'btn-info'; ?>">Alarms</button></a>
<a href="index.php?id=notification&type=triggers" ><button class="btn <?php echo $art == 'triggers' ? 'btn-info' : 'btn-info'; ?>">Triggers</button></a>
<a href="index.php?id=notification&type=other" ><button class="btn <?php echo $art == 'other' ? 'btn-info' : 'btn-info'; ?>">Other</button></a>

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



