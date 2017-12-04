<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<?php

$lcd = 'groups';
if(isset($_GET['lcd'])){
    $lcd = $_GET['lcd'] == 'groups' ? 'groups' : $lcd;
    $lcd = $_GET['lcd'] == 'settings' ? 'settings' : $lcd;
}
?>
<p>
<a href="index.php?id=device&type=lcd&lcd=groups" ><button class="btn btn-xs btn-default <?php echo $lcd == 'groups' ? 'active' : ''; ?>">Groups</button></a>
<a href="index.php?id=device&type=lcd&lcd=settings" ><button class="btn btn-xs btn-default <?php echo $lcd == 'settings' ? 'active' : ''; ?>">LCD Configuration</button></a>
</p>

<?php
switch ($lcd)
{
default: case '$lcd': include('modules/lcd/html/lcd_groups.php'); break;
case 'settings': include('modules/lcd/html/lcd_settings.php'); break;
case 'groups': include('modules/lcd/html/lcd_groups.php'); break;
}
?>
