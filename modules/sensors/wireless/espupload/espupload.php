<span class="belka">&nbsp ESPuploader - based on luaupload<span class="okno"> 
<?php
$dir=$_SERVER["DOCUMENT_ROOT"];
$usb = $_POST["usb"];
$ds18b20 = $_POST["ds18b20"];
$dht11 = $_POST["dht11"];
$list = $_POST["list"];
$ssid = $_POST["ssid"];
$pass = $_POST["pass"];
if ($_POST['run'] == "run") {

    if (!empty($usb)) {
	if (!empty($ds18b20) || !empty($dht11)) {
	    if (!empty($ssid) && !empty($pass)) {
		    if (!empty($dht11) ) {
			$cmd="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/modules/sensors/wireless/DHT11/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/modules/sensors/wireless/DHT11/dht.lua -t dht.lua 2>&1";
			echo '<pre>';
			passthru($cmd); 
			passthru($cmd2); 
			echo '</pre>';
		    }
		    if (!empty($ds18b20) ) {
			$cmd="'$dir'/modules/sensors/wireless/espupload/luatool.py -r -p '$usb' -f '$dir'/modules/sensors/wireless/dh18b20/init.lua -t init.lua 2>&1";
			echo '<pre>';
			passthru($cmd); 
			echo '</pre>';
		    }
			$cmd="echo 'wifi.sta.config('\"'$ssid'\"','\"'$pass'\"');' > '$usb'";
			//echo "wifi.sta.config(\"gateway7\",\"142w1f1m0rm0w1f1142\")" > /dev/ttyUSB0
	    		$cmd2="echo  'node.restart();' > '$usb'";
			passthru($cmd); 
			passthru($cmd2); 
	    }
	    else {
		    echo "Error - no SSID and Password"; 
		    echo '<br><br>';
	    }
	}
	elseif (!empty($list)) {
		$cmd="'$dir'/modules/sensors/wireless/espupload/luatool.py -l -p '$usb' 2>&1";
		echo '<pre>';
		passthru($cmd); 
		echo '</pre>';
	}
	else
	{
	    echo "Eroor - Select program";
	    echo '<br><br>';
	} 
    } else
    { 
	echo "Error - Select USB device"; 
	echo '<br><br>';
    }


} //end post


$cmd="ls /dev/ttyU*";
exec($cmd, $i);
//print_r($i);
?>
<form action="" method="post">
Select device:<br>
<?php
foreach($i as $o ) {
    $cmdd="udevadm info -q all --name='$o' 2> /dev/null |grep -m1 ID_MODEL |cut -c 13-";
    exec($cmdd, $ii);
?>
    <input type="radio" name="usb" value="<?php echo $o ?>" ><?php echo $ii[0] ." ". $o ?>
    <br><br>
<?php
}
?>
Select program:<br>
    <input type="radio" name="dht11" value="dht11" >DHT11
    <br>
    <input type="radio" name="ds81b20" value="ds81b20" >DS18B20
    <br><br>
Configure WiFi:<br>
    SSID:   <input type="input" name="ssid" value="" ><br>
    Pasword:<input type="input" name="pass" value="" ><br>
    <br><br>
Other:<br>
    <input type="radio" name="list" value="list" >List files on ESP
    <br><br>
    
    
    <input type="submit" name="run" value="run">
    </form>

</span></span>



