<?php
$dir="modules/relays/";

$timecm=$_POST['timecm'];
$times=$_POST['time'];
$name=$_POST['name'];
$name_id=$_POST['name_id'];
$gpio_post=$_POST['gpio'];

$time=($times*60);
$timec=($timecm*60);

if ($_POST['off'] == "OFF") {
exec("$dir/gpio off $gpio_post");
header("location: " . $_SERVER['REQUEST_URI']);
exit(); 
}

if ($_POST['on'] == "ON")  {
exec("$dir/gpio on $gpio_post");
	if (!empty($timec) ) { exec("$dir/gpio timeon $gpio_post $timec");}
	elseif ($time != "all") { exec("$dir/gpio timeon $gpio_post $time"); }
header("location: " . $_SERVER['REQUEST_URI']);
exit();

}

if ($_POST['name1'] == "name2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE relays SET name='$name' WHERE id='$name_id'") or die ($db->lastErrorMsg());
header("location: " . $_SERVER['REQUEST_URI']);
exit();
	 } 

//main loop

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select * from relays");
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
	<form action="relays" method="post">
	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" />
	<?php echo $a['name']; ?>
	<input type="hidden" name="gpio" value="<?php echo "$gpio"; ?> "/>
	<input type="image" name="off" value="OFF" src="media/ico/Button-Turn-Off-icon.png"/>
	</form>
<?php
	passthru("$dir/gpio check $gpio");
	} 
	elseif ($out == 'off') {
?>
	<form action="relays" method="post">
	<img src="media/ico/SMD-64-pin-icon_24.png" />
	<input type="text" name="name" value="<?php echo $a['name']; ?>" />
	<input type="hidden" name="name1" value="name2"/>
	<input type="hidden" name="name_id" value="<?php echo $a['id']; ?>" />
	<input type="image" src="media/ico/Actions-edit-redo-icon.png" />
	</form>
	<form action="relays" method="post">
	<img type="image" src="media/ico/Clock-icon.png" />
	<input type="radio" name="time" value="all" />All time 
	<input type="radio" name="time" value="60" checked="checked"/>1 hour (default)
	<input type="radio" name="time" value="120" />2 hour
	<input type="radio" name="time" value="180" />3 hour
	<input type="text" name="timecm" value="" /> Custom min
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="image" name="on" value="ON" src="media/ico/Button-Turn-On-icon.png"/>
	</form>
<?php } ?>
	</span></span>
<?php } ?>

