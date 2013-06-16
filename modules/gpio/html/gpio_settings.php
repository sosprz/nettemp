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


if (($_POST['off'] == "OFF")) {
exec("$dir/gpio off $gpio_post");
header("location: " . $_SERVER['REQUEST_URI']);
exit(); 
}

if ($_POST['on'] == "ON")  {
		$db = new PDO('sqlite:dbf/nettemp.db');
	        $db->exec("UPDATE gpio SET custom_time_on='$custom_time_on' WHERE gpio='$gpio_post'") ;
		if (!empty($timecm) ) {	$db->exec("UPDATE gpio SET custom_time='$timec' WHERE gpio='$gpio_post'") ;  }
	        $sth = $db->prepare("SELECT * FROM gpio WHERE gpio='$gpio_post'");
                $sth->execute();
	        $result = $sth->fetchAll();
		    foreach ($result as $a) { $cto=$a["custom_time_on"]; }
			exec("$dir/gpio on $gpio_post"); 
			    if ( $cto == 'on' ) { exec("$dir/gpio timeon $gpio_post");}
//temp
$db->exec("UPDATE gpio SET gpio_temp_sensor='$gpio_temp_sensor' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_on='$gpio_temp_on' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_set='$gpio_temp_set' WHERE gpio='$gpio_post'") ;
$db->exec("UPDATE gpio SET gpio_temp_state='$gpio_temp_state' WHERE gpio='$gpio_post'") ;

header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['name1'] == "name2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE gpio SET name='$name' WHERE id='$name_id'") or die ($db->lastErrorMsg());
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

exec("$dir/gpio onoff $gpio", $out_arr);
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
	<td><?php passthru("$dir/gpio check $gpio");?> </td>
	</tr></table>
 <?php	} elseif ($out == 'off') { ?>
	<table>
	<form action="gpio" method="post">
	<td><img type="image" src="media/ico/SMD-64-pin-icon_24.png" ></td>
	<td><input type="text" name="name" value="<?php echo $a['name']; ?>" size="10"></td>
	<input type="hidden" name="name1" value="name2">
	<input type="hidden" name="name_id" value="<?php echo $a['id']; ?>" >
	<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" alt="Submit" ></td>
	</form>
	<td>                           </td>
	<form action="gpio" method="post">
	<td><img  src="media/ico/Clock-icon.png" /></td>
	<td><input type="checkbox" name="custom_time_on" value="on" <?php echo $a["custom_time_on"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.elements['timecm'].disabled = !this.checked" ><td>
	<td><input type="text" name="timecm" value="<?php echo $a['custom_time']/60; ?>" size="5" disabled="disabled" ></td><td>min</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="on" value="ON" />
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	</form>


	<td>                           </td>
	<form action="gpio" method="post">
	<td><img  src="media/ico/temp2-icon.png" /></td>
	<td><input type="checkbox" name="gpio_temp_on" value="on" <?php echo $a["gpio_temp_on"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.elements['gpio_temp_sensor'].disabled = this.form.elements['gpio_temp_state'].disabled = this.form.elements['gpio_temp_set'].disabled =!this.checked" ><td>
	<select name="gpio_temp_sensor" disabled="disabled">
	<?php $sth = $db->prepare("SELECT * FROM sensors");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $select) { ?>
	<option <?php echo $a['gpio_temp_sensor'] == $select['name'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['name']; ?>"><?php echo $select['name']; ?></option>
	<?php } ?>
	</select>
	<select name="gpio_temp_state" disabled="disabled" >
	<option <?php echo $a['gpio_temp_state'] == 'gr' ? 'selected="selected"' : ''; ?> value="gr">greater</option>	
	<option <?php echo $a['gpio_temp_state'] == 'lo' ? 'selected="selected"' : ''; ?> value="lo">lower</option>	
	</select>
	<td><input type="text" name="gpio_temp_set" value="<?php echo $a['gpio_temp_set']; ?>" size="2" disabled="disabled" ></td>
	<td>C</td> 
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="on" value="ON" />
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
	</form>
	</tr>
	</table>


<?php } ?>
	</span></span>
<?php } ?>

