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
$temp_sensor = isset($_POST['temp_sensor']) ? $_POST['temp_sensor'] : '';
$temp_onoff = isset($_POST['temp_onoff']) ? $_POST['temp_onoff'] : '';
$temp_op = isset($_POST['temp_op']) ? $_POST['temp_op'] : '';
$temp_temp = isset($_POST['temp_temp']) ? $_POST['temp_temp'] : '';

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
    $db->exec("UPDATE gpio SET temp_op='$temp_op',temp_sensor='$temp_sensor',temp_onoff='$temp_onoff',temp_temp='$temp_temp' WHERE gpio='$gpio_post'") or die("exec error");
    $db->exec("UPDATE gpio SET temp_op1='$temp_op1',temp_sensor1='$temp_sensor1',temp_onoff1='$temp_onoff1',temp_temp1='$temp_temp1' WHERE gpio='$gpio_post'") or die("exec error");
    $db->exec("UPDATE gpio SET temp_op2='$temp_op2',temp_sensor2='$temp_sensor2',temp_onoff2='$temp_onoff2',temp_temp2='$temp_temp2' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
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
	<select name="temp_sensor" >
	    <?php $sth = $db->prepare("SELECT * FROM sensors");
	    $sth->execute();
	    $result = $sth->fetchAll();
	    foreach ($result as $select) { ?>
		<option <?php echo $a['temp_sensor'] == $select['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']}  {$select['tmp']}" ?>&deg;C</option>
	    <?php } ?>
        </select></td>
	<td>
    <select name="temp_op" >
        <option <?php echo $a['temp_op'] == 'lt' ? 'selected="selected"' : ''; ?> value="lt">&lt;</option>   
        <option <?php echo $a['temp_op'] == 'le' ? 'selected="selected"' : ''; ?> value="le">&lt;&#61;</option>     
        <option <?php echo $a['temp_op'] == 'gt' ? 'selected="selected"' : ''; ?> value="gt">&gt;</option>   
        <option <?php echo $a['temp_op'] == 'ge' ? 'selected="selected"' : ''; ?> value="ge">&gt;&#61;</option>   
    </select>
	</td>
	<td><input type="text" name="temp_temp" value="<?php echo $a['temp_temp']; ?>" size=3" >&deg;C</td>
	<td>then</td> 
	<td>
        <select name="temp_onoff" >
        <option <?php echo $a['temp_onoff'] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
        <option <?php echo $a['temp_onoff'] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
        </select></td>
	
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
<input type="hidden" name="tempon" value="on" />
</form>



