<?php 
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : '';
$perms = isset($_SESSION["perms"]) ? $_SESSION["perms"] : '';
if( $user == 'admin'){

?>

<?php
$db = new PDO('sqlite:dbf/nettemp.db');
$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
$relay = isset($_POST['relay']) ? $_POST['relay'] : '';
$rom = isset($_POST['rom']) ? $_POST['rom'] : '';
$ronoff = isset($_POST['ronoff']) ? $_POST['ronoff'] : '';
if (($ronoff == "ronoff")){
    if ($relay == 'on' ){
		$ch = curl_init();
		$optArray = array(
			CURLOPT_URL => "$ip/seton",
			CURLOPT_RETURNTRANSFER => true
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

$db = new PDO('sqlite:dbf/nettemp.db');
$sth2 = $db->prepare("SELECT * FROM sensors WHERE type='relay'");
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ( $result2 as $r) {
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


<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><?php echo $r['name']; ?></h3>
</div>
<div class="panel-body">
    <form action="" method="post">
    <input type="checkbox"  data-toggle="toggle"  onchange="this.form.submit()" name="relay" value="<?php echo $o == 'on'  ? 'off' : 'on'; ?>" <?php echo $o == 'on' ? 'checked="checked"' : ''; ?>  />
    <input type="hidden" name="ip" value="<?php echo $r['ip']; ?>"/>
    <input type="hidden" name="rom" value="<?php echo $r['rom']; ?>"/>
    <input type="hidden" name="ronoff" value="ronoff" />
</form>
</div></div>
<?php
unset($i);
}

}
?>
