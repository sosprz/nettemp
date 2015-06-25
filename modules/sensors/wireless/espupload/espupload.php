<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">ESPupload</h3>
</div>
<div class="panel-body">
<?php
$dir=$_SERVER["DOCUMENT_ROOT"];
$usb = $_POST["usb"];
$ds18b20 = $_POST["ds18b20"];
$dht11 = $_POST["dht11"];
$dht22 = $_POST["dht22"];
$relay = $_POST["relay"];
$list = $_POST["list"];
$ssid = $_POST["ssid"];
$pass = $_POST["pass"];
if ($_POST['run'] == "Upload") {

    if (!empty($usb)) {
	if (!empty($ds18b20) || !empty($dht11) || !empty($dht22) || !empty($relay)) {
	    if (!empty($ssid) && !empty($pass)) {
		    if (!empty($dht11) ) {

			$cmd0="cp '$dir'/modules/sensors/wireless/DHT11/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -r -p '$usb' -f '$dir'/modules/sensors/wireless/DHT11/dht.lua -t dht.lua -r 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
			passthru($cmd2);
			echo '</pre>';
		    }
		    if (!empty($dht22) ) {

			$cmd0="cp '$dir'/modules/sensors/wireless/DHT22/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -r -p '$usb' -f '$dir'/modules/sensors/wireless/DHT22/dht.lua -t dht.lua -r 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
			passthru($cmd2);
			echo '</pre>';
		    }
		    if (!empty($ds18b20) ) {
			$cmd0="cp '$dir'/modules/sensors/wireless/ds18b20/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua 2>&1";
			$cmd2="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/modules/sensors/wireless/ds18b20/ds18b20.lua -t ds18b20.lua -r 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
			passthru($cmd2); 
			echo '</pre>';
		    }
		    if (!empty($relay) ) {
			$cmd0="cp '$dir'/modules/sensors/wireless/relay/init.lua '$dir'/tmp && sed -i s/pass/'$pass'/g '$dir'/tmp/init.lua && sed -i s/ssid/'$ssid'/g '$dir'/tmp/init.lua";
			$cmd1="'$dir'/modules/sensors/wireless/espupload/luatool.py -p '$usb' -f '$dir'/tmp/init.lua -t init.lua -r 2>&1";
			echo '<pre>';
			passthru($cmd0); 
			passthru($cmd1); 
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
	    		//$cmdr="echo  'node.restart();' > '$usb'";
			//passthru($cmdr); 
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

<form class="form-horizontal" action="" method="post">
<fieldset>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="usb">Select USB</label>
  <div class="col-md-5">
    <select id="usb" name="usb" class="form-control">
<?php
$n=0;
foreach($i as $o ) {
    $cmdd="udevadm info -q all --name='$o' 2> /dev/null |grep -m1 ID_MODEL |cut -c 13-";
    exec($cmdd, $name);
?>
 <option value="<?php echo $o ?>"><?php echo $name["$n"] ." ". $o ?></option>
<?php
$n=$n+1;
}
?>


    </select>
  </div>
</div>

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">ESP8266 Programs</label>
  <div class="col-md-4">
  <div class="radio">
    <label for="radios-0">
      <input name="dht11" id="radios-0" value="dht11" checked="checked" type="radio">
      DHT11
    </label>
    </div>
  <div class="radio">
    <label for="radios-1">
      <input name="dht22" id="radios-1" value="dht22" type="radio">
      DHT22
    </label>
    </div>
  <div class="radio">
    <label for="radios-2">
      <input name="relay" id="radios-2" value="relay" type="radio">
      Relay pin4
    </label>
    </div>
  <div class="radio">
    <label for="radios-3">
      <input name="ds18b20" id="radios-3" value="ds18b20" type="radio">
      DS18B20
    </label>
    </div>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="ssid">SSID</label>  
  <div class="col-md-4">
  <input id="ssid" name="ssid" placeholder="" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass">Password</label>
  <div class="col-md-4">
    <input id="pass" name="pass" placeholder="" class="form-control input-md" required="" type="password">
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">List files</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0">
      <input name="list" id="list" value="on" type="checkbox">
      list files
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="run"></label>
  <div class="col-md-4">
    <button id="run" name="run" value="Upload" class="btn btn-primary">Upload</button>
  </div>
</div>

</fieldset>
</form>



</div>
</div>



