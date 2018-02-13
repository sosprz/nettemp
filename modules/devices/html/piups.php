<style type="text/css">


/* ---- grid-item ---- */

.grid-item {
    width: 340px;
    float: left;
    border-radius: 5px;
	margin-right: 10px;
	margin-bottom: 20px;
}

</style>
<?php
namespace phpSerial;

define("SERIAL_DEVICE_NOTSET", 0);
define("SERIAL_DEVICE_SET", 1);
define("SERIAL_DEVICE_OPENED", 2);

/**
 * Serial port control class
 *
 * THIS PROGRAM COMES WITH ABSOLUTELY NO WARANTIES !
 * USE IT AT YOUR OWN RISKS !
 *
 * Changes added by Rizwan Kassim <rizwank@geekymedia.com> for OSX functionality
 * default serial device for osx devices is /dev/tty.serial for machines with a built in serial device
 *
 * @author Rémy Sanchez <thenux@gmail.com>
 * @thanks Aurélien Derouineau for finding how to open serial ports with windows
 * @thanks Alec Avedisyan for help and testing with reading
 * @thanks Jim Wright for OSX cleanup/fixes.
 * @copyright under GPL 2 licence
 */

class phpSerial
{
    public $_device = null;
    public $_windevice = null;
    public $_dHandle = null;
    public $_dState = SERIAL_DEVICE_NOTSET;
    public $_buffer = "";
    public $_os = "";

    /**
     * This var says if buffer should be flushed by sendMessage (true) or manualy (false)
     *
     * @var bool
     */
    public $autoflush = true;

    /**
     * Constructor. Perform some checks about the OS and setserial
     *
     * @return phpSerial
     */
    public function phpSerial ()
    {
        setlocale(LC_ALL, "en_US");

        $sysname = php_uname();

        if (substr($sysname, 0, 5) === "Linux") {
            $this->_os = "linux";

            if ($this->_exec("stty --version") === 0) {
                register_shutdown_function(array($this, "deviceClose"));
            } else {
                trigger_error("No stty availible, unable to run.", E_USER_ERROR);
            }
        } elseif (substr($sysname, 0, 6) === "Darwin") {
            $this->_os = "osx";
            // We know stty is available in Darwin.
            // stty returns 1 when run from php, because "stty: stdin isn't a
            // terminal"
            // skip this check
            // if($this->_exec("stty") === 0)
            // {
                register_shutdown_function(array($this, "deviceClose"));
            // }
            // else
            // {
            // 	trigger_error("No stty availible, unable to run.", E_USER_ERROR);
            // }
        } elseif (substr($sysname, 0, 7) === "Windows") {
            $this->_os = "windows";
            register_shutdown_function(array($this, "deviceClose"));
        } else {
            trigger_error("Host OS is neither osx, linux nor windows, unable to run.", E_USER_ERROR);
            exit();
        }
    }

    //
    // OPEN/CLOSE DEVICE SECTION -- {START}
    //

    /**
     * Device set function : used to set the device name/address.
     * -> linux : use the device address, like /dev/ttyS0
     * -> osx : use the device address, like /dev/tty.serial
     * -> windows : use the COMxx device name, like COM1 (can also be used
     *     with linux)
     *
     * @param  string $device the name of the device to be used
     * @return bool
     */
    public function deviceSet ($device)
    {
        if ($this->_dState !== SERIAL_DEVICE_OPENED) {
            if ($this->_os === "linux") {
                if (preg_match("@^COM(\d+):?$@i", $device, $matches)) {
                    $device = "/dev/ttyS" . ($matches[1] - 1);
                }

                if ($this->_exec("stty -F " . $device) === 0) {
                    $this->_device = $device;
                    $this->_dState = SERIAL_DEVICE_SET;

                    return true;
                }
            } elseif ($this->_os === "osx") {
                if ($this->_exec("stty -f " . $device) === 0) {
                    $this->_device = $device;
                    $this->_dState = SERIAL_DEVICE_SET;

                    return true;
                }
            } elseif ($this->_os === "windows") {
                if (preg_match("@^COM(\d+):?$@i", $device, $matches) and $this->_exec(exec("mode " . $device . " xon=on BAUD=9600")) === 0) {
                    $this->_windevice = "COM" . $matches[1];
                    $this->_device = "\\.\com" . $matches[1];
                    $this->_dState = SERIAL_DEVICE_SET;

                    return true;
                }
            }

            trigger_error("Specified serial port is not valid", E_USER_WARNING);

            return false;
        } else {
            trigger_error("You must close your device before to set an other one", E_USER_WARNING);

            return false;
        }
    }

    /**
     * Opens the device for reading and/or writing.
     *
     * @param  string $mode Opening mode : same parameter as fopen()
     * @return bool
     */
    public function deviceOpen ($mode = "r+b")
    {
        if ($this->_dState === SERIAL_DEVICE_OPENED) {
            trigger_error("The device is already opened", E_USER_NOTICE);

            return true;
        }

        if ($this->_dState === SERIAL_DEVICE_NOTSET) {
            trigger_error("The device must be set before to be open", E_USER_WARNING);

            return false;
        }

        if (!preg_match("@^[raw]\+?b?$@", $mode)) {
            trigger_error("Invalid opening mode : ".$mode.". Use fopen() modes.", E_USER_WARNING);

            return false;
        }

        $this->_dHandle = @fopen($this->_device, $mode);

        if ($this->_dHandle !== false) {
            stream_set_blocking($this->_dHandle, 0);
            $this->_dState = SERIAL_DEVICE_OPENED;

            return true;
        }

        $this->_dHandle = null;
        trigger_error("Unable to open the device", E_USER_WARNING);

        return false;
    }

    /**
     * Closes the device
     *
     * @return bool
     */
    public function deviceClose ()
    {
        if ($this->_dState !== SERIAL_DEVICE_OPENED) {
            return true;
        }

        if (fclose($this->_dHandle)) {
            $this->_dHandle = null;
            $this->_dState = SERIAL_DEVICE_SET;

            return true;
        }

        trigger_error("Unable to close the device", E_USER_ERROR);

        return false;
    }

    //
    // OPEN/CLOSE DEVICE SECTION -- {STOP}
    //

    //
    // CONFIGURE SECTION -- {START}
    //

    /**
     * Configure the Baud Rate
     * Possible rates : 110, 150, 300, 600, 1200, 2400, 4800, 9600, 38400,
     * 57600 and 115200.
     *
     * @param  int  $rate the rate to set the port in
     * @return bool
     */
    public function confBaudRate ($rate)
    {
        if ($this->_dState !== SERIAL_DEVICE_SET) {
            trigger_error("Unable to set the baud rate : the device is either not set or opened", E_USER_WARNING);

            return false;
        }

        $validBauds = array (
            110    => 11,
            150    => 15,
            300    => 30,
            600    => 60,
            1200   => 12,
            2400   => 24,
            4800   => 48,
            9600   => 96,
            19200  => 19,
            38400  => 38400,
            57600  => 57600,
            115200 => 115200
        );

        if (isset($validBauds[$rate])) {
            if ($this->_os === "linux") {
                $ret = $this->_exec("stty -F " . $this->_device . " " . (int) $rate, $out);
            }
            if ($this->_os === "osx") {
                $ret = $this->_exec("stty -f " . $this->_device . " " . (int) $rate, $out);
            } elseif ($this->_os === "windows") {
                $ret = $this->_exec("mode " . $this->_windevice . " BAUD=" . $validBauds[$rate], $out);
            } else {
                return false;
            }

            if ($ret !== 0) {
                trigger_error("Unable to set baud rate: " . $out[1], E_USER_WARNING);

                return false;
            }
        }
    }

    /**
     * Configure parity.
     * Modes : odd, even, none
     *
     * @param  string $parity one of the modes
     * @return bool
     */
    public function confParity ($parity)
    {
        if ($this->_dState !== SERIAL_DEVICE_SET) {
            trigger_error("Unable to set parity : the device is either not set or opened", E_USER_WARNING);

            return false;
        }

        $args = array(
            "none" => "-parenb",
            "odd"  => "parenb parodd",
            "even" => "parenb -parodd",
        );

        if (!isset($args[$parity])) {
            trigger_error("Parity mode not supported", E_USER_WARNING);

            return false;
        }

        if ($this->_os === "linux") {
            $ret = $this->_exec("stty -F " . $this->_device . " " . $args[$parity], $out);
        } elseif ($this->_os === "osx") {
            $ret = $this->_exec("stty -f " . $this->_device . " " . $args[$parity], $out);
        } else {
            $ret = $this->_exec("mode " . $this->_windevice . " PARITY=" . $parity{0}, $out);
        }

        if ($ret === 0) {
            return true;
        }

        trigger_error("Unable to set parity : " . $out[1], E_USER_WARNING);

        return false;
    }

    /**
     * Sets the length of a character.
     *
     * @param  int  $int length of a character (5 <= length <= 8)
     * @return bool
     */
    public function confCharacterLength ($int)
    {
        if ($this->_dState !== SERIAL_DEVICE_SET) {
            trigger_error("Unable to set length of a character : the device is either not set or opened", E_USER_WARNING);

            return false;
        }

        $int = (int) $int;
        if ($int < 5) {
            $int = 5;
        } elseif ($int > 8) {
            $int = 8;
        }

        if ($this->_os === "linux") {
            $ret = $this->_exec("stty -F " . $this->_device . " cs" . $int, $out);
        } elseif ($this->_os === "osx") {
            $ret = $this->_exec("stty -f " . $this->_device . " cs" . $int, $out);
        } else {
            $ret = $this->_exec("mode " . $this->_windevice . " DATA=" . $int, $out);
        }

        if ($ret === 0) {
            return true;
        }

        trigger_error("Unable to set character length : " .$out[1], E_USER_WARNING);

        return false;
    }

    /**
     * Sets the length of stop bits.
     *
     * @param float $length the length of a stop bit. It must be either 1,
     * 1.5 or 2. 1.5 is not supported under linux and on some computers.
     * @return bool
     */
    public function confStopBits ($length)
    {
        if ($this->_dState !== SERIAL_DEVICE_SET) {
            trigger_error("Unable to set the length of a stop bit : the device is either not set or opened", E_USER_WARNING);

            return false;
        }

        if ($length != 1 and $length != 2 and $length != 1.5 and !($length == 1.5 and $this->_os === "linux")) {
            trigger_error("Specified stop bit length is invalid", E_USER_WARNING);

            return false;
        }

        if ($this->_os === "linux") {
            $ret = $this->_exec("stty -F " . $this->_device . " " . (($length == 1) ? "-" : "") . "cstopb", $out);
        } elseif ($this->_os === "osx") {
            $ret = $this->_exec("stty -f " . $this->_device . " " . (($length == 1) ? "-" : "") . "cstopb", $out);
        } else {
            $ret = $this->_exec("mode " . $this->_windevice . " STOP=" . $length, $out);
        }

        if ($ret === 0) {
            return true;
        }

        trigger_error("Unable to set stop bit length : " . $out[1], E_USER_WARNING);

        return false;
    }

    /**
     * Configures the flow control
     *
     * @param string $mode Set the flow control mode. Availible modes :
     * 	-> "none" : no flow control
     * 	-> "rts/cts" : use RTS/CTS handshaking
     * 	-> "xon/xoff" : use XON/XOFF protocol
     * @return bool
     */
    public function confFlowControl ($mode)
    {
        if ($this->_dState !== SERIAL_DEVICE_SET) {
            trigger_error("Unable to set flow control mode : the device is either not set or opened", E_USER_WARNING);

            return false;
        }

        $linuxModes = array(
            "none"     => "clocal -crtscts -ixon -ixoff",
            "rts/cts"  => "-clocal crtscts -ixon -ixoff",
            "xon/xoff" => "-clocal -crtscts ixon ixoff"
        );
        $windowsModes = array(
            "none"     => "xon=off octs=off rts=on",
            "rts/cts"  => "xon=off octs=on rts=hs",
            "xon/xoff" => "xon=on octs=off rts=on",
        );

        if ($mode !== "none" and $mode !== "rts/cts" and $mode !== "xon/xoff") {
            trigger_error("Invalid flow control mode specified", E_USER_ERROR);

            return false;
        }

        if ($this->_os === "linux") {
            $ret = $this->_exec("stty -F " . $this->_device . " " . $linuxModes[$mode], $out);
        } elseif ($this->_os === "osx") {
            $ret = $this->_exec("stty -f " . $this->_device . " " . $linuxModes[$mode], $out);
        } else {
            $ret = $this->_exec("mode " . $this->_windevice . " " . $windowsModes[$mode], $out);
        }
        if ($ret === 0) {
            return true;
        } else {
            trigger_error("Unable to set flow control : " . $out[1], E_USER_ERROR);

            return false;
        }
    }

    /**
     * Sets a setserial parameter (cf man setserial)
     * NO MORE USEFUL !
     * 	-> No longer supported
     * 	-> Only use it if you need it
     *
     * @param  string $param parameter name
     * @param  string $arg   parameter value
     * @return bool
     */
    public function setSetserialFlag ($param, $arg = "")
    {
        if (!$this->_ckOpened()) {
            return false;
        }

        $return = exec("setserial " . $this->_device . " " . $param . " " . $arg . " 2>&1");

        if ($return{0} === "I") {
            trigger_error("setserial: Invalid flag", E_USER_WARNING);

            return false;
        } elseif ($return{0} === "/") {
            trigger_error("setserial: Error with device file", E_USER_WARNING);

            return false;
        } else {
            return true;
        }
    }

    //
    // CONFIGURE SECTION -- {STOP}
    //

    //
    // I/O SECTION -- {START}
    //

    /**
     * Sends a string to the device
     *
     * @param string $str          string to be sent to the device
     * @param float  $waitForReply time to wait for the reply (in seconds)
     */
    public function sendMessage ($str, $waitForReply = 0.1)
    {
        $this->_buffer .= $str;

        if ($this->autoflush === true) {
            $this->serialflush();
        }

        usleep((int) ($waitForReply * 1000000));
    }

    /**
     * Reads the port until no new datas are availible, then return the content.
     *
     * @pararm int $count number of characters to be read (will stop before
     * 	if less characters are in the buffer)
     * @return string
     */
    public function readPort ($count = 0)
    {
        if ($this->_dState !== SERIAL_DEVICE_OPENED) {
            trigger_error("Device must be opened to read it", E_USER_WARNING);

            return false;
        }

        if ($this->_os === "linux" || $this->_os === "osx") {
            // Behavior in OSX isn't to wait for new data to recover, but just grabs what's there!
            // Doesn't always work perfectly for me in OSX
            $content = "";
            $i = 0;

            if ($count !== 0) {
                do {
                    if ($i > $count) {
                        $content .= fread($this->_dHandle, ($count - $i));
                    } else {
                        $content .= fread($this->_dHandle, 128);
                    }
                } while (($i += 128) === strlen($content));
            } else {
                do {
                    $content .= fread($this->_dHandle, 128);
                } while (($i += 128) === strlen($content));
            }

            return $content;
        } elseif ($this->_os === "windows") {
            // Windows port reading procedures still buggy
            $content = "";
            $i = 0;

            if ($count !== 0) {
                do {
                    if ($i > $count) {
                        $content .= fread($this->_dHandle, ($count - $i));
                    } else {
                        $content .= fread($this->_dHandle, 128);
                    }
                } while (($i += 128) === strlen($content));
            } else {
                do {
                    $content .= fread($this->_dHandle, 128);
                } while (($i += 128) === strlen($content));
            }

            return $content;
        }

        return false;
    }

    /**
     * Flushes the output buffer
     * Renamed from flush for osx compat. issues
     *
     * @return bool
     */
    public function serialflush ()
    {
        if (!$this->_ckOpened()) {
            return false;
        }

        if (fwrite($this->_dHandle, $this->_buffer) !== false) {
            $this->_buffer = "";

            return true;
        } else {
            $this->_buffer = "";
            trigger_error("Error while sending message", E_USER_WARNING);

            return false;
        }
    }

    //
    // I/O SECTION -- {STOP}
    //

    //
    // INTERNAL TOOLKIT -- {START}
    //

    public function _ckOpened()
    {
        if ($this->_dState !== SERIAL_DEVICE_OPENED) {
            trigger_error("Device must be opened", E_USER_WARNING);

            return false;
        }

        return true;
    }

    public function _ckClosed()
    {
        if ($this->_dState !== SERIAL_DEVICE_CLOSED) {
            trigger_error("Device must be closed", E_USER_WARNING);

            return false;
        }

        return true;
    }

    public function _exec($cmd, &$out = null)
    {
        $desc = array(
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );

        $proc = proc_open($cmd, $desc, $pipes);

        $ret = stream_get_contents($pipes[1]);
        $err = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $retVal = proc_close($proc);

        if (func_num_args() == 2) {
            $out = array($ret, $err);
        }

        return $retVal;
    }

    //
    // INTERNAL TOOLKIT -- {STOP}
    //
}
?>


<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
$root=$_SERVER["DOCUMENT_ROOT"];


require("$root/php_serial.class.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');






$upsdelayon = isset($_POST['upsdelayon']) ? $_POST['upsdelayon'] : '';
$upsdelayoff = isset($_POST['upsdelayoff']) ? $_POST['upsdelayoff'] : '';
$upsakkuchargestart = isset($_POST['upsakkuchargestart']) ? $_POST['upsakkuchargestart'] : '';
$upsakkuchargestop = isset($_POST['upsakkuchargestop']) ? $_POST['upsakkuchargestop'] : '';
$upsakkudischarged = isset($_POST['upsakkudischarged']) ? $_POST['upsakkudischarged'] : '';
$upsscroll = isset($_POST['upsscroll']) ? $_POST['upsscroll'] : '';
$upsbacklight = isset($_POST['upsbacklight']) ? $_POST['upsbacklight'] : '';
$savetoups = isset($_POST['savetoups']) ? $_POST['savetoups'] : '';

 if  ($savetoups == "savetoups") {
    $db = new PDO("sqlite:$root/dbf/nettemp.db");
    $db->exec("UPDATE nt_settings SET value='$upsdelayon' WHERE option='ups_delay_on'");
	$db->exec("UPDATE nt_settings SET value='$upsdelayoff' WHERE option='ups_delay_off'");
	$db->exec("UPDATE nt_settings SET value='$upsakkuchargestart' WHERE option='ups_akku_charge_start'");
	$db->exec("UPDATE nt_settings SET value='$upsakkuchargestop' WHERE option='ups_akku_charge_stop'");
	$db->exec("UPDATE nt_settings SET value='$upsakkudischarged' WHERE option='ups_akku_discharged'");
	$db->exec("UPDATE nt_settings SET value='$upsscroll' WHERE option='ups_lcd_scroll'");
	$db->exec("UPDATE nt_settings SET value='$upsbacklight' WHERE option='ups_lcd_backlight'");
	
	// tutaj zapis do UPSA
	
	$cmd=("exec 3</dev/ttyUSB0 && echo -n 'U 60 61 3.9 4.0 3.3 2 1\r' >/dev/ttyUSB0 && head -1 <&3; exec 3<&-");
	shell_exec($cmd);
	
	
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
	
// wczytanie danych ups	

$readups = isset($_POST['readups']) ? $_POST['readups'] : '';
if  ($readups == "readups") { $read='on';

$serial = new phpSerial();
	
	$serial->deviceSet("/dev/ttyUSB0");
	$serial->confBaudRate(9600);
	$serial->confParity("none");
	$serial->confCharacterLength(8);
	$serial->confStopBits(1);
	$serial->confFlowControl("none");
	$serial->deviceOpen();
	$serial->sendMessage("O\r");
	$out = $serial->readPort();

    $out=trim($out);
    $data=explode(" ",$out);
	
   //var_dump($out);
   //var_dump($data);
   
   
   for($i=0;$i<count($data);$i++){
          
		$d1=$data[0];
		$d2=$data[1];
		$d3=$data[2];
		$d4=$data[3];
		$d5=$data[4];
		$d6=$data[5];
		$d7=$data[6];        
   }

}

$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT name, tmp, position FROM sensors WHERE rom LIKE '%UPS_id%' ORDER BY position ASC");
$row = $rows->fetchAll();

?>

<div class="grid">
<div class="grid-sizer"></div>
<div class="grid-item">
<div class="panel panel-default">

<div class="panel-heading">PiUPS Status</div>
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<tbody>
		<?php
		foreach ($row as $a) { ?>	
		
		<tr>
		<td><span class="label label-default"><?php echo str_replace("_", " ", $a['name']); ?></span></td>
		<td><span class="label label-success"><?php echo $a['tmp']; ?></span></td>	
		<td></td>		
		</tr>
		<?php
		}
		?>
		
	

		</tbody>
	</table>
</div>
		</div>
	</div>
		
		
		
		
		<div class="grid-item">
				<div class="panel panel-default">

							<div class="panel-heading">PiUPS Settings</div>
							<div class="table-responsive">
								<table class="table table-hover table-condensed">

										<tbody>
												<tr>
												<td><span class="label label-default">Delay ON</span></td>
												<td> <span class="label label-success"><?php echo $d1 ?></span></td>
<td>
	<form action="" method="post" style="display:inline!important;">
	<input type="text" name="upsdelayon" size="2" maxlength="3" value="<?php echo $nts_ups_delay_on; ?>" />
    
</td>

												</tr>

												<tr>
												<td><span class="label label-default">Delay OFF</span></td>
												<td><span class="label label-success"><?php echo $d2  ?></span></td>
<td>

	<input type="text" name="upsdelayoff" size="2" maxlength="3" value="<?php echo $nts_ups_delay_off; ?>" />
    
</td>
												</tr>

												<tr>
												<td><span class="label label-default">Akku. charge start</span></td>
												<td><span class="label label-success"><?php echo $d3 ?></span></td>
<td>
	
	<input type="text" name="upsakkuchargestart" size="2" maxlength="3" value="<?php echo $nts_ups_akku_charge_start; ?>" />
    
</td>
												</tr>

												<tr>
												<td><span class="label label-default">Akku. charge stop</span></td>
												<td><span class="label label-success"><?php echo $d4  ?></span></td>
<td>
	
	<input type="text" name="upsakkuchargestop" size="2" maxlength="3" value="<?php echo $nts_ups_akku_charge_stop; ?>" />
    
</td>	
												</tr>

												<tr>
												<td><span class="label label-default">Akku. discharged</span></td>
												<td><span class="label label-success"><?php echo $d5 ?></span></td>
<td>
	
	<input type="text" name="upsakkudischarged" size="2" maxlength="3" value="<?php echo $nts_ups_akku_discharged; ?>" />
    
</td>
											
												</tr>

												<tr>
												<td><span class="label label-default">LCD Scrolling</span></td>
												<td><span class="label label-success"><?php echo $d6  ?></span></td>
<td>
	
	<input type="text" name="upsscroll" size="2" maxlength="3" value="<?php echo $nts_ups_lcd_scroll; ?>" />
	
	 
    
</td>	
												</tr>

												<tr>
												<td><span class="label label-default">LCD Auto Backlight</span></td>
												<td><span class="label label-success"><?php echo $d7  ?></span></td>
<td>
	
	<select class="selectpicker" data-width="50px" name="upsbacklight" class="form-control input-sm">
		
		<option value="TAK" <?php echo $nts_ups_lcd_backlight == '1' ? 'selected="selected"' : ''; ?> >Yes</option>
		<option value="NIE" <?php echo $nts_ups_lcd_backlight == '0'? 'selected="selected"' : ''; ?> >No</option>
		
		</select>
	
	
	
    
</td>
												</tr>

<tr>
	<td>
				<button type="submit" name="serviceups" value="serviceups"class="btn btn-xs btn-warning">Service Mode</button>
				<button type="submit" name="infoups" value="infoups" class="btn btn-xs btn-info">Info</button>
			
		
	</td>
	<td>
				<button type="submit" name="readups" value="readups"class="btn btn-xs btn-success">Read</button>
				
	</td>
	<td>
				<button type="submit" name="savetoups" value="savetoups" class="btn btn-xs btn-danger">Save</button>
				</form>
	</td>
</tr>
											
												
												
												

		</tbody>
	</table>
</div>
				</div>
		</div>


</div>