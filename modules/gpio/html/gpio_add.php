<?php 
$gpioad = isset($_POST['gpioad']) ? $_POST['gpioad'] : '';
$add = isset($_POST['add']) ? $_POST['add'] : '';
$gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$check = '';
$map_num=substr(rand(), 0, 4);

if ( $add == "ADD") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$dbmaps = new PDO('sqlite:dbf/nettemp.db');
	if (!empty($gpioad)) { 
	    $db->exec("INSERT INTO gpio (gpio, name, status, fnum, map_pos, map_num, map, position) VALUES ('$gpio','new_$gpio','OFF','1', '{left:0,top:0}', '$map_num', 'on', '1' )") or exit(header("Location: html/errors/db_error.php"));
		$inserted=$db->query("SELECT id FROM gpio WHERE gpio='$gpio'");
		$inserted_id=$inserted->fetchAll();
		$inserted_id=$inserted_id[0];
		//maps settings
		$dbmaps->exec("INSERT INTO maps (type,element_id,map_num,map_pos, map_on) VALUES ('gpio', '$inserted_id[id]', '$map_num', '{left:0,top:0}', 'on')");
	}
	else {	
	    $db->exec("DELETE FROM gpio WHERE gpio='$gpio'") or exit(header("Location: html/errors/db_error.php"));
	}
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
}

$gpiodel = isset($_POST['gpiodel']) ? $_POST['gpiodel'] : '';
    if ($gpiodel == "gpiodel")  {
	//maps settings
	$to_delete=$db->query("SELECT id FROM gpio WHERE gpio='$gpio_post'");
	$to_delete_id=$to_delete->fetchAll();
	$to_delete_id=$to_delete_id[0];
	$dbmaps->exec("DELETE FROM maps WHERE element_id='$to_delete_id[id]' AND type='gpio'") or die ($db->lastErrorMsg());
	
    $db->exec("DELETE FROM gpio WHERE gpio='$gpio_post'") or die ($db->lastErrorMsg());
    $db = null;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

?>
<?php

$wp = '/usr/local/bin/gpio';

if (file_exists($wp)) {


    exec("$wp -v |grep B+", $bplus );
    exec("$wp -v |grep 'Model B, Revision: 2'", $btwo );
    exec("$wp -v |grep 'Model B, Revision: 1'", $bone );
    exec("$wp -v |grep 'Model 2, Revision:'", $two );
    exec("$wp -v |grep 'Pi 2, Revision:'", $two );
    exec("$wp -v |grep 'Pi Zero, Revision:'", $zero );
    exec("$wp -v |grep 'Pi 3, Revision'", $three );
    exec("$wp -v |grep 'ODROID-C1/C1+, Revision: 1'", $cplus );
    if ((!empty($bplus[0])) || (!empty($two[0])) || (!empty($zero[0])) || (!empty($three[0])) )
    {
        $gpiolist = array(4,17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
    }
    elseif (!empty($btwo[0]))
    {
        $gpiolist = array(4,17,27,22,18,23,24,25,28,29,30,31);
    }
    elseif (!empty($bone[0]))
    {
        $gpiolist = array(4,17,21,22,18,23,24,25);
    }
    elseif (!empty($cplus[0]))
    {
   		$gpiolist = array(83,88,116,115,101,100,108,97,87,104,102,103,118,99,98);
    }
    else
    {
	$gpiolist = array(4,17,21,22,18,23,24,25);
    } 

	$db = new PDO('sqlite:dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM settings WHERE id='1'") or exit(header("Location: html/errors/db_error.php"));
	$row = $rows->fetchAll();
	foreach ($row as $result) { 
   	    $MCP23017 = $result['MCP23017'];
	}
	if ($MCP23017 == 'on') {
	    array_push($gpiolist,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115);
	}
    
}


else { 
    $gpiolist = array(1,2,3);
?>

<span class="label label-warning">Warning: No wiringPi package</span>
<?php 
    }
?>
<div class="panel panel-default">
<div class="panel-heading">Free</div>
<div class="panel-body">

<?php
foreach ($gpiolist as $value1) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM gpio WHERE gpio='$value1'") or exit(header("Location: html/errors/db_error.php"));
	$row = $rows->fetchAll();
	foreach ($row as $result) { 
   	    $added[] = $result['gpio'];
	}
       if (!in_array($value1, $added)){ ?>
	<form action="" method="post" style=" display:inline!important;">
	    <button type="submit" name="gpioad"  value="on" class="btn btn-xs btn-success" onchange="this.form.submit()" ><span class="glyphicon glyphicon-play" aria-hidden="true"></span> GPIO <?php echo $value1; ?></button>
	    <input type="hidden" name="gpio" value="<?php echo $value1 ?>" />
	    <input type="hidden" name="add" value="ADD" />
	</form>
	<?php
	    }

       //if (in_array($value1, $added)){ 
	?>
	<!-- <form action="" method="post" style=" display:inline!important;">
	    <button type="submit" name="gpiodel"  value="gpiodel" class="btn btn-xs btn-danger" onchange="this.form.submit()" ><span class="glyphicon glyphicon-stop" aria-hidden="true"></span> GPIO <?php echo $value1; ?></button>
	    <input type="hidden" name="gpio" value="<?php echo $value1 ?>" />
	    <input type="hidden" name="add" value="ADD" />
	</form>
	-->

	<?php
	//    }
}
?>
    
<span id="helpBlock" class="help-block">Note: Do not use GPIO4 when use 1wire sensors connected to GPIO4 
<br/>
<?php if (!empty($bplus[0])) {
	echo $bplus[0];
	} elseif (!empty($btwo[0])) {
	    echo $btwo[0];
	} elseif (!empty($bone[0])) {
	    echo $bone[0];
	} elseif (!empty($two[0])) {
	    echo $two[0];
	}
?>
</span>
</div></div>
