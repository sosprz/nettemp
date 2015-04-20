<span class="belka">&nbsp ESPuploader - based on luaupload<span class="okno"> 
<?php
$dir=$_SERVER["DOCUMENT_ROOT"];
$usb = $_POST["usb"];
$ds18b20 = $_POST["ds18b20"];
$dht11 = $_POST["dht11"];
$dht22 = $_POST["dht22"];
$list = $_POST["list"];
$ssid = $_POST["ssid"];
$pass = $_POST["pass"];
if ($_POST['run'] == "run") {

    if (!empty($usb)) {
	if (!empty($ds18b20) || !empty($dht11) || !empty($dht22)) {
	    if (!empty($ssid) && !empty($pass)) {
		    if (!empty($dht11) ) {

			$cmd0="cp '$dir'/modules/sensors/wireless/DHT11/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -r -p '$usb' -f '$dir'/modules/sensors/wireless/DHT11/dht.lua -t dht.lua 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
			passthru($cmd2);
			echo '</pre>';
		    }
		    if (!empty($dht22) ) {

			$cmd0="cp '$dir'/modules/sensors/wireless/DHT22/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -r -p '$usb' -f '$dir'/modules/sensors/wireless/DHT22/dht.lua -t dht.lua 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
			passthru($cmd2);
			echo '</pre>';
		    }
		    if (!empty($ds18b20) ) {
			$cmd0="cp '$dir'/modules/sensors/wireless/ds18b20/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/modules/sensors/wireless/ds18b20/ds18b20.lua -t ds18b20.lua 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
			passthru($cmd2); 
			echo '</pre>';
		    }
		    
			//file.open("init.lua", "a+")
		        //file.writeline('foo bar')
			//file.close()
			//$cmd1="echo 'wifi.setmode(wifi.STATION)' > '$usb'";
			//$cmd2="echo 'wifi.sta.config('\"'$ssid'\"','\"'$pass'\"');' > '$usb'";

			//echo "wifi.setmode(wifi.STATION)" > /dev/ttyUSB0
			//echo "wifi.sta.config(\"ap\",\"pass\")" > /dev/ttyUSB0
			

			//$cmd1="echo 'file.open('\"'init.lua'\"', '\"'a+'\"')' > '$usb'";
			//$cmd2="echo 'file.writeline('wifi.setmode(wifi.STATION)')' > '$usb'";
			//cmd3="echo 'file.writeline('wifi.sta.config('\"'$ssid'\"','\"'$pass'\"')')' > '$usb'";
			//$cmd4="echo 'file.close()' > '$usb'";
			//$cmd1="echo 'wifi.setmode(wifi.STATION)' > '$usb'";
			//$cmd2="echo 'wifi.sta.config('\"'$ssid'\"','\"'$pass'\"');' > '$usb'";
	    		$cmdr="echo  'node.restart();' > '$usb'";
			passthru($cmdr); 
			//passthru($cmd2); 
			//passthru($cmd3); 
			//passthru($cmd4); 
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
	    echo "Error - Select program";
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
    <input type="radio" name="dht22" value="dht22" >DHT22
    <br>
    <input type="radio" name="dht11" value="dht11" >DHT11
    <br>
    <input type="radio" name="ds18b20" value="ds18b20" >DS18B20
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



