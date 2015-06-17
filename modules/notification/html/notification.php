<p>
<a href="index.php?id=notification&type=users" ><button class="btn btn-default">Users</button></a>
<a href="index.php?id=notification&type=sensors" ><button class="btn btn-default">Alarms</button></a>
</p>
<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/notification/html/users.php'); break;
case 'sensors': include('modules/notification/html/alarms.php'); include("modules/notification/html/other.php"); break;
case 'users': include('modules/notification/html/users.php'); break;


}
?>



