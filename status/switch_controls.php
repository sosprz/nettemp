
<?php
session_start();
$root=$_SERVER["DOCUMENT_ROOT"];
if(isset($_SESSION['user'])){

$db = new PDO("sqlite:$root/dbf/nettemp.db");
$sth = $db->prepare("SELECT ip,rom,gpio,name,tmp FROM sensors WHERE type='switch'");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { 

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
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
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
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
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
?>
<div class="grid-item swcon">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">IP Switch</h3>
</div>
<div class="panel-body">
<?php
foreach ( $result as $r) {
?>
<form class="form-horizontal" action="" method="post">
<fieldset>
<div class="form-group">
  <label class="col-md-5 control-label" for="switch"><?php echo $r['name']; ?></label>
  <div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
		<input type="checkbox"  data-toggle="toggle"  onchange="this.form.submit()" name="switch" value="<?php echo $r['tmp'] == '1.0'  ? 'off' : 'on'; ?>" <?php echo $r['tmp'] == '1.0' ? 'checked="checked"' : ''; ?>  />
		<input type="hidden" name="ip" value="<?php echo $r['ip']; ?>"/>
		<input type="hidden" name="rom" value="<?php echo $r['rom']; ?>"/>
		<input type="hidden" name="gpio" value="<?php echo $r['gpio']; ?>"/>
		<input type="hidden" name="sonoff" value="sonoff" />
    </label>
   </div>
</div>
</fieldset>
</form>
<?php
}
?>
</div></div>
</div>
<?php
}
} 
?>


