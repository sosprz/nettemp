<?php
$dir="modules/gpio/";

$gpio_post=$_POST['gpio'];
$time_offset=$_POST['time_offset'];
$time_checkbox=$_POST['time_checkbox'];
$temp_checkbox=$_POST['temp_checkbox'];
$humi_checkbox=$_POST['humi_checkbox'];

$name=$_POST['name'];

$temp_sensor=$_POST['temp_sensor'];
$temp_onoff=$_POST['temp_onoff'];
$temp_grlo=$_POST['temp_grlo'];
$temp_temp=$_POST['temp_temp'];



//old
$times=$_POST['time'];
$name_id=$_POST['name_id'];
$time=($times*60);
$timec=($timecm*60);
$custom_time_on=$_POST['custom_time_on'];



if ($_POST['on'] == "ON")  {
	
	if (!empty($time_offset)) {
//		exec("$dir/gpio on " . escapeshellarg($gpio_post) . escapeshellarg($time_offset)); //not working
    		exec("$dir/gpio2 on $gpio_post $time_offset");
        }
	elseif (!empty($temp_sensor)) {
//		exec("$dir/gpio on " . escapeshellarg($gpio_post) . escapeshellarg($temp_sensor) . escapeshellarg($temp_onoff) . escapeshellarg($temp_temp)); //not work
		exec("$dir/gpio2 on $gpio_post $temp_sensor $temp_onoff $temp_temp");
	}
	else {	
//		exec("$dir/gpio on " . escapeshellarg($gpio_post));
		exec("$dir/gpio2 on $gpio_post");
		
	}
		

header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['timeon'] == "timeON")  {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE gpio SET time_checkbox='$time_checkbox' WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE gpio SET temp_checkbox='off' WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();

}

if ($_POST['tempon'] == "tempON")  {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE gpio SET temp_checkbox='$temp_checkbox' WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
    $db->exec("UPDATE gpio SET time_checkbox='off' WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();

}

if ($_POST['humion'] == "humiON")  {
    $db = new PDO('sqlite:dbf/nettemp.db');
    exec("$dir/gpio2 humi $gpio_post");

header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['name1'] == "name2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE gpio SET name='$name' WHERE id='$name_id'") or die ($db->lastErrorMsg());
header("location: " . $_SERVER['REQUEST_URI']);
exit();
	 } 

$gpio_rev_hilo = $_POST["gpio_rev_hilo"];
if (($_POST['gpio_rev_hilo1'] == "gpio_rev_hilo2") ){
    exec("$dir/gpio2 rev " . escapeshellarg($gpio_post));
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

if (($_POST['off'] == "OFF")) {
    exec("$dir/gpio2 off $gpio_post");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit(); 
}

$dht11_onoff = $_POST["dht11_onoff"];
if (($_POST['dht11_onoff1'] == "dht11_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE gpio SET humi_type='$dht11_onoff' where gpio='$gpio_post' ") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
echo $gpio_post;
echo $dht11_onoff;
    }
$dht22_onoff = $_POST["dht22_onoff"];
if (($_POST['dht22_onoff1'] == "dht22_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE gpio SET humi_type='$dht22_onoff' where gpio='$gpio_post' ") or die ($db->lastErrorMsg());
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
echo $gpio_post;
echo $dht11_onoff;

    }





//main loop

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from gpio");
$sth->execute();
$result = $sth->fetchAll();

foreach ( $result as $a) {
?>
<span class="belka">&nbsp Gpio <?php echo $a['gpio']; ?> <span class="okno">
<?php 
$gpio=$a['gpio'];
exec("$dir/gpio2 status $gpio", $out_arr);
    $out=$out_arr[0];
    //print_r ($out_arr); //debug
    unset($out_arr);    
    
    if ($out == 'on' ) { ?>
	<table><tr>
	<form action="gpio" method="post">
	<td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
	<td><?php echo $a['name']; ?></td>
	<input type="hidden" name="gpio" value="<?php echo "$gpio"; ?> "/>
	<input type="hidden" name="off" value="OFF" />
	<td><?php passthru("$dir/gpio2 check $gpio");?> </td>
	<td><input type="image"  src="media/ico/Button-Turn-Off-icon.png"/></td>
	</form>
	
	</tr></table>
 <?php	} elseif ($out == 'off' || $out == 'temp' || $out == 'humi'  ) { ?>
	<table>
	<tr>
	<form action="gpio" method="post">
	<td><img type="image" src="media/ico/SMD-64-pin-icon_24.png" ></td>
	<td><input type="text" name="name" value="<?php echo $a['name']; ?>" size="10"></td>
	<input type="hidden" name="name1" value="name2">
	<input type="hidden" name="name_id" value="<?php echo $a['id']; ?>" >
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" alt="Submit" title="Reload" ></td>
	</form>

<?php if  ($a['humi_checkbox'] == 'on') 
{ ?>
	<form action="gpio" method="post">
	<td><img  src="media/ico/rain-icon.png" title="Humidity on/off" /></td>
	<td><input type="checkbox" name="humi_checkbox" value="on" <?php echo $a["humi_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="humion" value="humiON" />
	</form>
	Humidity is enable
        <form action="gpio" method="post">
	<td>DHT11</td>
	<td><input type="checkbox" name="dht11_onoff" value="11" <?php echo $a["humi_type"] == '11' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dht11_onoff1" value="dht11_onoff2" />
	</form>
	<form action="gpio" method="post">
	<td>DHT22</td>
	<td><input type="checkbox" name="dht22_onoff" value="22" <?php echo $a["humi_type"] == '22' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dht22_onoff1" value="dht22_onoff2" />
	</form>


<?php } elseif ($a['time_checkbox'] == 'on') { ?>
	<form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	</form>

	<form action="gpio" method="post">
	<td><img  src="media/ico/Clock-icon.png" title="Set time"/></td>
	<td><input type="checkbox" name="time_checkbox" value="on" <?php echo $a["time_checkbox"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeon" value="timeON" />        
        </form>
	<form action="gpio" method="post">
	<td><input type="text" name="time_offset" value="<?php echo $a['time_offset']/60; ?>" size="8"  ></td><td>min</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="on" value="ON" />
	</form>

<?php } elseif  ($a['temp_checkbox'] == 'on') { ?>
	<form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	</form>

	<form action="gpio" method="post">
	<td><img  src="media/ico/temp2-icon.png" title="Set temp when sensor will turn on/off" /></td>
	<td><input type="checkbox" name="temp_checkbox" value="on" <?php echo $a["temp_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempon" value="tempON" />
	</form>
	<td>if</td>
       <td>
	<form action="gpio" method="post">
	<select name="temp_sensor" >
	<?php $sth = $db->prepare("SELECT * FROM sensors");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $select) { ?>
	<option <?php echo $a['temp_sensor'] == $select['name'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']}  {$select['tmp']}C" ?></option>
	<?php } ?>
        </select></td>
		<td>&gt;</td>
	<td><input type="text" name="temp_temp" value="<?php echo $a['temp_temp']; ?>" size="2" >C</td>
	<td>then</td> 
	<td>
        <select name="temp_onoff" >
        <option <?php echo $a['temp_onoff'] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
        <option <?php echo $a['temp_onoff'] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
        </select></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="on" value="ON" />
	</form>
<?php } else { ?>
	<td>                           </td>
	<form action="gpio" method="post">
	<td><img  src="media/ico/Clock-icon.png" title="Set time"/></td>
	<td><input type="checkbox" name="time_checkbox" value="on" <?php echo $a["time_checkbox"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeon" value="timeON" />        
       </form>
	<form action="gpio" method="post">
	<td><img  src="media/ico/temp2-icon.png" title="Set temp when sensor will turn on/off" /></td>
	<td><input type="checkbox" name="temp_checkbox" value="on" <?php echo $a["temp_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempon" value="tempON" />
	</form>
	<form action="gpio" method="post">
	<td><img  src="media/ico/rain-icon.png" title="Humidity on/off" /></td>
	<td><input type="checkbox" name="humi_checkbox" value="on" <?php echo $a["humi_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="humion" value="humiON" />
	</form>
	<form action="gpio" method="post">
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="on" value="ON" />
	</form>

<?php } ?>


	
	</tr>
	</table>


<?php } ?>
	</span></span>
<?php } ?>

 
