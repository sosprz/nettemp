<?php
session_start();
$root=$_SERVER["DOCUMENT_ROOT"];
if(isset($_SESSION['user'])){
	
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$sth = $db->prepare("SELECT ip,rom,gpio,name,tmp FROM sensors WHERE type='relay'");
$sth->execute();
$result = $sth->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { 


$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
$relay = isset($_POST['relay']) ? $_POST['relay'] : '';
$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
$ronoff = isset($_POST['ronoff']) ? $_POST['ronoff'] : '';
if (($ronoff == "ronoff")){
    if ($relay == 'on' ){
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/seton",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);
		$dbf = new PDO("sqlite:db/$rom.sql");
		$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('1')");
		$db->exec("UPDATE sensors SET tmp='1' WHERE rom='$rom'");

     } else { 
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/setoff",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT => 3
		);
		curl_setopt_array($ch, $optArray);
		$res = curl_exec($ch);
		$dbf = new PDO("sqlite:db/$rom.sql");
		$dbf->exec("INSERT OR IGNORE INTO def (value) VALUES ('0')");
		$db->exec("UPDATE sensors SET tmp='0' WHERE rom='$rom'");
	}
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }


?>
<div class="grid-item recon">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Relays (Wireless)</h3>
</div>
<div class="panel-body">
<?php
foreach ( $result as $r) {
$ip=$r['ip'];

$ch = curl_init();
$optArray = array(
    CURLOPT_URL => "$ip/showstatus",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 1,
	CURLOPT_TIMEOUT => 3
);
curl_setopt_array($ch, $optArray);
$res = curl_exec($ch);

$o1=str_replace('status', '', $res);
$o=strtolower(trim($o1));
?>
<form class="form-horizontal" action="" method="post">
<fieldset>

<div class="form-group">
  <label class="col-md-5 control-label" for="relay"><?php echo $r['name']; ?></label>
  <div class="col-md-5">
    <label class="checkbox-inline" for="checkboxes-0">
	    <input type="checkbox"  data-toggle="toggle"  onchange="this.form.submit()" name="relay" value="<?php echo $o == 'on'  ? 'off' : 'on'; ?>" <?php echo $o == 'on' ? 'checked="checked"' : ''; ?>  />
		<input type="hidden" name="ip" value="<?php echo $r['ip']; ?>"/>
		<input type="hidden" name="rom" value="<?php echo $r['rom']; ?>"/>
		<input type="hidden" name="gpio" value="<?php echo $r['gpio']; ?>"/>
		<input type="hidden" name="ronoff" value="ronoff" />
    </label>
   </div>
</div>

</fieldset>
</form>
<?php
unset($i);
}
?>
</div></div>
</div>
<?php
}
}
?>

