<?php
$dir="modules/gpio/";
$gpio_post = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");

$simple = isset($_POST['simple']) ? $_POST['simple'] : '';
$onoff = isset($_POST['onoff']) ? $_POST['onoff'] : '';
if (($onoff == "onoff") ){
    $db->exec("UPDATE gpio SET simple='$simple', status='$simple' WHERE gpio='$gpio_post'") or die("PDO exec error");
    if ($simple == 'on'){
	include('modules/gpio/html/gpio_on.php');
    } else { 
	include('modules/gpio/html/gpio_off.php');
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }



$bi = isset($_POST['bi']) ? $_POST['bi'] : '';
if ($bi == "bi")  {
    if ($a['rev'] == 'on') {
    exec("/usr/local/bin/gpio -g write $gpio_post 0 && sleep 0.5 &&  /usr/local/bin/gpio -g write $gpio_post 1");
    } else {
    exec("/usr/local/bin/gpio -g write $gpio_post 1 && sleep 0.5 && /usr/local/bin/gpio -g write $gpio_post 0");
    }
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$sth2 = $db->prepare("select * from gpio where mode='simple'");
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ( $result2 as $a) {
?>


<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $a['name']; ?></h3>
</div>
<div class="panel-body">
    <form action="" method="post">
    <input type="checkbox" title="Simple on/off" data-toggle="toggle"  onchange="this.form.submit()" name="simple"  value="<?php echo $a['simple'] == on  ? 'off' : 'on'; ?>" <?php echo $a['simple'] == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="onoff" value="onoff" />
</form>
</div></div>
<?php 
}

$sth2 = $db->prepare("select * from gpio where mode='moment'");
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ( $result2 as $a) {
?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $a['name']; ?></h3>
</div>
<div class="panel-body">

<form action="" method="post">
    <td><input data-onstyle="warning" type="checkbox" data-toggle="toggle" name="bi" value="on" onchange="this.form.submit()" name="simple"  title="Turn on wait 1s and off"   onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="bi" value="bi" />
</form>

</div></div>
<?php 
}
?>

 

