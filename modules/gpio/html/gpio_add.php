<?php 
$gpioad=$_POST['gpioad'];

if ($_POST['add'] == "ADD") {
exec("$dir/gpio add " . escapeshellarg($gpioad));
header("location: " . $_SERVER['REQUEST_URI']);
exit();
}

if ($_POST['del'] == "DEL") {
exec("$dir/gpio del " . escapeshellarg($gpioad));
header("location: " . $_SERVER['REQUEST_URI']);
exit(); 
} ?>
<span class="belka">&nbsp Add / del <span class="okno">
<?php
$gpiolist = array(17,18,21,22,23,24,25);
foreach ($gpiolist as $value1) {

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM gpio WHERE gpio='$value1'");
$row = $rows->fetchAll();
foreach ($row as $result) { 
    $check = $result["gpio"]; 
}; ?>
<table><tr>
    <form action="gpio" method="post">
    <td><img src="media/ico/TO-220-icon.png" /></td>
    <td>Gpio <?php echo $value1; ?></td>
<?php if ($check != $value1) { ?>
    <input type="hidden" name="gpioad" value="<?php echo $value1; ?>" >
    <input type="hidden" name="add" value="ADD" />
    <td><input type="image" src="media/ico/Add-icon.png"  /></td>
    </form>

<?php } ?>
    <form action="gpio" method="post"> 
    <input type="hidden" name="gpioad" value="<?php echo $value1; ?>" >
    <input type="hidden" name="del" value="DEL" />
    <td><input type="image" src="media/ico/Close-2-icon.png"  /></td>
    </form>
</tr></table>
<?php } ?>
</span></span>
