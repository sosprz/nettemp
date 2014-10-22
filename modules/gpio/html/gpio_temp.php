<?php
$tempexit = isset($_POST['tempexit']) ? $_POST['tempexit'] : '';
if ($tempexit == "tempexit"){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET mode='' where gpio='$gpio_post' ") or die("simple off db error");
     $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

// temp
$temp_sensor3 = isset($_POST['temp_sensor3']) ? $_POST['temp_sensor3'] : '';
$temp_onoff3 = isset($_POST['temp_onoff3']) ? $_POST['temp_onoff3'] : '';
$temp_op3 = isset($_POST['temp_op3']) ? $_POST['temp_op3'] : '';
$temp_temp3 = isset($_POST['temp_temp3']) ? $_POST['temp_temp3'] : '';

$temp_sensor1 = isset($_POST['temp_sensor1']) ? $_POST['temp_sensor1'] : '';
$temp_onoff1 = isset($_POST['temp_onoff1']) ? $_POST['temp_onoff1'] : '';
$temp_op1 = isset($_POST['temp_op1']) ? $_POST['temp_op1'] : '';
$temp_temp1 = isset($_POST['temp_temp1']) ? $_POST['temp_temp1'] : '';

$temp_sensor2 = isset($_POST['temp_sensor2']) ? $_POST['temp_sensor2'] : '';
$temp_onoff2 = isset($_POST['temp_onoff2']) ? $_POST['temp_onoff2'] : '';
$temp_op2 = isset($_POST['temp_op2']) ? $_POST['temp_op2'] : '';
$temp_temp2 = isset($_POST['temp_temp2']) ? $_POST['temp_temp2'] : '';



$tempon = isset($_POST['tempon']) ? $_POST['tempon'] : '';
if ($tempon == "on") {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET temp_run='on', status='wait', temp_op3='$temp_op3',temp_sensor3='$temp_sensor3',temp_onoff3='$temp_onoff3',temp_temp3='$temp_temp3' WHERE gpio='$gpio_post'") or die("exec 1");
    $db->exec("UPDATE gpio SET temp_op1='$temp_op1',temp_sensor1='$temp_sensor1',temp_onoff1='$temp_onoff1',temp_temp1='$temp_temp1' WHERE gpio='$gpio_post'") or die("exec 2");
    $db->exec("UPDATE gpio SET temp_op2='$temp_op2',temp_sensor2='$temp_sensor2',temp_onoff2='$temp_onoff2',temp_temp2='$temp_temp2' WHERE gpio='$gpio_post'") or die("exec 3");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
if ($tempon == "off") {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET temp_run='off' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    //header("location: " . $_SERVER['REQUEST_URI']);
    //exit();	
    }


$dayrunon = isset($_POST['dayrunon']) ? $_POST['dayrunon'] : '';
$dayrun = isset($_POST['dayrun']) ? $_POST['dayrun'] : '';
if ($dayrunon == "on")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET day_run='$dayrun'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
$arr = array(1,2,3);

include('gpio_onoff.php');

   //$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
   //$sth = $db->prepare("select * from gpio where gpio='$gpio'");
   //$sth->execute();
   //$result = $sth->fetchAll();    
   //foreach ($result as $a) { 
        if ( $a['temp_run'] == "on") { ?>

<td><table>
<?php
foreach ($arr as $v) {
$sth = $db->prepare("SELECT * FROM sensors");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $select) {

if ($a['temp_sensor'.$v] == $select['id']) {
?>
<tr>
<td><?php echo $select['name'];?></td>
<td><?php echo $select['tmp'];?>&deg;C</td>
<td><?php echo $a['temp_op'.$v];?></td>  
<td><?php echo $a['temp_temp'.$v];?>&deg;C</td> 
<td><?php echo $a['temp_onoff'.$v];?></td>
</tr>
<?php
}
}
}
?>
</table></td>
<td>Status:<?php echo $a['status'];?></td>
<form action="" method="post">
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<td><input type="image" src="media/ico/Button-Turn-Off-icon.png"/></td>
<input type="hidden" name="tempon" value="off" />
<input type="hidden" name="off" value="off" />
</form>
<?php
}
else
    {
include('gpio_rev.php');
?>
<form action="" method="post">
    <td><input type="image" name="tempexit" value="tempexit" src="media/ico/Close-2-icon.png" title="Back"  onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
</form>
<form action="" method="post">
	    <td><img  src="media/ico/day-icon.png" title="Day plan" /></td>
	    <td><input type="checkbox" name="dayrun" value="on" <?php echo $a["day_run"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <input type="hidden" name="dayrunon" value="on" /> 
</form>

<td>if</td>
<td>
<form action="" method="post">
<td><table>
<?php 
foreach ($arr as &$v) {
?>
<tr>
<td><select name="<?php echo temp_sensor . $v; ?>" >
	    <?php $sth = $db->prepare("SELECT * FROM sensors");
	    $sth->execute();
	    $result = $sth->fetchAll();
	    foreach ($result as $select) { ?>
		<option <?php echo $a['temp_sensor'.$v] == $select['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']}  {$select['tmp']}" ?>&deg;C</option>
	    <?php } ?>
</select></td>
	<td>
<select name="<?php echo temp_op . $v ?>" >
        <option <?php echo $a['temp_op'.$v] == 'lt' ? 'selected="selected"' : ''; ?> value="lt">&lt;</option>   
        <option <?php echo $a['temp_op'.$v] == 'le' ? 'selected="selected"' : ''; ?> value="le">&lt;&#61;</option>     
        <option <?php echo $a['temp_op'.$v] == 'gt' ? 'selected="selected"' : ''; ?> value="gt">&gt;</option>   
        <option <?php echo $a['temp_op'.$v] == 'ge' ? 'selected="selected"' : ''; ?> value="ge">&gt;&#61;</option>   
</select>
	</td>
	<td><input type="text" name="<?php echo temp_temp . $v ?>" value="<?php echo $a['temp_temp'.$v]; ?>" size=3" >&deg;C</td>
	<td>then</td> 
	<td>
<select name="<?php echo temp_onoff . $v ?>" >
        <option <?php echo $a['temp_onoff'.$v] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
        <option <?php echo $a['temp_onoff'.$v] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
</select></td>
</td>
</tr>
<?php
}
?>
</table>
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
<input type="hidden" name="tempon" value="on" />
</form>
<?php
}
//}
?>


