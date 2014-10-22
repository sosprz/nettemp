<?php
$triggerexit = isset($_POST['triggerexit']) ? $_POST['triggerexit'] : '';

if (($triggerexit == "triggerexit") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("humid off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


$triggerrun = isset($_POST['triggerrun']) ? $_POST['triggerrun'] : '';
if ($triggerrun == "on")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_run='on', status='Wait' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
if ($triggerrun == "off")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_run='', status='OFF' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}


    //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    //$sth = $db->prepare("select * from gpio where gpio='$gpio'");
    //$sth->execute();
    //$result = $sth->fetchAll();    
    //foreach ($result as $a) { 
    $trigger_run=$a['trigger_run'];
    $status=$a['status'];
    if ($trigger_run == 'on') { 
?>
    <td>Status: <?php echo $status ?></td>
    <form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-Off-icon.png"/></td>
	<input type="hidden" name="triggerrun" value="off" />
    </form>

<?php 
}
else
{
include('gpio_rev.php');
?>
    
    <form action="" method="post">
	<td><input type="image" name="triggerexit" value="off" src="media/ico/Close-2-icon.png" title="Back"  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggerexit" value="triggerexit" />
    </form>
    <td>Status: OFF</td>
    <form action="" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="triggerrun" value="on" />
    </form>
<?php
}
//}
?>