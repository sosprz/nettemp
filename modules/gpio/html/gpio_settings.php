<?php
$dir="modules/gpio/";

$timecm=$_POST['timecm'];
$times=$_POST['time'];
$name=$_POST['name'];
$name_id=$_POST['name_id'];
$gpio_post=$_POST['gpio'];

$time=($times*60);
$timec=($timecm*60);
$custom_time_on=$_POST['custom_time_on'];


$gpio_temp_on=$_POST['gpio_temp_on'];
$gpio_temp_set=$_POST['gpio_temp_set'];
$gpio_temp_state=$_POST['gpio_temp_state'];
$gpio_temp_sensor=$_POST['gpio_temp_sensor'];
$gpio_temp_onoff=$_POST['gpio_temp_onoff'];

if (($_POST['off'] == "OFF")) {
exec("$dir/gpio off $gpio_post");
header("location: " . $_SERVER['REQUEST_URI']);
exit(); 
}

if ($_POST['on'] == "ON")  {
echo "onON";

	if (!empty($timecm)) {
		$db = new PDO('sqlite:dbf/nettemp.db');
	       		if (!empty($timecm)) {	
				$db->exec("UPDATE gpio SET custom_time='$timec' WHERE gpio='$gpio_post'");
				exec("$dir/gpio timeon $gpio_post");  
				exec("$dir/gpio on $gpio_post");

			}
	       // $sth = $db->prepare("SELECT * FROM gpio WHERE gpio='$gpio_post'");
               // $sth->execute();
	       // $result = $sth->fetchAll();
		//    foreach ($result as $a) { $cto=$a["custom_time_on"]; }
		//	exec("$dir/gpio on $gpio_post"); 
		//	    if ( $cto == 'on' ) { exec("$dir/gpio timeon $gpio_post");}
        }
	else {	
		exec("$dir/gpio on $gpio_post");
		echo "wlaczam";
	}
		

header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['timeon'] == "timeON")  {
		$db = new PDO('sqlite:dbf/nettemp.db');
	        $db->exec("UPDATE gpio SET custom_time_on='$custom_time_on' WHERE gpio='$gpio_post'") ;
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['tempon'] == "tempON")  {
		$db = new PDO('sqlite:dbf/nettemp.db');
	        $db->exec("UPDATE gpio SET gpio_temp_on='$gpio_temp_on' WHERE gpio='$gpio_post'") ;
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}


if ($_POST['on_temp'] == "ON")  {
		$db = new PDO('sqlite:dbf/nettemp.db');

$db->exec("UPDATE gpio SET gpio_temp_sensor='$gpio_temp_sensor' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_on='$gpio_temp_on' WHERE gpio='$gpio_post'") ;


$db->exec("UPDATE gpio SET gpio_temp_set='$gpio_temp_hilow' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_set='$gpio_temp_set' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_onoff='$gpio_temp_onoff' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_state='$gpio_temp_state' WHERE gpio='$gpio_post'") ;

echo $gpio_temp_sensor;
echo $gpio_temp_on;
echo $gpio_temp_set;
echo $gpio_temp_state;
echo $gpio_temp_onoff;

//header("location: " . $_SERVER['REQUEST_URI']);
//exit();

}

if ($_POST['name1'] == "name2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE gpio SET name='$name' WHERE id='$name_id'") or die ($db->lastErrorMsg());
header("location: " . $_SERVER['REQUEST_URI']);
exit();
	 } 



$gpio_rev_hilo = $_POST["gpio_rev_hilo"];
if (($_POST['gpio_rev_hilo1'] == "gpio_rev_hilo2") ){
        $db = new PDO('sqlite:dbf/nettemp.db');
	if (!empty($gpio_rev_hilo)) { $db->exec("UPDATE gpio SET gpio_rev_hilo='$gpio_rev_hilo' WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg()); }
	else {$db->exec("UPDATE gpio SET gpio_rev_hilo='off' WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());}
    	header("location: " . $_SERVER['REQUEST_URI']);
    	exit();
    }



//main loop

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from gpio");
$sth->execute();
$result = $sth->fetchAll();

foreach ( $result as $a) {
?>
<span class="belka">&nbsp Gpio <?php echo $a['gpio']; ?> <span class="okno">
<?php $gpio=$a['gpio'];

exec("$dir/gpio status $gpio", $out_arr);
    $out=$out_arr[0];
    unset($out_arr);    

    if ($out == 'on') { ?>
	<table><tr>
	<form action="gpio" method="post">
	<td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
	<td><?php echo $a['name']; ?></td>
	<input type="hidden" name="gpio" value="<?php echo "$gpio"; ?> "/>
	<input type="hidden" name="off" value="OFF" />
	<td><input type="image"  src="media/ico/Button-Turn-Off-icon.png"/></td>
	</form>
	<td><?php passthru("$dir/gpio checktime $gpio");?> </td>
	</tr></table>
 <?php	} elseif ($out == 'off') { ?>
	<table>
	<tr>
	<form action="gpio" method="post">
	<td><img type="image" src="media/ico/SMD-64-pin-icon_24.png" ></td>
	<td><input type="text" name="name" value="<?php echo $a['name']; ?>" size="10"></td>
	<input type="hidden" name="name1" value="name2">
	<input type="hidden" name="name_id" value="<?php echo $a['id']; ?>" >
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" alt="Submit" title="Reload" ></td>
	</form>
	<td>                           </td>
	<form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	</form>

	<form action="gpio" method="post">
	<td><img  src="media/ico/Clock-icon.png" title="Set time"/></td>
	<td><input type="checkbox" name="custom_time_on" value="on" <?php echo $a["custom_time_on"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeon" value="timeON" />        
       </form>
	<form action="gpio" method="post">
	<td><img  src="media/ico/temp2-icon.png" title="Set temp when sensor will turn on/off" /></td>
	<td><input type="checkbox" name="gpio_temp_on" value="on" <?php echo $a["gpio_temp_on"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempon" value="tempON" />
	</form>
	
	<form action="gpio" method="post">
        
<?php if  ($a['custom_time_on'] == 'on') { ?>
	
	<td><input type="text" name="timecm" value="<?php echo $a['custom_time']/60; ?>" size="5"  ></td><td>min</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	
       <?php } ?>
	
<?php if  ($a['gpio_temp_on'] == 'on') { ?>
       <td>
	<select name="gpio_temp_sensor" >
	<?php $sth = $db->prepare("SELECT * FROM sensors");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $select) { ?>
	<option <?php echo $a['gpio_temp_sensor'] == $select['name'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['name']; ?>"><?php echo $select['name']; ?></option>
	<?php } ?>
        </select></td>
	<td>
        <select name="gpio_temp_onoff" >
        <option <?php echo $a['gpio_temp_onoff'] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
        <option <?php echo $a['gpio_temp_onoff'] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
        </select></td>
	<td><select name="gpio_temp_state" >
	<option <?php echo $a['gpio_temp_state'] == 'gr' ? 'selected="selected"' : ''; ?> value="gr">greater</option>	
	<option <?php echo $a['gpio_temp_state'] == 'lo' ? 'selected="selected"' : ''; ?> value="lo">lower</option>	
	</select></td>
	<td><input type="text" name="gpio_temp_set" value="<?php echo $a['gpio_temp_set']; ?>" size="2" ></td>
	<td>C</td> 
	
	
<?php } ?>
	
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	<input type="hidden" name="on" value="ON" />

	</form>
	</tr>
	</table>


<?php } ?>
	</span></span>
<?php } ?>

 
