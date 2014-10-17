<?php
//time
    $timeon = isset($_POST['timeon']) ? $_POST['timeon'] : '';
    if ($timeon == "timeon")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='time' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//temp
    $tempon = isset($_POST['tempon']) ? $_POST['tempon'] : '';
    if ($tempon == "tempon")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='temp' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//humid
    $humidon = isset($_POST['humidon']) ? $_POST['humidon'] : '';
    if ($humidon == "humidon")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='humid' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//dayon
    $dayon = isset($_POST['dayon']) ? $_POST['dayon'] : '';
    if ($dayon == "dayon")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='day' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//triggeron
    $triggeron = isset($_POST['triggeron']) ? $_POST['triggeron'] : '';
    if ($triggeron == "triggeron")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='trigger' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//kwh
    $kwhon = isset($_POST['kwhon']) ? $_POST['kwhon'] : '';
    if ($kwhon == "kwhon")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='kwh' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//simple
    $simpleon = isset($_POST['simpleon']) ? $_POST['simpleon'] : '';
    if ($simpleon == "simpleon")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='simple' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }


?>

    <form action="" method="post">
	<td><input type="image" src="media/ico/Button-Turn-On-icon.png" title="Simple on/off" onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="simpleon" value="simpleon" />
    </form>
    <form action="" method="post">
	<td><input type="image" src="media/ico/Clock-icon.png" title="Set time" onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeon" value="timeon" />   
   </form>
    <form action="" method="post">
	<td><input type="image" src="media/ico/temp2-icon.png" title="Set temp when sensor will turn on/off" onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempon" value="tempon" />
    </form>
    <form action="" method="post">
	<td><input type="image" src="media/ico/rain-icon.png" title="Humidity on/off"  onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio'];?>"/>
	<input type="hidden" name="humidon" value="humidon" />
    </form> 
    <form action="" method="post">
	<td><input type="image" src="media/ico/day-icon.png" title="Day plan"   onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayon" value="dayon" />
    </form>
    <form action="" method="post">
	<td><input type="image" src="media/ico/alarm-icon.png" title="Alarm trigger" onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggeron" value="triggeron" />
    </form>
    <form action="" method="post">
	<td><input type="image" src="media/ico/Lamp-icon.png" title="kWh metter" onclick="this.form.submit()" /></td>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="kwhon" value="kwhon" />
	
    </form>
