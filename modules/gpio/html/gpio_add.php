<?php 
$gpioad = isset($_POST['gpioad']) ? $_POST['gpioad'] : '';
$add = isset($_POST['add']) ? $_POST['add'] : '';
$del = isset($_POST['del']) ? $_POST['del'] : '';
$check = isset($_POST['check']) ? $_POST['check'] : '';

if ( $add == "ADD") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("INSERT INTO gpio (gpio, name, time_start, gpio_rev_hilo ,gpio_kwh_divider) VALUES ('$gpioad','new','off','off','1')") or die ($db->lastErrorMsg());
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
}
if ( $del == "DEL") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("DELETE FROM gpio WHERE gpio='$gpioad'") or die ($db->lastErrorMsg());
	$db = NULL;
	unset($del);
	//exec("/usr/local/bin/gpio reset $gpioad");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit(); 
}
?>
<span class="belka">&nbsp Add / del <span class="okno">
<?php
$gpiolist = array(17,18,21,22,23,24,25);
foreach ($gpiolist as $value1) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM gpio WHERE gpio='$value1'");
	$row = $rows->fetchAll();
	foreach ($row as $result) { 
   	$check = $result['gpio']; 
	}; ?>
<table><tr>
    <form action="" method="post">
    	<td><img src="media/ico/TO-220-icon.png" /></td>
    	<td>Gpio <?php echo $value1; ?></td>
	 	<?php if ( $check != $value1) { ?>
    	<input type="hidden" name="gpioad" value="<?php echo $value1; ?>" >
    	<input type="hidden" name="add" value="ADD" />
    	<td><input type="image" src="media/ico/Add-icon.png"  /></td>
    </form>
<?php } ?>
    <form action="" method="post"> 
    	<input type="hidden" name="gpioad" value="<?php echo $value1; ?>" >
    	<input type="hidden" name="del" value="DEL" />
    	<td><input type="image" src="media/ico/Close-2-icon.png"  /></td>
    </form>
</tr></table>
<?php } ?>
</span></span>
