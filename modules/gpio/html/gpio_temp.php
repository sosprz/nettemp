<?php
$tempexit = isset($_POST['tempexit']) ? $_POST['tempexit'] : '';
if ($tempexit == "tempexit"){
    $db->exec("UPDATE gpio SET mode='', day_run='', week_run='' where gpio='$gpio_post' ") or die("simple off db error");
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
    $db->exec("UPDATE gpio SET temp_run='on', status='wait' WHERE gpio='$gpio_post'") or die("exec 1");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$tempset = isset($_POST['tempset']) ? $_POST['tempset'] : '';
if ($tempset == "on") {
    $db->exec("UPDATE gpio SET temp_op3='$temp_op3',temp_sensor3='$temp_sensor3',temp_onoff3='$temp_onoff3',temp_temp3='$temp_temp3' WHERE gpio='$gpio_post'") or die("exec 1");
    $db->exec("UPDATE gpio SET temp_op1='$temp_op1',temp_sensor1='$temp_sensor1',temp_onoff1='$temp_onoff1',temp_temp1='$temp_temp1' WHERE gpio='$gpio_post'") or die("exec 2");
    $db->exec("UPDATE gpio SET temp_op2='$temp_op2',temp_sensor2='$temp_sensor2',temp_onoff2='$temp_onoff2',temp_temp2='$temp_temp2' WHERE gpio='$gpio_post'") or die("exec 3");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }


if ($tempon == "off") {
	include('gpio_off.php');
    $db->exec("UPDATE gpio SET temp_run='off' WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }


$dayrunon = isset($_POST['dayrunon']) ? $_POST['dayrunon'] : '';
$dayrun = isset($_POST['dayrun']) ? $_POST['dayrun'] : '';
if ($dayrunon == "on")  {
    $db->exec("UPDATE gpio SET day_run='$dayrun'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }
$weekrunon = isset($_POST['weekrunon']) ? $_POST['weekrunon'] : '';
$weekrun = isset($_POST['weekrun']) ? $_POST['weekrun'] : '';
if ($weekrunon == "on")  {
    $db->exec("UPDATE gpio SET week_run='$weekrun'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$day_zone1s = isset($_POST['day_zone1s']) ? $_POST['day_zone1s'] : '';
$day_zone1e = isset($_POST['day_zone1e']) ? $_POST['day_zone1e'] : '';
$day_zone2s = isset($_POST['day_zone2s']) ? $_POST['day_zone2s'] : '';
$day_zone2e = isset($_POST['day_zone2e']) ? $_POST['day_zone2e'] : '';
$day_zone3s = isset($_POST['day_zone3s']) ? $_POST['day_zone3s'] : '';
$day_zone3e = isset($_POST['day_zone3e']) ? $_POST['day_zone3e'] : '';

$dayset = isset($_POST['dayset']) ? $_POST['dayset'] : '';
if ($dayset == "on")  {
    $db->exec("UPDATE gpio SET day_zone1s='$day_zone1s',day_zone1e='$day_zone1e',day_zone2s='$day_zone2s',day_zone2e='$day_zone2e',day_zone3s='$day_zone3s',day_zone3e='$day_zone3e'  WHERE gpio='$gpio_post'") or die("exec error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();	
    }

$Mon = isset($_POST['Mon']) ? $_POST['Mon'] : '';
$MonMon = isset($_POST['MonMon']) ? $_POST['MonMon'] : '';
    if ( $Mon == "Mon" ) {
    $db->exec("UPDATE gpio SET week_Mon='$MonMon' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Tue = isset($_POST['Tue']) ? $_POST['Tue'] : '';
$TueTue = isset($_POST['TueTue']) ? $_POST['TueTue'] : '';
    if ( $Tue == "Tue" ) {
    $db->exec("UPDATE gpio SET week_Tue='$TueTue' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Wed = isset($_POST['Wed']) ? $_POST['Wed'] : '';
$WedWed = isset($_POST['WedWed']) ? $_POST['WedWed'] : '';
    if ( $Wed == "Wed" ) {
    $db->exec("UPDATE gpio SET week_Wed='$WedWed' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Thu = isset($_POST['Thu']) ? $_POST['Thu'] : '';
$ThuThu = isset($_POST['ThuThu']) ? $_POST['ThuThu'] : '';
    if ( $Thu == "Thu" ) {
    $db->exec("UPDATE gpio SET week_Thu='$ThuThu' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Fri = isset($_POST['Fri']) ? $_POST['Fri'] : '';
$FriFri = isset($_POST['FriFri']) ? $_POST['FriFri'] : '';
    if ( $Fri == "Fri" ) {
    $db->exec("UPDATE gpio SET week_Fri='$FriFri' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Sun = isset($_POST['Sun']) ? $_POST['Sun'] : '';
$SunSun = isset($_POST['SunSun']) ? $_POST['SunSun'] : '';
    if ( $Sun == "Sun" ) {
    $db->exec("UPDATE gpio SET week_Sun='$SunSun' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$Sat = isset($_POST['Sat']) ? $_POST['Sat'] : '';
$SatSat = isset($_POST['SatSat']) ? $_POST['SatSat'] : '';
    if ( $Sat == "Sat" ) {
    $db->exec("UPDATE gpio SET week_Sat='$SatSat' where gpio='$gpio_post' ") or die("simple off db error");
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }






// MAIN

$arr = array(1,2,3);
        if ( $a['temp_run'] == "on") { ?>

<td><table>
<?php
foreach ($arr as $v) {
$sth = $db->prepare("SELECT * FROM sensors");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $select) {

if (($a['temp_sensor'.$v] == $select['id']) && (!empty($a['temp_temp'.$v]))) {
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
    <input type="hidden" name="tempexit" value="tempexit" /> 
</form>
<form action="" method="post">
	    <td><img  src="media/ico/day-icon.png" title="Day plan" /></td>
	    <td><input type="checkbox" name="dayrun" value="on" <?php echo $a["day_run"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <input type="hidden" name="dayrunon" value="on" /> 
</form>
<form action="" method="post">
	    <td><img  src="media/ico/Actions-view-calendar-week-icon.png" title="Week plan" /></td>
	    <td><input type="checkbox" name="weekrun" value="on" <?php echo $a["week_run"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <input type="hidden" name="weekrunon" value="on" /> 
</form>
<?php 
    if ($a['day_run'] == 'on') { 
?>

<table border="0">
<tr>    
    <td>
    <table border="0">
    <tr>
	<td>
	    <table>
	    <form action="" method="post">
	    <tr><td>Set hour range:</td></tr>
	    <tr><td>Zone 1 <input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="2"  >-<input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="2"  ></td></tr> 
	    <tr><td>Zone 2 <input type="text" name="day_zone2s" value="<?php echo $a['day_zone2s']; ?>" size="2"  >-<input type="text" name="day_zone2e" value="<?php echo $a['day_zone2e']; ?>" size="2"  ></td></tr> 
	    <tr><td>Zone 3 <input type="text" name="day_zone3s" value="<?php echo $a['day_zone3s']; ?>" size="2"  >-<input type="text" name="day_zone3e" value="<?php echo $a['day_zone3e']; ?>" size="2"  ></td></tr>
	    <tr><td>example: 07:00 - 15:00</td></tr> 
	    </table>
	</td>
	<td>
	    <table>
	    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	    <tr><td><input type="image" src="media/ico/Actions-edit-redo-icon.png"/></td></tr>
	    <input type="hidden" name="dayset" value="on" />
	    </form>
	    </table>
	</td>
    </tr>
    </table>
    </td>
    <?php 
	} 
    ?>

    <td>
    <table border="0">
    <tr>
	<td>
	    <table>
	    <form action="" method="post">
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
	    </select>
	    </td>
	    <td>
	    <select name="<?php echo temp_op . $v ?>" >
    		<option <?php echo $a['temp_op'.$v] == 'lt' ? 'selected="selected"' : ''; ?> value="lt">&lt;</option>   
    		<option <?php echo $a['temp_op'.$v] == 'le' ? 'selected="selected"' : ''; ?> value="le">&lt;&#61;</option>     
    		<option <?php echo $a['temp_op'.$v] == 'gt' ? 'selected="selected"' : ''; ?> value="gt">&gt;</option>   
    		<option <?php echo $a['temp_op'.$v] == 'ge' ? 'selected="selected"' : ''; ?> value="ge">&gt;&#61;</option>   
	    </select>
	    </td>
	    <td><input type="text" name="<?php echo temp_temp . $v ?>" value="<?php echo $a['temp_temp'.$v]; ?>" size="1" >&deg;C</td>
	    <td>then</td> 
	    <td>
	    <select name="<?php echo temp_onoff . $v ?>" >
    	    <option <?php echo $a['temp_onoff'.$v] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
    	    <option <?php echo $a['temp_onoff'.$v] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
	    </select>
	    </td>
	    </tr>
	</td>
    </tr>
<?php
}
?>
</table>
</td>

<td>
<table>
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<tr><td><input type="image" src="media/ico/Actions-edit-redo-icon.png"/></td><tr>
<input type="hidden" name="tempset" value="on" />
</form>
</table>
</td>


<td>
<table>
<form action="" method="post">
<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
<tr><td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td><tr>
<input type="hidden" name="tempon" value="on" />
</form>
</table>
</td>


<?php
    if ($a['week_run'] == 'on') { 
?>
<tr>
<table border="0B">
<tr>
<?php
$arr = array(Mon, Tue, Wed, Thu, Fri, Sat, Sun);
foreach ($arr as &$days) {
?>
    <form action="" method="post">
    <td>
    <label><?php echo $days ?></label>
   <input type="checkbox" name="<?php echo $days; echo $days; ?>" value="on" <?php echo $a['week_'.$days] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
    <input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    <input type="hidden" name="<?php echo $days; ?>" value="<?php echo $days; ?>"/>
    
    </form>
<?php
}
?>
</tr>
</table>
</tr>

<?php 
    }
?>


</tr>
</table>
</td>
</tr> <!--last-->





</table>
<?php
}
//}
?>


