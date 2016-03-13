<?php
$map_num=substr(rand(), 0, 4);

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
	$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio, adj, charts, device, map_pos, map_num, map) VALUES ('$rand','$id_rom_newh', 'humid', 'off', 'wait', '$gpio_post', '0', 'on', 'gpio', '{left:0,top:0}', '$map_num', 'on')") or die ("cannot insert to DB humi" );
	//maps
	$inserted=$db->query("SELECT id FROM sensors WHERE rom='$id_rom_newh'");
	$inserted_id=$inserted->fetchAll();
	$inserted_id=$inserted_id[0];
	$db->exec("INSERT OR IGNORE INTO maps (type, element_id, map_pos, map_num) VALUES ('sensors', '$inserted_id[id]','{left:0,top:0}', '$map_num')");
	$rand=substr(rand(), 0, 4);
	$db->exec("INSERT OR IGNORE INTO sensors (name, rom, type, alarm, tmp, gpio, adj, charts, device, map_pos, map_num, map) VALUES ('$rand','$id_rom_newt', 'temp', 'off', 'wait', '$gpio_post', '0', 'on', 'gpio', '{left:0,top:0}', '$map_num', 'on')") or die ("cannot insert to DB temp" );
	//maps
	$inserted=$db->query("SELECT id FROM sensors WHERE rom='$id_rom_newt'");
	$inserted_id=$inserted->fetchAll();
	$inserted_id=$inserted_id[0];
	$db->exec("INSERT OR IGNORE INTO maps (type, element_id, map_pos, map_num) VALUES ('sensors', '$inserted_id[id]','{left:0,top:0}', '$map_num')");
	$dbnew = new PDO("sqlite:db/$id_rom_h");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
	$dbnew = new PDO("sqlite:db/$id_rom_t");
	$dbnew->exec("CREATE TABLE def (time DATE DEFAULT (datetime('now','localtime')), value INTEGER)");
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
	$db->exec("UPDATE gpio SET mode='kwh' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $elecon = isset($_POST['elecon']) ? $_POST['elecon'] : '';
    if ($elecon == "elecon")  {
	$db->exec("UPDATE gpio SET mode='elec' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $wateron = isset($_POST['wateron']) ? $_POST['wateron'] : '';
    if ($wateron == "wateron")  {
	$db->exec("UPDATE gpio SET mode='water' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $gason = isset($_POST['gason']) ? $_POST['gason'] : '';
    if ($gason == "gason")  {
	$db->exec("UPDATE gpio SET mode='gas' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $readon = isset($_POST['readon']) ? $_POST['readon'] : '';
    if ($readon == "readon")  {
	$db->exec("UPDATE gpio SET mode='read' WHERE gpio='$gpio_post'") or die("exec error");
	$db = null;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
    }

    $diston = isset($_POST['diston']) ? $_POST['diston'] : '';
    if ($diston == "diston")  {
	$db->exec("UPDATE gpio SET mode='dist' WHERE gpio='$gpio_post'") or die("exec error");
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
			$dbmaps = new PDO('sqlite:dbf/nettemp.db');
			//maps settings
			$to_delete=$db->query("SELECT id FROM gpio WHERE gpio='$gpio_post'");
			$to_delete_id=$to_delete->fetchAll();
			$to_delete_id=$to_delete_id[0];
			if ($to_delete_id['id'] != '') {
			$dbmaps->exec("DELETE FROM maps WHERE element_id='$to_delete_id[id]' AND type='gpio'");// or exit(header("Location: html/errors/db_error.php"));
			}
			$db->exec("DELETE FROM gpio WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
			$db = null;
			header("location: " . $_SERVER['REQUEST_URI']);
			exit();
			}




?>
<table>
<td class="col-md-2">
<?php
include('gpio_name.php');
?>
</td>
<td class="col-md-1">
<?php
include('gpio_rev.php');
?>
<td>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success">Simple on/off</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="simpleon" value="simpleon" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Moment on/off</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="momenton" value="momenton" />
    </form>

    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Time</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="timeon" value="timeon" />   
   </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Day-Week plan</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="dayon" value="dayon" />
    </form>
<!--    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Week plan</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="weekon" value="weekon" />
    </form>
-->
    <form action="" method="post" style=" display:inline!important;">
	<button class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Temperature</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="tempon" value="tempon" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>DHT11/22</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio'];?>"/>
	<input type="hidden" name="humidon" value="humidon" />
    </form> 
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Trigger</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggeron" value="triggeron" />
    </form>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Trigger out</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="triggerout" value="triggerout" />
    </form>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Control</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="control" value="on" />
	
    </form>
<?php
//if (empty($mode5)){ ?>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>On/Off on 2sec over call</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="call" value="on" />
    </form>
<?php 
//}
if (empty($mode4)){ ?>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>LED</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="led" value="on" />
	
    </form>
<?php 
}
if (empty($mode2)) { ?>
    <form action="" method="post" style="display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success" <?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Buzzer</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="buzzeron" value="buzzeron" />
    </form>
<?php 
}
?>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success" <?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Electricity counter</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="elecon" value="elecon" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success" <?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Water counter</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="wateron" value="wateron" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Gas counter</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="gason" value="gason" />
    </form>
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Read status</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="readon" value="readon" />
    </form>
<?php 
    if ($a['gpio']=='23' || $a['gpio']=='24') { 
?>  
    <form action="" method="post" style=" display:inline!important;">
	<button type="submit" class="btn btn-xs btn-success"<?php echo $a['gpio']>='100' ? 'disabled': '' ?>>Distance</button>
	<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	<input type="hidden" name="diston" value="diston" />
    </form>
<?php 
    }
?>
</td>
<td class="col-md-1">
<form action="" method="post" style="display:inline!important;">
        <input type="hidden" name="gpio" value="<?php echo $a["gpio"]; ?>" />
        <input type="hidden" type="submit" name="gpiodel" value="gpiodel" />
        <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-stop"></span> Remove</button>
</form>
</td>
</table>





