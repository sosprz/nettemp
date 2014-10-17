<?php
$dayexit = isset($_POST['dayexit']) ? $_POST['dayexit'] : '';
if (($dayexit == "dayexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$day_zone1s = isset($_POST['day_zone1s']) ? $_POST['day_zone1s'] : '';
$day_zone1e = isset($_POST['day_zone1e']) ? $_POST['day_zone1e'] : '';
$dayrun = isset($_POST['dayrun']) ? $_POST['dayrun'] : '';
if ($dayrun == "on")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET day_run='on', day_zone1s='$day_zone1s',day_zone1e='$day_zone1e'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

if ($dayrun == "off")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET day_run='' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db->prepare("select * from gpio where gpio='$gpio'");
    $sth->execute();
    $result = $sth->fetchAll();    
    foreach ($result as $a) { 
    $day_run=$a['day_run'];
    if ($day_run == 'on') { 
?>

    <form action="" method="post">
	<td>Status: <?php echo $a['day_zone1s']; ?> <?php echo $a['day_zone1e']; ?> </td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-Off-icon.png"/></td>
	<input type="hidden" name="dayrun" value="off" />
	<input type="hidden" name="off" value="off" />
    </form>

<?php 
    }
	else 
    {
include('gpio_rev.php');
?>
    
    <form action="" method="post">
	<td><input type="image" name="dayoff" value="off" src="media/ico/Close-2-icon.png" title="Back" onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayexit" value="dayexit" />        
   </form>

    <form action="" method="post">
	<td>Start time</td>
	<td><input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="8"  ></td><td></td> 
	<td>End time</td>
	<td><input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="8"  ></td><td></td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="dayrun" value="on" />
	<input type="hidden" name="on" value="on" />
    </form>
<?php
    }}
?>

