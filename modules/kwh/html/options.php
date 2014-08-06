<?php
include('conf.php');
$kwh_divider = $_POST["kwh_divider"];  //sql
?>

<?php 
	
	
	
	if ( $_POST['kwh_divider1'] == "kwh_divider2"){
	$db = new PDO('sqlite:dbf/nettemp.db');
	$db->exec("UPDATE gpio SET gpio_kwh_divider='$kwh_divider' WHERE gpio_kwh='on'") or die ($db->lastErrorMsg());
	$db = NULL;
	$reset="/bin/bash -x $global_dir/modules/kwh/reset";
	shell_exec("$reset");
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 


	$kwh_hilo = $_POST["kwh_hilo"];
	$gpio = $_POST["gpio"];
	if (($_POST['kwh_hilo1'] == "kwh_hilo2") ){
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
        $db->exec("UPDATE gpio SET gpio_kwh_hilo='$kwh_hilo' WHERE gpio='$gpio'") or die("name exec error");
	$db = NULL;
	$reset="/bin/bash -x $global_dir/modules/kwh/reset";
	shell_exec("$reset");
		header("location: " . $_SERVER['REQUEST_URI']);
	exit();
        } 
	

?>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("select gpio_kwh_divider from gpio where gpio_kwh='on'");
$sth->execute();
$result = $sth->fetchAll();

foreach ($result as $a) { ?>

<span class="belka">&nbsp kWh options<span class="okno">
	<form action="kwh" method="post">
	<td>Divider</td>
	<td><input type="text" name="kwh_divider" size="20" value="<?php echo $a["gpio_kwh_divider"]; ?>"  /></td>
	<input type="hidden" name="kwh_divider1" value="kwh_divider2" />
	<td><input type="image" src="media/ico/Add-icon.png" /></td>
	</tr>
	</form>

<?php } ?>

<?php
$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$sth = $db->prepare("select * from gpio where gpio_kwh='on'");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) { ?>
	
	<form action="kwh" method="post">
        <tr><td>Input state   </td><td><select name="kwh_hilo" onchange="this.form.submit()" >
        <option <?php echo $a['gpio_kwh_hilo'] == '1' ? 'selected="selected"' : ''; ?> value="1" >1 (high)</option>
        <option <?php echo $a['gpio_kwh_hilo'] == '0' ? 'selected="selected"' : ''; ?> value="0" >0 (low)</option>     
        </td></tr></select>
	    <input type="hidden" name="kwh_hilo1" value="kwh_hilo2" />
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	</form>
<?php } ?>


</span></span>