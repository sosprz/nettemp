<div class="panel panel-default">
<div class="panel-heading">Bind USB to devices</div>
<table class="table table-striped">
<thead><tr><th>Device</th><th>Function</th></tr></thead>
<?php
$dir=$_SERVER["DOCUMENT_ROOT"];

$usb=isset($_POST['usb']) ? $_POST['usb'] : '';
$setusb=isset($_POST['setusb']) ? $_POST['setusb'] : '';
$device=isset($_POST['device']) ? $_POST['device'] : '';
if ($setusb == "setusb") {
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE usb SET dev='$usb' WHERE device='$device'");
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
} 

$row = exec('ls /dev/ttyU* & ls /dev/ttyA* & /dev/ttyS*',$output,$error);
    while(list(,$row) = each($output)){
	//exec("udevadm info -q all --name=$row 2> /dev/null |grep -m1 ID_MODEL_FROM_DATABASE |cut -c 27-",$info);
	exec("udevadm info -q all --name=$row 2> /dev/null |grep -m1 ID_MODEL= |cut -c 13- && udevadm info -q all --name=$row 2> /dev/null |grep -m1 ID_MODEL_FROM_DATABASE= |cut -c 27-",$info);
		$devs[$row][]=$info[0]." ".$info[1];
		unset($info);
    }

//print_r($devs);

$db = new PDO('sqlite:dbf/nettemp.db');
$sth = $db->prepare("SELECT * FROM usb");
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $a) {

?>
<tr>
<td class="col-md-1">
    <?php
	echo $a['device']; 
    ?>
</td>
<td class="col-md-2">
    <form action="" method="post">
	<select name="usb" class="form-control input-sm" onchange="this.form.submit()">
	    <?php foreach($devs as $key => $de) { ?>
		    <option value="<?php echo $key ?>"  <?php echo $a['dev'] == $key ? 'selected="selected"' : ''; ?>  ><?php echo $key." ".$de[0] ?></option>
		<?php
		    }
		?>
		    <option value="none" <?php echo $a['dev'] == 'none' ? 'selected="selected"' : ''; ?>  >none</option>
	</select>
	<input type="hidden" name="setusb" value="setusb"/>
	<input type="hidden" name="device" value="<?php echo $a['device'] ?>"/>
    </form>
</td>
<td class="col-md-3">
</td>
</tr>
<?php
}
?>
</table>
</div>

