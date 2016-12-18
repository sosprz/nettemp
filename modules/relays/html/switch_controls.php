<?php 
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : '';
$perms = isset($_SESSION["perms"]) ? $_SESSION["perms"] : '';
if( $user == 'admin'){

?>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
$switch = isset($_POST['switch']) ? $_POST['switch'] : '';
$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
$gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';
$sonoff = isset($_POST['sonoff']) ? $_POST['sonoff'] : '';


if (($sonoff == "sonoff")){


    if ($switch == 'on' ){
		
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/control?cmd=GPIO,$gpio,1",
			CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);

		$dbf = new PDO("sqlite:db/$rom.sql");
		$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('1')");
		$db->exec("UPDATE sensors SET tmp='1.0' WHERE rom='$rom'");
		
     } else { 
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/control?cmd=GPIO,$gpio,0",
			CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);
		
		$dbf = new PDO("sqlite:db/$rom.sql");
		$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('0')");
		$db->exec("UPDATE sensors SET tmp='0.0' WHERE rom='$rom'");
	}
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

$db = new PDO('sqlite:dbf/nettemp.db');
$sth2 = $db->prepare("SELECT * FROM sensors WHERE type='switch'");
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ( $result2 as $r) {
?>


<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $r['name']; ?></h3>
</div>
<div class="panel-body">
    <form action="" method="post">
    <input type="checkbox"  data-toggle="toggle"  onchange="this.form.submit()" name="switch" value="<?php echo $r['tmp'] == '1.0'  ? 'off' : 'on'; ?>" <?php echo $r['tmp'] == '1.0' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="ip" value="<?php echo $r['ip']; ?>"/>
    <input type="hidden" name="rom" value="<?php echo $r['rom']; ?>"/>
     <input type="hidden" name="gpio" value="<?php echo $r['gpio']; ?>"/>
    <input type="hidden" name="sonoff" value="sonoff" />
</form>
</div></div>
<?php

}

}
?>
