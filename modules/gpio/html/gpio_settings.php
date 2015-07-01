<?php
$dir="modules/gpio/";
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';

$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$sth2 = $db->prepare("select mode from gpio where mode='buzzer'");
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ( $result2 as $ab) {
$mode2=$ab['mode'];
}
$sth3 = $db->prepare("select mode from gpio where mode='kwh'");
$sth3->execute();
$result3 = $sth3->fetchAll();
foreach ( $result3 as $ab) {
$mode3=$ab['mode'];
}
$sth4 = $db->prepare("select gpio from gpio where mode='buzzer'");
$sth4->execute();
$result4 = $sth4->fetchAll();
foreach ( $result4 as $ab) {
$buzzergpio=$ab['gpio'];
}
$sth5 = $db->prepare("select gpio from gpio where mode='triggerout'");
$sth5->execute();
$result5 = $sth5->fetchAll();
foreach ( $result5 as $ab) {
$triggeroutgpio=$ab['gpio'];
}


//main loop
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$sth = $db->prepare("select * from gpio");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) { 
$gpio=$a['gpio'];
$mode=$a['mode'];
$name=$a['name'];
?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">GPIO <?php echo $gpio ?> - <?php echo $name ?> </h3>
</div>
<div class="panel-body">
<table">
<tr>   
<?php 
include('gpio_name.php');

if  ($mode == 'humid') 
{ 
    include('gpio_humid.php');
} 
elseif ($mode == 'simple') 
{ 
    include('gpio_simple.php');
} 
elseif ($mode == 'moment') 
{ 
    include('gpio_moment.php');
} 
elseif ($mode == 'time') 
{ 
    include('gpio_time.php');
} 
elseif ($mode == 'day') 
{ 
    include('gpio_day.php');
} 
elseif ($mode == 'week') 
{ 
    include('gpio_week.php');
} 
elseif  ($mode == 'temp') 
{ 
    include('gpio_temp.php');
}
elseif ($mode == 'trigger') 
{ 
    include('gpio_trigger.php');
} 
elseif ($mode == 'kwh') 
{
    include('gpio_kwh.php');
} 
elseif ($mode == 'buzzer') 
{
    include('gpio_buzzer.php');
} 
elseif ($mode == 'triggerout') 
{
    include('gpio_triggerout.php');
} 
elseif ($mode == 'control') 
{
    include('gpio_control.php');
} 
else 
{ 
include('gpio_functions.php');
} 
?>
</tr>
</table>
</div>
</div>
<?php 
}
$db = null;
?>

 
