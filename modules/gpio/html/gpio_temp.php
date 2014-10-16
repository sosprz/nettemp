<?php
$tempoff = isset($_POST['tempoff']) ? $_POST['tempoff'] : '';
if (($tempoff == "tempoff") ){
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

//  $temp_grlo=$_POST['temp_grlo'];

$temp_temp = isset($_POST['temp_temp']) ? $_POST['temp_temp'] : '';
$tempon = isset($_POST['tempon']) ? $_POST['tempon'] : '';
if ($tempon == "tempON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET temp_run='on',temp_op='$temp_op',temp_sensor='$temp_sensor',temp_onoff='$temp_onoff',temp_temp='$temp_temp' WHERE gpio='$gpio_post'") or die("exec error");
    if (!empty($day_zone1s) && !empty($day_zone1e)) {
	$db->exec("UPDATE gpio SET tempday_run='on',day_zone1s='$day_zone1s',day_zone1e='$day_zone1e' WHERE gpio='$gpio_post'") or die("exec error");
	}
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$day_zone1s = isset($_POST['day_zone1s']) ? $_POST['day_zone1s'] : '';
$day_zone1e = isset($_POST['day_zone1e']) ? $_POST['day_zone1e'] : '';
$dayon = isset($_POST['dayon']) ? $_POST['dayon'] : '';
if ($dayon == "dayON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET day_run='on', day_zone1s='$day_zone1s',day_zone1e='$day_zone1e'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
?>

    
    <form action="" method="post">
	<td><img  src="media/ico/day-icon.png" title="Day plan" /></td>
	<td><input type="checkbox" name="tempday_checkbox" value="on" <?php echo $a["tempday_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="xtempdayon" value="xtempdayON" />
    </form>
    <form action="" method="post">
	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	</form>
    <td>
    if
    </td>
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
	<?php if ($a['tempday_checkbox'] == 'on') { ?>
        <td>Time</td>
        <td><input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="4"  ></td><td></td> 
        <td>to</td>
        <td><input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="4"  ></td><td></td> 
	<?php } ?>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="tempon" value="tempON" />
	<form action="" method="post">
	<td><input type="image" name="tempoff" value="off" src="media/ico/back-icon.png" title="Back"  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempoff" value="tempoff" />
    </form>
</form>
