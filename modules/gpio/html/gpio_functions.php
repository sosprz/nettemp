<?php

//time
    $timeon = isset($_POST['timeon']) ? $_POST['timeon'] : '';
    if ($timeon == "timeon")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='time' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//temp
    $tempon = isset($_POST['tempon']) ? $_POST['tempon'] : '';
    if ($tempon == "tempon")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='temp' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//humid
    $humidon = isset($_POST['humidon']) ? $_POST['humidon'] : '';
    if ($humidon == "humidon")  {
	$db->exec("UPDATE gpio SET mode='humid' WHERE gpio='$gpio_post'") or die("exec error");
	$id_rom_newh='gpio_'.$gpio_post.'_humid';
	$id_rom_newt='gpio_'.$gpio_post.'_temp';
	$id_rom_h='gpio_'.$gpio_post.'_humid.sql';
	$id_rom_t='gpio_'.$gpio_post.'_temp.sql';
	$rand=substr(rand(), 0, 4);
	$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio) VALUES ('$rand','$id_rom_newh', 'humid', 'off', 'wait', '$gpio_post' )") or die ("cannot insert to DB humi" );
	$rand=substr(rand(), 0, 4);
	$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio) VALUES ('$rand','$id_rom_newt', 'temp', 'off', 'wait', '$gpio_post' )") or die ("cannot insert to DB temp" );
	$dbnew = new PDO("sqlite:db/$id_rom_h");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
	$dbnew = new PDO("sqlite:db/$id_rom_t");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEEGER)");
	$db->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$id_rom_newh')") or die ("cannot insert to newdev" );
	$db->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$id_rom_newt')") or die ("cannot insert to newdev" );
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//dayon
    $dayon = isset($_POST['dayon']) ? $_POST['dayon'] : '';
    if ($dayon == "dayon")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='day' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//weekon
    $weekon = isset($_POST['weekon']) ? $_POST['weekon'] : '';
    if ($weekon == "weekon")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='week' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }


//triggeron
    $triggeron = isset($_POST['triggeron']) ? $_POST['triggeron'] : '';
    if ($triggeron == "triggeron")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='trigger' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//kwh
    $kwhon = isset($_POST['kwhon']) ? $_POST['kwhon'] : '';
    if ($kwhon == "kwhon")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='kwh' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
//simple
    $simpleon = isset($_POST['simpleon']) ? $_POST['simpleon'] : '';
    if ($simpleon == "simpleon")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='simple' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }
    $momenton = isset($_POST['momenton']) ? $_POST['momenton'] : '';
    if ($momenton == "momenton")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='moment' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

//buzzer
    $buzzeron = isset($_POST['buzzeron']) ? $_POST['buzzeron'] : '';
    if ($buzzeron == "buzzeron")  {
//	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET mode='buzzer', status='' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

//triggerout
    $triggerout = isset($_POST['triggerout']) ? $_POST['triggerout'] : '';
    if ($triggerout == "triggerout")  {
	$db->exec("UPDATE gpio SET mode='triggerout', status='' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

//call
    $call = isset($_POST['call']) ? $_POST['call'] : '';
    if ($call == "on")  {
	$db->exec("UPDATE gpio SET mode='call', status='' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

//functiononoff
    $control = isset($_POST['control']) ? $_POST['control'] : '';
    if ($control == "on")  {
	$db->exec("UPDATE gpio SET mode='control', status='' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $led = isset($_POST['led']) ? $_POST['led'] : '';
    if ($led == "on")  {
	$db->exec("UPDATE gpio SET mode='led', status='' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $gpiodel = isset($_POST['gpiodel']) ? $_POST['gpiodel'] : '';
    if ($gpiodel == "gpiodel")  {
	$db->exec("DELETE FROM gpio WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }


include('gpio_rev.php');
?>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Simple on/off</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="simpleon" value="simpleon" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Moment on/off</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="momenton" value="momenton" />
    </form>

    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Time</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeon" value="timeon" />   
   </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Day plan</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayon" value="dayon" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Week plan</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="weekon" value="weekon" />
    </form>

    <form action="" method="post" style=" display:inline!important;">
	<button class="btn btn-xs btn-primary">Temperature</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempon" value="tempon" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">DHT11/22</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio'];?>"/>
	<input type="hidden" name="humidon" value="humidon" />
    </form> 
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Trigger</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggeron" value="triggeron" />
    </form>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Trigger out</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggerout" value="triggerout" />
    </form>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Control</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="control" value="on" />
	
    </form>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">On/Off on 2sec over call</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="call" value="on" />
    </form>
<?php 
if (empty($mode4)){ ?>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">LED</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="led" value="on" />
	
    </form>
<?php 
}
if (empty($mode3)){ ?>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">kWh</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="kwhon" value="kwhon" />
    </form>
<?php 
}
if (empty($mode2)) { ?>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-primary">Buzzer</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="buzzeron" value="buzzeron" />
    </form>

    <form action="" method="post" style="display:inline!important;">
        <input type="hidden" name="gpio" value="<?php echo $a["gpio"]; ?>" />
        <input type="hidden" type="submit" name="gpiodel" value="gpiodel" />
        <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
    </form>


<?php 
}
?>


